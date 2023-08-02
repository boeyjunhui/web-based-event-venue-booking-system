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
            "brown-100": "#dfd8c9",
            "brown-300": "#cabda5",
            "brown-500": "#b8a585",
            "brown-700": "#a9936d"
        }
    },
  },
  plugins: [],
}
