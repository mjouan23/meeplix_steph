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
        host: 'meeplix_steph.local', // virtualhost défini dans /etc/hosts ou Valet
        port: 5173,
        origin: 'http://meeplix_steph.local:5173', // <- FORCE l'origin injectée dans le CSS
        cors: true,
        strictPort: true,
        hmr: {
            host: 'meeplix_steph.local',
            protocol: 'ws',
        },
    }
});
