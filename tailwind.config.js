import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  prefix: 'eb-',

  content: [
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    //
    './src/**/*.php',
  ],

  theme: {
    extend: {
      colors: {
        'envbar': {
          DEFAULT: '#acf73b',
          '50': '#f7ffe5',
          '100': '#edffc7',
          '200': '#daff95',
          '300': '#beff57',
          '400': '#acf73b',
          '500': '#83dd05',
          '600': '#63b100',
          '700': '#4b8605',
          '800': '#3e690b',
          '900': '#34590e',
          '950': '#193201',
        },
      },
      borderWidth: {
        '6': '6px',
      },
    },
  },

  plugins: [forms],
};
