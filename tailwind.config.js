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
          DEFAULT: '#5cb450',
          '50': '#f4faf3',
          '100': '#e6f5e3',
          '200': '#cdeac8',
          '300': '#a5d89d',
          '400': '#74be6a',
          '500': '#5cb450',
          '600': '#3f8435',
          '700': '#33692c',
          '800': '#2c5427',
          '900': '#254522',
          '950': '#0f250e',
        },
      },
      borderWidth: {
        '6': '6px',
      },
    },
  },

  plugins: [forms],
};
