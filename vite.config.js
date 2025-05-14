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

    // resolve: {
    //     alias: {
    //         '@hotwired/turbo': 'node_modules/@hotwired/turbo'
    //     }
    // }
});
