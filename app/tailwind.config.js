/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./**/*.php",
        "./**/*.html",
        "./**/*.js",
        "./index.php"
    ],
    theme: {
        extend: {
            colors: {
                'accent': '#2E1F27',
                'primary': '#854D27',
                'highlight': '#DD7230',
                'secondary': '#F4C95D',
                'light': '#E7E393',
            }
        }
    },
    plugins: [],
}