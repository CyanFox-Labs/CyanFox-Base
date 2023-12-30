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

        './app/Livewire/**/*List.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php',

        './vendor/robsontenorio/mary/src/View/Components/**/*.php'
    ],
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                catppuccin_latte: {
                    "primary": "#d20f39",
                    "secondary": "#179299",
                    "accent": "#40a02b",
                    "neutral": "#4c4f69",
                    "base-100": "#eff1f5",
                    "info": "#04a5e5",
                    "success": "#8839ef",
                    "warning": "#fe640b",
                    "error": "#dd7878",
                },
                catppuccin_frappee: {
                    "primary": "#e78284",
                    "secondary": "#81c8be",
                    "accent": "#a6d189",
                    "neutral": "#c6d0f5",
                    "base-100": "#303446",
                    "info": "#99d1db",
                    "success": "#ca9ee6",
                    "warning": "#ef9f76",
                    "error": "#eebebe"
                },
                catppuccin_macchiato: {
                    "primary": "#ed8796",
                    "secondary": "#8bd5ca",
                    "accent": "#a6da95",
                    "neutral": "#cad3f5",
                    "base-100": "#24273a",
                    "info": "#91d7e3",
                    "success": "#c6a0f6",
                    "warning": "#f5a97f",
                    "error": "#f0c6c6"
                },
                catppuccin_mocha: {
                    "primary": "#f38ba8",
                    "secondary": "#94e2d5",
                    "accent": "#a6e3a1",
                    "neutral": "#cdd6f4",
                    "base-100": "#1e1e2e",
                    "info": "#89dceb",
                    "success": "#cba6f7",
                    "warning": "#fab387",
                    "error": "#f2cdcd"
                },
            },
            "light",
            "dark",
            "cupcake",
            "bumblebee",
            "emerald",
            "corporate",
            "synthwave",
            "retro",
            "cyberpunk",
            "valentine",
            "halloween",
            "garden",
            "forest",
            "aqua",
            "lofi",
            "pastel",
            "fantasy",
            "wireframe",
            "black",
            "luxury",
            "dracula",
            "cmyk",
            "autumn",
            "business",
            "acid",
            "lemonade",
            "night",
            "coffee",
            "winter",
            "dim",
            "nord",
            "sunset",
        ],
    },
}
