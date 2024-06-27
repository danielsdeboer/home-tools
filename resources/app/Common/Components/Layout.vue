<script setup lang="ts">
	import { computed, PropType, ref } from 'vue'
	import {
		mdiHome,
		mdiPlus,
		mdiSprout,
		mdiGridLarge,
		mdiPencil,
		mdiSelectMarker,
	} from '@mdi/js'
	import { router } from '@inertiajs/vue3'
	import Breadcrumbs from './Nav/Breadcrumbs.vue'
	import { Breadcrumb, Header } from '../Types/Page'
	import { Link } from '@inertiajs/vue3'

	const props = defineProps({
		createRoute: {
			type: String,
			default: undefined,
		},
		editRoute: {
			type: String,
			default: undefined,
		},
		breadcrumbs: {
			type: Array as PropType<Breadcrumb[]>,
			default: undefined,
		},
		header: {
			type: Object as PropType<Header>,
			default: undefined,
		},
	})

	const items = [
		{ title: 'Home', icon: mdiHome, href: '/home' },
		{ title: 'Gardening', icon: mdiSprout, href: '/gardening' },
	]

	const drawer = ref(false)

	const headerIcon = computed(() => {
		if (!props.header?.icon) {
			return undefined
		}

		if (props.header.icon === 'garden') {
			return mdiGridLarge
		}

		if (props.header.icon === 'plot') {
			return mdiSelectMarker
		}

		return mdiSprout
	})
</script>

<template>
	<v-app>
		<v-app-bar elevation="2" title="Home Tools">
			<template v-slot:prepend>
				<v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
			</template>

			<template v-slot:append>
				<slot name="bar-append" />

				<Link :href="createRoute" v-if="createRoute">
					<v-btn :icon="mdiPlus" />
				</Link>

				<Link :href="editRoute" v-if="editRoute">
					<v-btn :icon="mdiPencil" />
				</Link>
			</template>
		</v-app-bar>

		<v-navigation-drawer v-model="drawer" temporary>
			<v-list>
				<v-list-item
					v-for="(item, index) in items"
					:key="index"
					:title="item.title"
					link
					@click="router.visit(item.href)"
				>
					<template v-slot:prepend>
						<v-icon :icon="item.icon" />
					</template>
				</v-list-item>
			</v-list>
		</v-navigation-drawer>

		<v-main style="min-height: 90vh">
			<v-container>
				<slot name="header">
					<div v-if="header" class="d-flex align-center ga-4">
						<v-icon v-if="headerIcon" :icon="headerIcon" size="x-large" />

						<h1 v-text="header.text" />
					</div>
				</slot>

				<Breadcrumbs v-if="breadcrumbs" :breadcrumbs="breadcrumbs" />

				<slot />
			</v-container>
		</v-main>

		<v-footer class="d-flex flex-column py-12 mt-8">
			<p class="font-weight-bold text-lg-h5">Tools for your home</p>
			<p>Use at your own risk.</p>
		</v-footer>
	</v-app>
</template>
