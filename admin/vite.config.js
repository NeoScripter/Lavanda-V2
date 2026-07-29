import { defineConfig } from 'vite';
import { resolve } from 'path';
import tailwindcss from '@tailwindcss/vite';
import vitePluginKeep from 'vite-plugin-keep';

const VALET_HOST = 'lavanda-v2.test';
const VITE_PORT = 5173;

export default defineConfig({
    build: {
        outDir: 'public/dist',
        manifest: true,
        rollupOptions: {
            input: ['ui/ts/app.ts'],
        },
        copyPublicDir: false,
    },
    server: {
        host: 'localhost',
        port: VITE_PORT,
        strictPort: true,

        origin: `http://${VALET_HOST}`,

        hmr: {
            host: 'localhost',
            port: VITE_PORT,
            protocol: 'ws',
        },

        cors: {
            origin: [`http://${VALET_HOST}`, `https://${VALET_HOST}`],
        },

        watch: {
            ignored: [resolve(__dirname, 'public/**')],
        },
    },
    plugins: [
        tailwindcss(),
        vitePluginKeep({
            src: 'public/static', // Source directory to be copied
            dest: 'public/dist',
        }),
    ],
});
