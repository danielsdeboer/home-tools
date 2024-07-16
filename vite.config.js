import { sentryVitePlugin } from '@sentry/vite-plugin'
import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import vuetify from 'vite-plugin-vuetify'

export default defineConfig(({ mode }) => {
	const env = loadEnv(mode, process.cwd(), '')

	return {
		plugins: [
			laravel({
				input: ['resources/app/main.ts'],
				refresh: true,
			}),
			vue(),
			vuetify(),
			// sentryVitePlugin({
			// 	org: env.SENTRY_ORG,
			// 	project: env.SENTRY_PROJECT,
			// 	authToken: env.SENTRY_AUTH_TOKEN,
			// 	telemetry: false,
			// }),
		],

		build: {
			sourcemap: false,
		},
	}
})
