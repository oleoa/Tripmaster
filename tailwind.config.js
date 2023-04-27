/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        turquoise: {
          100: "#80ffdb",
          200: "#72efdd",
          300: "#64dfdf",
          400: "#56cfe1",
          500: "#48bfe3",
          600: "#4ea8de",
          700: "#5390d9",
          800: "#5e60ce",
          900: "#64dfdf",
        }
      }
    },
  },
  plugins: [],
}

