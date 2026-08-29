import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    base: './',
    plugins: [vue(), tailwindcss()],
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        rollupOptions: {
            input: 'resources/js/app.ts',
            output: {
                entryFileNames: 'app.js',
                assetFileNames: 'app.[ext]',
            },
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js',
            '@shared': '/resources/js/Shared',
            '@images': '/resources/images',
        },
    },
});
