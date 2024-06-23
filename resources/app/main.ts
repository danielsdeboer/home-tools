import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js'
import './styles.css'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { VDateInput } from 'vuetify/labs/VDateInput'
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg'

const systemColorScheme = window.matchMedia('(prefers-color-scheme: dark)')

const vuetify = createVuetify({
	components: {
		...components,
		VDateInput,
	},
	directives,
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
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(vuetify)
			.use(ZiggyVue)
			.mount(el)
	},
})
