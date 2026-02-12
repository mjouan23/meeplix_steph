import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/boardgames/wttm.js',
                'resources/js/boardgames/mcrw.js',

            ],
            refresh: true,
        }),
    ],
    server: {
        host: 'meeplix2.local', // virtualhost défini dans /etc/hosts ou Valet
        port: 5173,
        origin: 'http://meeplix2.local:5173', // <- FORCE l'origin injectée dans le CSS
        cors: true,
        strictPort: true,
        hmr: {
            host: 'meeplix2.local',
            protocol: 'ws',
        },
    }
});
