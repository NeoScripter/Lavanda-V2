import { defineConfig } from 'vite';
import { resolve } from 'path';
import tailwindcss from '@tailwindcss/vite';

const VITE_PORT = 5173;

export default defineConfig({
    build: {
        outDir: 'public/dist',
        manifest: true,
        emptyOutDir: true,
        rollupOptions: {
            input: ['ui/ts/app.ts'],
        },
        copyPublicDir: false,
    },
    server: {
        host: 'localhost',
        port: VITE_PORT,
        strictPort: true,

        hmr: {
            host: 'localhost',
            port: VITE_PORT,
            protocol: 'ws',
        },

        watch: {
            ignored: [resolve(__dirname, 'public/**')],
        },
    },
    plugins: [
        tailwindcss()
    ],
});
