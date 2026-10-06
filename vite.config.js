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
                // Keep the stylesheet as app.css, but give every other asset (fonts,
                // images) its own source name: forcing them all into "app.[ext]"
                // makes Rollup number the collisions in a non-deterministic order,
                // so every build reshuffled (and sometimes overwrote) the fonts.
                assetFileNames: (assetInfo) =>
                    assetInfo.names.some((name) => name.endsWith('.css'))
                        ? 'app.css'
                        : 'assets/[name][extname]',
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
