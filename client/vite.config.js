import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath } from 'url';
import path from 'path';
import vitePluginRequire from "vite-plugin-require";

const filename = fileURLToPath(import.meta.url);
const pathSegments = path.dirname(filename);

export default defineConfig({
    server: {
      port:8080,
    },
    plugins: [vue(),vitePluginRequire()],
    resolve: {
        alias: {
            '@': path.resolve(pathSegments, './src'),
        },
        extensions: ['.mjs', '.js', '.ts', '.jsx', '.tsx', '.json'],
    }
})
