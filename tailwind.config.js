const colors = require('tailwindcss/colors')
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    presets: [
        preset,
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
    ],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",

        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',

        './app/Http/Livewire/**/*Table.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
    ], theme: {
        extend: {
            colors: {
                "pg-primary": colors.gray,
                navigation: {
                    DEFAULT: "#171717",
                }
            }
        },
    },
    plugins: [require("daisyui")],
    daisyui: {
        themes: ["light", "dark"],
    },
}
