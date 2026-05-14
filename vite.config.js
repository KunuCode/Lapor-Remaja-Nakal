import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Di sini kita mendaftarkan index.html agar diproses oleh Vite
            // Pastikan 'index.html' ada di folder utama (root)
            input: ['resources/css/app.css', 'resources/js/app.js', 'index.html'],
            refresh: true,
        }),
    ],
});