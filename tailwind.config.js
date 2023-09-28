/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue", "./vendor/robsontenorio/mary/src/View/Components/**/*.php",], theme: {
        extend: {
            colors: {
                navigation: {
                    DEFAULT: "#171717",
                }
            }
        },
    }, plugins: [require("daisyui")], daisyui: {
        themes: ["light", "dark"],
    },
}
