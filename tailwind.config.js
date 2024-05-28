import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    presets: [
        require('./vendor/tallstackui/tallstackui/tailwind.config.js')
    ],
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/**/*.php',
        './modules/**/*.php',

        './vendor/tallstackui/tallstackui/src/**/*.php',
    ],
    theme: {
        extend: {},
    },
    plugins: [forms],
}

