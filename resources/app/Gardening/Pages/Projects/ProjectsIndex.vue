<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { Prop, PropType, ref } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { Link, router } from '@inertiajs/vue3'
	import { Page } from '../../../Common/Types/Page'
	import { route } from 'ziggy-js'
	import { objectFilter } from '../../../Common/Objects/objectFilter'
	import isNumber from 'lodash/isNumber'
	import { Project } from '../../Types/Projects'

	const props = defineProps({
		page: {
			type: Object as PropType<Page>,
			default: 1,
		},
		projects: {
			type: Object as Prop<Pagination<Project>>,
		},
	})

	const headers = [
		{ title: 'Name', key: 'name' },
		{ title: 'Plants', key: 'plants_count' },
	]

	const reload = (page?: number) => {
		if (!isNumber(page)) {
			page = undefined
		}

		router.reload({
			data: {
				page: page ?? props.projects.page_current,
				...objectFilter(form.value),
			},
		})
	}
</script>

<template>
	<Layout
		:create-route="page.create_route"
		:header="page.header"
		:breadcrumbs="page.breadcrumbs"
	>
		<v-data-table-server
			:items-per-page="projects.page_size"
			:items-per-page-options="[projects.page_size]"
			:items-length="projects.items_total"
			:page="projects.page_current"
			:headers="headers"
			:items="projects.data"
			disable-sort
			@update:page="reload"
			class="mt-8"
		>
			<template #item.name="{ item }">
				<Link
					:href="route('gardening.projects.show', item)"
					v-text="item.name"
				/>
			</template>
		</v-data-table-server>
	</Layout>
</template>
