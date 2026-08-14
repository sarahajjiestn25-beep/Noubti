import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/**
 * Global theme colors are injected at runtime from the `configurations`
 * table (couleur_primaire / couleur_secondaire) via CSS custom properties
 * defined in the main layouts:
 *
 *   --primary-color
 *   --secondary-color
 *
 * The `indigo` palette is mapped to the primary color and the `blue`
 * palette to the secondary color. Shades are derived from the base color
 * with color-mix() so the existing visual design (light backgrounds,
 * hover states, etc.) is preserved while following the configured colors.
 */
const primary = {
    50: 'color-mix(in srgb, var(--primary-color) 8%, white)',
    100: 'color-mix(in srgb, var(--primary-color) 15%, white)',
    200: 'color-mix(in srgb, var(--primary-color) 25%, white)',
    300: 'color-mix(in srgb, var(--primary-color) 40%, white)',
    400: 'color-mix(in srgb, var(--primary-color) 55%, white)',
    500: 'color-mix(in srgb, var(--primary-color) 75%, white)',
    600: 'var(--primary-color)',
    700: 'color-mix(in srgb, var(--primary-color) 85%, black)',
    800: 'color-mix(in srgb, var(--primary-color) 70%, black)',
    900: 'color-mix(in srgb, var(--primary-color) 55%, black)',
    950: 'color-mix(in srgb, var(--primary-color) 40%, black)',
};

const secondary = {
    50: 'color-mix(in srgb, var(--secondary-color) 8%, white)',
    100: 'color-mix(in srgb, var(--secondary-color) 15%, white)',
    200: 'color-mix(in srgb, var(--secondary-color) 25%, white)',
    300: 'color-mix(in srgb, var(--secondary-color) 40%, white)',
    400: 'color-mix(in srgb, var(--secondary-color) 55%, white)',
    500: 'color-mix(in srgb, var(--secondary-color) 75%, white)',
    600: 'var(--secondary-color)',
    700: 'color-mix(in srgb, var(--secondary-color) 85%, black)',
    800: 'color-mix(in srgb, var(--secondary-color) 70%, black)',
    900: 'color-mix(in srgb, var(--secondary-color) 55%, black)',
    950: 'color-mix(in srgb, var(--secondary-color) 40%, black)',
};

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                indigo: primary,
                blue: secondary,
            },
        },
    },

    plugins: [forms],
};