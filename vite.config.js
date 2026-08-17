import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    build: {
        assetsDir: '',
        rollupOptions: {
            input: ['resources/js/app.js', 'resources/css/app.css'],
            output: {
                // The CSS entry also emits a discarded JS chunk named "app", which would
                // otherwise take app.js and push the real bundle to app2.js.
                entryFileNames: (chunk) => chunk.facadeModuleId?.endsWith('.css') ? '[name].css.js' : '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: '[name].[ext]',
            },
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});
