import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 
                    'resources/sass/formularios/formularios.scss',
                    'resources/js/app.js'],
            refresh: true,
        }),
    ],

    build: {
        rollupOptions: {
            input: {
                turbo: 'resources/assets/js/libs/turbo.js'
            },
            output: {
                dir: 'public/js/libs',
                format: 'es'
            }
        }
    }
    // resolve: {
    //     alias: {
    //         '@hotwired/turbo': 'node_modules/@hotwired/turbo'
    //     }
    // }
});
