import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/themes/themes.css',
                'resources/css/auth/auth.css',
                'resources/js/app.js',
                'resources/js/themes/theme-switcher.js'
            ],
            refresh: true,
        }),
    ],
});