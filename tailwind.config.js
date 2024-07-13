import forms from '@tailwindcss/forms';
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    presets: [
        require('./vendor/tallstackui/tallstackui/tailwind.config.js'),
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
        preset,
    ],
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',

        './app/**/*.php',

        './modules/**/*.php',
        './modules/**/*.blade.php',

        './lang/**/*.php',

        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php',

        './vendor/filament/**/*.blade.php',
        './vendor/tallstackui/tallstackui/src/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                'pg-primary': {
                    DEFAULT: '#1d232a',
                    '700': '#1d232a',
                    '800': '#1d232a',
                },
                'primary': {
                    DEFAULT: '#4E5BA6',
                    '50': '#F8F9FC',
                    '100': '#EAECF5',
                    '200': '#C8CCE5',
                    '300': '#9EA5D1',
                    '400': '#717BBC',
                    '500': '#4E5BA6',
                    '600': '#3E4784',
                    '700': '#363F72',
                    '800': '#293056',
                    '900': '#101323',
                    '950': '#0D0F1C',
                },
                'secondary': {
                    DEFAULT: '#b5b5b5',
                    '50': '#f7f7f7',
                    '100': '#ededed',
                    '200': '#dfdfdf',
                    '300': '#c8c8c8',
                    '400': '#b5b5b5',
                    '500': '#999999',
                    '600': '#888888',
                    '700': '#7b7b7b',
                    '800': '#676767',
                    '900': '#545454',
                    '950': '#363636',
                },
                'dark': {
                    DEFAULT: '#1d232a',
                    '50': '#CED9E1',
                    '100': '#B9C5CD',
                    '200': '#A5B0B8',
                    '300': '#8C97A0',
                    '400': '#727E88',
                    '500': '#596470',
                    '600': '#40434E',
                    '700': '#1d232a',
                    '800': '#171C20',
                    '900': '#111517',
                    '950': '#0B0E0E',
                },
            }
        },
    },
    plugins: [forms],
}

