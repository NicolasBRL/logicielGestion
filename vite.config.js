import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/app.scss', 'resources/js/app.js', 'public/js/page-builder/page-builder.js'],
            refresh: true,
        }),
    ],
});
