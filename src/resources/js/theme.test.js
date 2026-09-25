import test from 'node:test';
import assert from 'node:assert/strict';

import { getThemeState, syncBrandLogos, applyTheme } from './theme.js';

const createLogo = (lightSrc, darkSrc) => {
    const attrs = new Map();
    const logo = {
        dataset: { lightLogo: lightSrc, darkLogo: darkSrc },
        getAttribute(name) {
            return attrs.get(name) ?? null;
        },
        setAttribute(name, value) {
            attrs.set(name, value);
        },
    };

    return logo;
};

test('getThemeState prefers dark when class or data attribute indicates it', () => {
    const darkRoot = {
        classList: { contains: (name) => name === 'dark' },
        getAttribute: (name) => (name === 'data-theme' ? 'dark' : null),
    };

    assert.equal(getThemeState(darkRoot), 'dark');
});

test('syncBrandLogos swaps to the dark asset when dark mode is active', () => {
    const root = {
        classList: { contains: (name) => name === 'dark' },
        getAttribute: (name) => (name === 'data-theme' ? 'dark' : null),
    };
    const logo = createLogo('light.png', 'dark.png');

    syncBrandLogos(root, [logo]);

    assert.equal(logo.getAttribute('src'), 'dark.png');
    assert.equal(logo.getAttribute('data-current-theme'), 'dark');
});

test('applyTheme sets the root state and stores the selected theme', () => {
    const storage = { value: 'light', setItem(key, value) { this.value = value; } };
    const root = {
        classList: { toggle: () => {}, contains: () => false },
        setAttribute: () => {},
        getAttribute: () => null,
    };
    const initialDocument = globalThis.document;

    globalThis.document = {
        querySelectorAll: () => [],
    };

    try {
        applyTheme('dark', { root, storage });
        assert.equal(storage.value, 'dark');
        assert.equal(root.getAttribute, root.getAttribute);
    } finally {
        globalThis.document = initialDocument;
    }
});
