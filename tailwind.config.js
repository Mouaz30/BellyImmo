import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',

    // Filament
    './vendor/filament/**/*.blade.php',

    // Flowbite
    './node_modules/flowbite/**/*.js',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },

      colors: {
        primary: {
          DEFAULT: '#0f6fff',
          50: '#eef6ff',
          100: '#dbeaff',
          200: '#b6d6ff',
          300: '#8abfff',
          400: '#5ca5ff',
          500: '#2f8aff',
          600: '#0b52e6',
          700: '#083ab4',
          800: '#062682',
          900: '#041752',
        },

        accent: {
          DEFAULT: '#ff7a00',
          50: '#fff4e6',
          100: '#ffe1c2',
          200: '#ffc08a',
          300: '#ffa552',
        },

        success: {
          DEFAULT: '#16a34a',
          light: '#4ade80',
        },

        warning: {
          DEFAULT: '#f59e0b',
          light: '#fcd34d',
        },

        danger: {
          DEFAULT: '#ef4444',
          light: '#fca5a5',
        },

        surface: {
          DEFAULT: '#ffffff',
          muted: '#f8fafc',
          soft: '#f1f5f9',
        },

        darkmode: {
          DEFAULT: '#0f172a',
          soft: '#1e293b',
        },
      },

      boxShadow: {
        'card-lg': '0 8px 30px rgba(12, 15, 22, 0.12)',
        'primary': '0 6px 20px rgba(15, 111, 255, 0.25)',
        'accent': '0 6px 20px rgba(255, 122, 0, 0.25)',
        'success': '0 4px 14px rgba(22, 163, 74, 0.2)',
        'danger': '0 4px 14px rgba(239, 68, 68, 0.2)',
      },

      borderRadius: {
        'xl-2': '1rem',
        'xxl': '1.5rem',
      },

      keyframes: {
        fadeIn: {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
        slideUp: {
          '0%': { transform: 'translateY(12px)', opacity: 0 },
          '100%': { transform: 'translateY(0)', opacity: 1 },
        },
        bounceIn: {
          '0%': {
            transform: 'scale(0.9)',
            opacity: 0,
          },
          '60%': {
            transform: 'scale(1.05)',
            opacity: 1,
          },
          '100%': {
            transform: 'scale(1)',
          },
        },
      },

      animation: {
        fadeIn: 'fadeIn .4s ease-out forwards',
        slideUp: 'slideUp .4s ease-out forwards',
        bounceIn: 'bounceIn .6s ease-out forwards',
      },
    },
  },

  plugins: [
    forms,
    require('flowbite'),
    require('@tailwindcss/line-clamp'),
  ],
}
