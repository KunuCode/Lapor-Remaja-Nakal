import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // Tambahkan base: '/' agar Vite tidak menambahkan prefix folder yang salah
    base: '/', 
    
    plugins: [
        laravel({
         input: ['resources/css/app.css', 'resources/js/app.jsx', 'index.html'],
            refresh: true,
        }),
    ],
});