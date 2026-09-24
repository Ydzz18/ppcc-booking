import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
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
		window.requestAnimationFrame(() => formToSubmit.submit());
	});

	document.querySelectorAll('form[data-confirm]').forEach((form) => {
		form.addEventListener('submit', (event) => {
			if (form.dataset.skipConfirm === 'true') {
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
});
