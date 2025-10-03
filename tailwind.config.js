export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/tailwindcss-primeui/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('tailwindcss-primeui')
  ],
}