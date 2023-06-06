import { defineConfig, loadEnv } from "vite";

export default defineConfig(({ mode }) => {
    process.env = {...process.env, ...loadEnv(mode, process.cwd(), 'APP_')};

    return {
        root: 'assets',
        envPrefix: 'APP_',
        build: {
            manifest: true,
            outDir: '../public/dist',
            rollupOptions: {
                input: {
                    admin: '/admin/js/app.js',
                    frontend: '/frontend/js/app.js'
                }
            }
        },
        server: {
            host: 'localhost',
            port: parseInt(process.env.APP_PORT) ?? 5173,
            strictPort: true
        }
    }
})