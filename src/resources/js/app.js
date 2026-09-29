import './bootstrap';

import Alpine from 'alpinejs';
import { applyTheme, syncBrandLogos } from './theme';

window.Alpine = Alpine;

Alpine.data('liveNotifications', (initialCount, initialNotifications, endpoint, userId) => ({
	notificationsOpen: false,
	notificationCount: initialCount,
	headerNotifications: initialNotifications,
	seenNotificationIds: new Set(initialNotifications.map((notification) => notification.id)),
	viewedAt: null,
	storageKey: `ppcc-booking-notifications-viewed-at-${userId}`,
	toast: null,
	toastTimeout: null,
	pollInterval: null,

	start() {
		try {
			const storedViewedAt = Number(localStorage.getItem(this.storageKey));
			this.viewedAt = Number.isFinite(storedViewedAt) && storedViewedAt > 0 ? storedViewedAt : null;
			if (this.viewedAt) {
				this.notificationCount = this.unreadNotifications(this.headerNotifications).length;
			}
		} catch {
		}

		this.pollInterval = window.setInterval(() => this.refresh(), 15000);
		window.addEventListener('task-entry-created', () => this.refresh());
	},

	unreadNotifications(notifications) {
		return notifications.filter((notification) => Date.parse(notification.created_at) > this.viewedAt);
	},

	markNotificationsViewed() {
		const latestNotificationTime = Math.max(...this.headerNotifications.map((notification) => Date.parse(notification.created_at) || 0));
		this.viewedAt = Math.max(Date.now(), latestNotificationTime);
		this.notificationCount = 0;
		this.headerNotifications.forEach((notification) => this.seenNotificationIds.add(notification.id));

		try {
			localStorage.setItem(this.storageKey, String(this.viewedAt));
		} catch {
		}
	},

	async refresh() {
		try {
			const response = await fetch(endpoint, {
				credentials: 'same-origin',
				headers: { Accept: 'application/json' },
			});

			if (!response.ok) return;

			const data = await response.json();
			const unseen = data.notifications.filter((notification) => !this.seenNotificationIds.has(notification.id));

			this.headerNotifications = data.notifications;
			if (this.viewedAt) {
				this.notificationCount = this.unreadNotifications(data.notifications).length;
			} else {
				this.notificationCount = data.count;
			}

			if (unseen.length > 0) {
				this.showToast(unseen[0]);
				unseen.forEach((notification) => this.seenNotificationIds.add(notification.id));
			}
		} catch {
		}
	},

	showToast(notification) {
		this.toast = notification;
		window.clearTimeout(this.toastTimeout);
		this.toastTimeout = window.setTimeout(() => {
			this.toast = null;
		}, 8000);
	},
}));

