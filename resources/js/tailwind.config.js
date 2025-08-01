// tailwind.config.js
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        bijak: {
          utama: '#49A6A9', // Warna hijau kustom
        },
      },
    },
  },
  plugins: [],
}