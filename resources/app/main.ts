import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js'
import './styles.css'
import { init as initSentry } from '@sentry/vue'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import { VDateInput } from 'vuetify/labs/VDateInput'
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg'

const systemColorScheme = window.matchMedia('(prefers-color-scheme: dark)')

const vuetify = createVuetify({
	components: {
		VDateInput,
	},
	theme: { defaultTheme: systemColorScheme.matches ? 'dark' : 'light' },
	icons: {
		defaultSet: 'mdi',
		aliases,
		sets: {
			mdi,
		},
	},
})

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob('./**/*.vue', { eager: true })
		return pages[`./${name}.vue`]
	},
	setup({ el, App, props, plugin }) {
		const app = createApp({ render: () => h(App, props) })

		initSentry({
			app,
			dsn: import.meta.env.VITE_SENTRY_VUE_DSN,
			integrations: [],
		})

		app.use(plugin).use(vuetify).use(ZiggyVue).mount(el)
	},
})
