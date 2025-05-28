/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./**/*.php",
        "./**/*.html",
        "./**/*.js",
        "./index.php",
        "./style/**/*.css"
    ],
    theme: {
        extend: {
            colors: {
                'accent': '#2E1F27',
                'primary': '#854D27',
                'highlight': '#DD7230',
                'secondary': '#F4C95D',
                'light': '#E7E393',
            },
            fontFamily: {
                'sans': ['Century Gothic', 'CenturyGothic', 'AppleGothic', 'sans-serif'],
                'serif': ['Georgia', 'Cambria', 'Times New Roman', 'Times', 'serif'],
                'mono': ['Menlo', 'Monaco', 'Consolas', 'Liberation Mono', 'Courier New', 'monospace'],
            },
        }
    },
    plugins: [],
}