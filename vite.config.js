import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        manifest: {
            fileName: 'manifest.json',
            basePath: '/build/',
        },
        target: 'esnext',
        minify: 'terser',
        outDir: 'dist',
        cssCodeSplit: true,
        sourcemap: true,
    },
    css: {
        devSourcemap: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/assets/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
