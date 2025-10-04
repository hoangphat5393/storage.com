import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

// console.log('__dirname:', path.resolve(__dirname, 'public/assets'));
// console.log('__dirname:', resolve(__dirname, 'public/assets'));
// console.log('__dirname:', resolve(__dirname, 'src'));

var input_style = [
    // 'resources/scss/bootstrap.scss', // Boostrap CSS
    // 'resources/js/bootstrap.js', // Boostrap JS
    'resources/scss/style.scss', // custom style
    'resources/scss/landing.scss',
    // 'resources/scss/landing6.scss',
    // 'resources/scss/landing9.scss',
    // 'resources/scss/landing43.scss',
    // 'resources/scss/landing44.scss',
    // 'resources/scss/landing47.scss',
    // 'resources/scss/landing48.scss',
    // 'resources/scss/landing49.scss',
    // 'resources/scss/landing50.scss',
    // 'resources/scss/landing51.scss',
    // 'resources/scss/landing52.scss',
    // 'resources/scss/landing54.scss',
    // 'resources/scss/landing64.scss',
];

export default defineConfig({
    // root: resolve(__dirname, 'assets'),
    plugins: [
        laravel({
            // input: ['resources/scss/app.scss', 'resources/js/app.js', 'resources/scss/style.scss'],
            input: input_style,
            refresh: true,
            // buildDirectory: 'public', // Inform Laravel Vite to look for the manifest in 'public/assets
        }),
    ],
    base: '/assets/', // Thêm prefix cho tất cả đường dẫn
    build: {
        outDir: 'public', // Thay đổi thư mục gốc build
        emptyOutDir: false, // Giữ lại các file cũ khi build mới
        // resolve: {
        //     alias: {
        //         // '@': path.resolve(__dirname, 'public/assets'),
        //         '@': resolve(__dirname, 'public/assets'),
        //         '@images': resolve(__dirname, 'public/assets/images'),
        //         '@fonts': resolve(__dirname, 'public/assets/fonts'),
        //     },
        // },
        rollupOptions: {
            output: {
                entryFileNames: 'assets/js/[name]-[hash].js',
                chunkFileNames: 'assets/js/[name]-[hash].js',
                // Định nghĩa thư mục đầu ra tùy chỉnh
                assetFileNames: (assetInfo) => {
                    // Lấy tên tệp từ phần tử đầu tiên của `names`

                    // const name = assetInfo.names ? assetInfo.names[0] : 'unknown';
                    // console.log('Tên tệp:', name);

                    // // Tách phần mở rộng từ tên tệp
                    // const ext = name.includes('.') ? name.split('.').pop() : 'unknown';
                    // console.log('Phần mở rộng (ext):', ext);

                    if (/\.(css)$/.test(assetInfo.names)) {
                        return 'assets/css/[name]-[hash][extname]';
                    }

                    return `assets/[ext]/[name]-[hash][extname]`;
                },
            },
        },
    },
});
