import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    server: {
        host: '0.0.0.0',     // listen on all IPs so other devices can access
        port: 5173,          // default port (change if needed)
        cors: true,
        hmr: {
            host: '192.168.2.32',  // your dev machine IP address
            protocol: 'ws',
        },
    },
});
