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
			// This is commented out for the moment. Something about the way it works
			// with Vite's sourcemaps is causing an out-of-memory error. Since we're
			// not super-reliant on sourcemaps in production, we can reenable this
			// later once the issue is resolved.
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
