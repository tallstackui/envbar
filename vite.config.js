/** @type {import('vite').UserConfig} */
export default {
    build: {
        assetsDir: '',
        manifest: true,
        rollupOptions: {
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
        },
    },
};
