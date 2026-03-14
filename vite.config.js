import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/cotizador-alpine.js',
            ],
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            includeAssets: ['favicon.svg'],
            manifest: {
                name: 'Flat Rate Imports - Cotizador',
                short_name: 'Flat Rate',
                description: 'Cotiza tus importaciones a Ecuador',
                theme_color: '#667eea',
                background_color: '#667eea',
                display: 'standalone',
                start_url: '/cotizador',
                scope: '/',
                icons: [
                    {
                        src: '/favicon.svg',
                        sizes: 'any',
                        type: 'image/svg+xml',
                        purpose: 'any maskable',
                    },
                ],
            },
            workbox: {
                globPatterns: ['**/*.{js,css,html,ico,png,svg,woff2}'],
                runtimeCaching: [
                    {
                        urlPattern: /^https:\/\/.*\/api\/cotizador\/products/,
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'cotizador-products',
                            expiration: { maxEntries: 1, maxAgeSeconds: 86400 },
                            cacheableResponse: { statuses: [0, 200] },
                        },
                    },
                    {
                        urlPattern: /^https:\/\/.*\/api\/cotizador\/shipping-methods/,
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'cotizador-shipping',
                            expiration: { maxEntries: 1, maxAgeSeconds: 86400 },
                            cacheableResponse: { statuses: [0, 200] },
                        },
                    },
                ],
            },
        }),
    ],
});
