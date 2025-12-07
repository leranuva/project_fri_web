import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/View/Components/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Breakpoints Mobile-First (ya configurados por defecto en Tailwind)
            // sm: 640px - Celulares grandes / Tablets pequeñas
            // md: 768px - Tablets estándar (vertical)
            // lg: 1024px - Tablets grandes / Desktop
            // xl: 1280px - Desktop grande
            // 2xl: 1536px - Desktop extra grande
        },
    },

    plugins: [forms],
};
