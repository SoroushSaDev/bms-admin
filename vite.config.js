import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        // VitePWA({
        //     outputDir: 'public',
        //     publicPath: '/',
        //     workbox: {
        //         generateSW: true,
        //         swDest: 'public/service-worker.js',
        //     },
        // }),
    ],
});
