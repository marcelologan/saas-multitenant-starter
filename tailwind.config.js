// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Sistema de cores baseado em variáveis
                'primary': 'var(--primary)',
                'primary-hover': 'var(--primary-hover)',
                'secondary': 'var(--secondary)',
                'secondary-hover': 'var(--secondary-hover)',
                'font': 'var(--font)',
                'bg': 'var(--bg)',
                'light': 'var(--light)',
                'dark': 'var(--dark)',
                'link': 'var(--link)',
                'link-hover': 'var(--link-hover)',
                'danger': 'var(--danger)',
                'danger-hover': 'var(--danger-hover)',
                'success': 'var(--success)',
                'success-hover': 'var(--success-hover)',
                'warning': 'var(--warning)',
                'warning-hover': 'var(--warning-hover)',
            },
            backgroundImage: {
                'gradient-primary': 'var(--gradient-primary)',
                'gradient-secondary': 'var(--gradient-secondary)',
            }
        },
    },

    plugins: [forms],
};