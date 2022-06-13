module.exports = {
  darkMode: 'class',
  content: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        'third': {
          50: '#F4F6F6',
          500: '#F4F6F6',
          900: '#F4F6F6',
        },
        'first': {
          50: '#aad5dd',
          500: '#82a9b0',
          900: '#3878a4',
        },
        'second': {
          50: '#FDFEFE',
          500: '#D0D3D4',
          900: '#D0D3D4',
        },
        'warning': {
          50: '#F5B7B1',
          500: '#E74C3C',
          900: '#922B21',
        }
      },
    },
  },
  plugins: [],
}
