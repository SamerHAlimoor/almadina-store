import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/bootstrap.js',
                'resources/js/app.js',
                'public/js/cart.js',
            ],
            refresh: true,
        }),
    ],
});
