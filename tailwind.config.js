/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue",],
    theme: {
        extend: {
            colors: {
                navigation: {
                    DEFAULT: "#171717",
                }
            }
        },
    },
    plugins: [require("daisyui")],
}
