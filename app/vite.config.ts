import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [vue()],
    root: 'assets',
    base: '/build/',
    build: {
        outDir: '../public/build',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: '/main.ts',
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'assets'),
        },
    },
})