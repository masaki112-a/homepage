import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: "localhost",      // これで 0.0.0.0 バインド（DockerやLANからアクセス可能） 
        strictPort: true // ポート競合時にエラーで止まる（任意）
    }
});
