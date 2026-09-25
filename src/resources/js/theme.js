export const getThemeState = (root = document.documentElement) => {
    if (!root) {
        return 'light';
    }

    return root.classList.contains('dark') || root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
};

export const syncBrandLogos = (root = document.documentElement, logos = root?.ownerDocument?.querySelectorAll('.app-logo[data-light-logo][data-dark-logo]') ?? []) => {
    const isDark = getThemeState(root) === 'dark';

    logos.forEach((logo) => {
        const lightSrc = logo.dataset.lightLogo;
        const darkSrc = logo.dataset.darkLogo;
        const nextSrc = isDark ? darkSrc : lightSrc;

        if (logo.getAttribute('src') !== nextSrc) {
            logo.setAttribute('src', nextSrc);
        }

        logo.setAttribute('data-current-theme', isDark ? 'dark' : 'light');
    });
};

export const applyTheme = (theme, { root = document.documentElement, storage = globalThis.localStorage } = {}) => {
    const nextTheme = theme === 'dark' ? 'dark' : 'light';

    if (root) {
        root.classList.toggle('dark', nextTheme === 'dark');
        root.setAttribute('data-theme', nextTheme);
    }

    if (storage) {
        try {
            storage.setItem('theme', nextTheme);
        } catch (error) {
            // Storage may be unavailable in some browser contexts.
        }
    }

    syncBrandLogos(root);

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const icon = button.querySelector('[data-theme-icon]');
        if (icon) {
            icon.setAttribute('aria-label', nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
        }
        button.setAttribute('aria-label', nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
    });
};
