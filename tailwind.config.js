/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                dark: {
                    DEFAULT: "#101318",
                },
                light: {
                    DEFAULT: "#dee2e6",
                },
                primary: {
                    DEFAULT: "#f9b81f",
                    50: "#fef9eb",
                    100: "#fef2d7",
                    200: "#fde7b4",
                    300: "#fcd783",
                    400: "#fbc851",
                    500: "#f9b81f",
                    600: "#e09e06",
                    700: "#ae7b04",
                    800: "#7c5803",
                    900: "#4b3502",
                },
                background: "rgb(var(--color-bg) / <alpha-value>)",
                foreground: "rgb(var(--color-light) / <alpha-value>)",
            },
        },
    },
    plugins: [],
};
