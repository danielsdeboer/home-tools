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
	import { Breadcrumb, Header, Page } from '../Types/Page'
	import { Link, Head } from '@inertiajs/vue3'
	import { mdiNotebook } from '@mdi/js/commonjs/mdi'

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
		htmlTitle: {
			type: String,
			default: 'Home Tools',
		},
		page: {
			type: Object as PropType<Page>,
			default: undefined,
		},
	})

	const items = [
		{ title: 'Home', icon: mdiHome, href: '/home' },
		{ title: 'Gardening', icon: mdiSprout, href: '/gardening' },
	]

	const drawer = ref(false)

	const headerIcon = computed(() => {
		if (!props.header?.icon && !props.page?.header?.icon) {
			return undefined
		}

		const icon = props.header?.icon || props.page?.header?.icon

		if (icon === 'garden') {
			return mdiGridLarge
		}

		if (icon === 'plot') {
			return mdiSelectMarker
		}

		if (icon === 'project') {
			return mdiNotebook
		}

		return mdiSprout
	})

	const pageCreateRoute = computed(
		() => props.page?.create_route || props.createRoute,
	)

	const pageEditRoute = computed(
		() => props.page?.edit_route || props.editRoute,
	)

	const pageHeader = computed(() => props.page?.header || props.header)

	const pageBreadcrumbs = computed(
		() => props.page?.breadcrumbs || props.breadcrumbs,
	)
</script>

<template>
	<v-app>
		<Head :title="page?.html_title || htmlTitle" />

		<v-app-bar elevation="2" title="Home Tools">
			<template v-slot:prepend>
				<v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
			</template>

			<template v-slot:append>
				<slot name="bar-append" />
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
					<header
						v-if="pageHeader"
						class="d-flex align-top justify-space-between"
					>
						<section data-section="name-and-icon">
							<div class="d-flex align-center ga-4">
								<v-icon v-if="headerIcon" :icon="headerIcon" size="x-large" />

								<h1 v-text="pageHeader.text" />
							</div>

							<Breadcrumbs
								v-if="pageBreadcrumbs"
								:breadcrumbs="pageBreadcrumbs"
							/>
						</section>

						<section data-section="actions">
							<slot name="header-actions" />

							<Link :href="pageCreateRoute" v-if="pageCreateRoute">
								<v-btn :icon="mdiPlus" size="small" />
							</Link>

							<Link :href="pageEditRoute" v-if="pageEditRoute">
								<v-btn :icon="mdiPencil" size="small" />
							</Link>
						</section>
					</header>
				</slot>

				<slot />
			</v-container>
		</v-main>

		<v-footer class="d-flex flex-column py-12 mt-8">
			<p class="font-weight-bold text-lg-h5">Tools for your home</p>
			<p>Use at your own risk.</p>
		</v-footer>
	</v-app>
</template>
