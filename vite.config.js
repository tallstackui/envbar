/** @type {import('vite').UserConfig} */
export default {
    build: {
        assetsDir: '',
        rollupOptions: {
            input: ['resources/js/app.js', 'resources/css/app.css'],
            output: {
                entryFileNames: '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: '[name].[ext]',
            },
        },
    },
};
