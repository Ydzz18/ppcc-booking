import './bootstrap';

import Alpine from 'alpinejs';
import { applyTheme, syncBrandLogos } from './theme';

window.Alpine = Alpine;

Alpine.data('liveNotifications', (initialCount, initialNotifications, endpoint) => ({
	notificationsOpen: false,
	notificationCount: initialCount,
	headerNotifications: initialNotifications,
	seenNotificationIds: new Set(initialNotifications.map((notification) => notification.id)),
	toast: null,
	toastTimeout: null,
	pollInterval: null,

	start() {
		this.pollInterval = window.setInterval(() => this.refresh(), 15000);
		window.addEventListener('task-entry-created', () => this.refresh());
	},

	async refresh() {
		try {
			const response = await fetch(endpoint, {
				credentials: 'same-origin',
				headers: { Accept: 'application/json' },
			});

			if (!response.ok) return;

			const data = await response.json();
			const unseen = data.notifications.find((notification) => !this.seenNotificationIds.has(notification.id));

			this.notificationCount = data.count;
			this.headerNotifications = data.notifications;
			data.notifications.forEach((notification) => this.seenNotificationIds.add(notification.id));

			if (unseen) this.showToast(unseen);
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
