import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        // Listen on all interfaces so both IPv4 and IPv6 names resolve
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,

        // Allow laravel-task.local origin (or use `true` to allow everything)
        cors: {
        origin: ['http://laravel-task.local'],
        },

        hmr: {
        host: 'laravel-task.local',
        protocol: 'ws',
        port: 5173,
        },
    },

    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
