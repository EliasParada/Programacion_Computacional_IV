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
        'first': {
          50: '#EAF2F8',
          100: '#D4E6F1',
          200: '#A9CCE3',
          300: '#7FB3D5',
          400: '#5499C7',
          500: '#2980B9',
          600: '#2471A3',
          700: '#2471A3',
          800: '#1F618D',
          900: '#1A5276',
        },
        'second': {
          50: '#F5EEF8',
          100: '#EBDEF0',
          200: '#D7BDE2',
          300: '#C39BD3',
          400: '#AF7AC5',
          500: '#9B59B6',
          600: '#884EA0',
          700: '#76448A',
          800: '#633974',
          900: '#633974',
        },
        'third': {
          50: '#FDFEFE',
          100: '#FBFCFC',
          200: '#F7F9F9',
          300: '#F7F9F9',
          400: '#F0F3F4',
          500: '#ECF0F1',
          600: '#D0D3D4',
          700: '#B3B6B7',
          800: '#979A9A',
          900: '#7B7D7D',
        }
      },
    },
  },
  plugins: [],
}