const savedTheme = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
const initialTheme = savedTheme ?? (prefersDark ? 'dark' : 'light');

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    applyTheme(initialTheme);
    syncBrandLogos();

	const taskList = document.querySelector('#tasks-lists');
	const taskSearchForm = document.querySelector('#task-search-form');

	if (taskList && taskSearchForm) {
		const feedback = document.querySelector('#task-search-feedback');
		let requestSequence = 0;
		let activeRequest = null;

		const refreshTaskList = async (url, historyMode = 'replace') => {
			const sequence = ++requestSequence;
			activeRequest?.abort();
			activeRequest = new AbortController();
			taskList.setAttribute('aria-busy', 'true');
			feedback?.classList.add('hidden');

			try {
				const response = await fetch(url, {
					credentials: 'same-origin',
					signal: activeRequest.signal,
					headers: { Accept: 'text/html', 'X-Requested-With': 'XMLHttpRequest' },
				});

				if (!response.ok) throw new Error('Task search request failed.');

				const responseDocument = new DOMParser().parseFromString(await response.text(), 'text/html');
				const selectors = ['#task-table-container', '#task-edit-modals', '#task-pagination'];
				const replacements = selectors.map((selector) => responseDocument.querySelector(selector));
				const currentElements = selectors.map((selector) => taskList.querySelector(selector));

				if (replacements.some((element) => !element) || currentElements.some((element) => !element)) {
					throw new Error('Task search results were incomplete.');
				}

				if (sequence !== requestSequence) return;

				currentElements.forEach((element, index) => element.replaceWith(replacements[index]));

				for (const name of ['task_search', 'task_sort', 'task_order']) {
					const currentField = taskSearchForm.elements.namedItem(name);
					const responseField = responseDocument.querySelector(`#task-search-form [name="${name}"]`);
					if (currentField && responseField) currentField.value = responseField.value;
				}

				if (historyMode !== 'none') {
					window.history[historyMode === 'push' ? 'pushState' : 'replaceState']({}, '', response.url);
				}
			} catch (error) {
				if (error.name !== 'AbortError' && sequence === requestSequence) {
					feedback?.classList.remove('hidden');
				}
			} finally {
				if (sequence === requestSequence) {
					taskList.removeAttribute('aria-busy');
				}
			}
		};

		taskSearchForm.addEventListener('submit', (event) => {
			event.preventDefault();
			const url = new URL(taskSearchForm.action, window.location.href);
			url.search = new URLSearchParams(new FormData(taskSearchForm)).toString();
			url.searchParams.delete('tasks_page');
			void refreshTaskList(url, event.submitter ? 'push' : 'replace');
		});

		taskList.addEventListener('click', (event) => {
			const link = event.target.closest('#task-pagination a[href]');
			if (!link || new URL(link.href).origin !== window.location.origin) return;

			event.preventDefault();
			void refreshTaskList(link.href, 'push');
		});

		window.addEventListener('popstate', () => {
			void refreshTaskList(window.location.href, 'none');
		});
	}

    const themeObserver = new MutationObserver((mutations) => {
        for (const mutation of mutations) {
            if (mutation.type === 'attributes' && (mutation.attributeName === 'class' || mutation.attributeName === 'data-theme')) {
                syncBrandLogos();
                break;
            }
        }
    });

    themeObserver.observe(root, {
        attributes: true,
        attributeFilter: ['class', 'data-theme'],
    });

    document.querySelectorAll('[data-theme-toggle]').forEach((toggleButton) => {
        toggleButton.addEventListener('click', () => {
            const nextTheme = root.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(nextTheme);
        });
    });

	const modalRoot = document.createElement('div');
	modalRoot.id = 'global-confirm-modal';
	modalRoot.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/50 p-4';
	modalRoot.innerHTML = `
		<div id="global-confirm-panel" class="w-full max-w-[16rem] rounded-md bg-white p-3 shadow-xl">
			<h3 class="text-base font-semibold text-gray-900">Confirm Submission</h3>
			<p id="global-confirm-message" class="mt-2 text-sm text-gray-600"></p>
			<div class="mt-4 flex justify-end gap-2">
				<button id="global-confirm-cancel" type="button" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</button>
				<button id="global-confirm-submit" type="button" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Confirm</button>
			</div>
		</div>
		<div id="global-confirm-loading" class="hidden w-full max-w-[16rem] rounded-md bg-white p-5 text-center shadow-xl">
			<svg class="mx-auto h-7 w-7 animate-spin text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
				<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
				<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
			</svg>
			<p class="mt-3 text-sm font-medium text-gray-700">Submitting...</p>
		</div>
	`;

	document.body.appendChild(modalRoot);

	const messageEl = modalRoot.querySelector('#global-confirm-message');
	const confirmPanel = modalRoot.querySelector('#global-confirm-panel');
	const loadingPanel = modalRoot.querySelector('#global-confirm-loading');
	const cancelButton = modalRoot.querySelector('#global-confirm-cancel');
	const confirmButton = modalRoot.querySelector('#global-confirm-submit');

	let pendingForm = null;

	const closeModal = () => {
		modalRoot.classList.add('hidden');
		modalRoot.classList.remove('flex');
		modalRoot.removeAttribute('aria-busy');
		confirmPanel?.classList.remove('hidden');
		loadingPanel?.classList.add('hidden');
		if (cancelButton) cancelButton.disabled = false;
		if (confirmButton) confirmButton.disabled = false;
		pendingForm = null;
	};

	const submitMonitoringEntry = async (form) => {
		const feedback = form.querySelector('#task-entry-feedback');
		const showFeedback = (message, isError = false) => {
			if (!feedback) return;

			feedback.textContent = message;
			feedback.className = `md:col-span-4 rounded-md px-4 py-3 text-sm ${isError ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700'}`;
		};

		try {
			const response = await fetch(form.action, {
				method: form.method,
				body: new FormData(form),
				credentials: 'same-origin',
				headers: {
					Accept: 'application/json',
					'X-Requested-With': 'XMLHttpRequest',
				},
			});
			const result = await response.json();

			if (!response.ok) {
				const message = Object.values(result.errors ?? {}).flat().join(' ') || result.message || 'Unable to create this task.';
				showFeedback(message, true);
				return;
			}

			form.reset();
			form.querySelector('#task_agency')?.dispatchEvent(new Event('change', { bubbles: true }));
			form.querySelector('#type_of_task')?.dispatchEvent(new Event('change', { bubbles: true }));
			showFeedback(result.message);

			try {
				const refreshResponse = await fetch(form.dataset.monitoringRefreshUrl, {
					credentials: 'same-origin',
					headers: { Accept: 'text/html' },
				});

				if (!refreshResponse.ok) throw new Error('Monitoring refresh failed.');

				const refreshedDocument = new DOMParser().parseFromString(await refreshResponse.text(), 'text/html');
				const currentSection = document.querySelector('#job-task-monitoring-section');
				const refreshedSection = refreshedDocument.querySelector('#job-task-monitoring-section');

				if (!currentSection || !refreshedSection) throw new Error('Monitoring section unavailable.');

				currentSection.innerHTML = refreshedSection.innerHTML;
				window.dispatchEvent(new CustomEvent('task-entry-created'));
			} catch {
				showFeedback(`${result.message} The monitoring list could not refresh; reload the page to see the new task.`, true);
			}
		} catch {
			showFeedback('Unable to save the task. Check your connection and try again.', true);
		} finally {
			closeModal();
		}
	};

	cancelButton?.addEventListener('click', closeModal);

	modalRoot.addEventListener('click', (event) => {
		if (event.target === modalRoot && pendingForm === null) {
			closeModal();
		}
	});

	confirmButton?.addEventListener('click', () => {
		if (!pendingForm) {
			return;
		}

		const formToSubmit = pendingForm;
		modalRoot.setAttribute('aria-busy', 'true');
		confirmPanel?.classList.add('hidden');
		loadingPanel?.classList.remove('hidden');
		if (cancelButton) cancelButton.disabled = true;
		if (confirmButton) confirmButton.disabled = true;
		if (formToSubmit.matches('[data-async-monitoring-entry]')) {
			void submitMonitoringEntry(formToSubmit);
			return;
		}
		window.requestAnimationFrame(() => formToSubmit.submit());
	});

	document.addEventListener('submit', (event) => {
		const form = event.target.closest('form[data-confirm]');
		if (!form || form.dataset.skipConfirm === 'true') {
			return;
		}

		event.preventDefault();
		pendingForm = form;

		if (messageEl) {
			messageEl.textContent = form.getAttribute('data-confirm') ?? 'Are you sure you want to submit this form?';
		}

		modalRoot.classList.remove('hidden');
		modalRoot.classList.add('flex');
	});
});
