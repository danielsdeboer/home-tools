import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vuetify from 'vite-plugin-vuetify'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/app/main.ts'],
            refresh: true,
        }),
        vue(),
        vuetify(),
    ],
});
