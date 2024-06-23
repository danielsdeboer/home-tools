<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { Garden } from '../../Types/Gardens'
	import { Link, router } from '@inertiajs/vue3'
	import { Page } from '../../../Common/Types/Page'

	const props = defineProps({
		gardens: {
			type: Object as PropType<Pagination<Garden>>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const headers = [
		{ title: 'Name', key: 'name' },
		{ title: 'Location', key: 'location' },
	]

	const changePage = (page: number) => {
		if (page === props.gardens.page_current) {
			return
		}

		router.reload({ data: { page } })
	}
</script>

<template>
	<Layout
		:create-route="page.create_route"
		:header="page.header"
		:breadcrumbs="page.breadcrumbs"
	>
		<v-data-table-server
			:items-per-page="gardens.page_size"
			:items-per-page-options="[gardens.page_size]"
			:items-length="gardens.items_total"
			:page="gardens.page_current"
			:headers="headers"
			:items="gardens.data"
			disable-sort
			@update:page="changePage"
			class="mt-8"
		>
			<template #item.name="{ item }">
				<Link :href="`gardens/${item.uuid}`">{{ item.name }}</Link>
			</template>
		</v-data-table-server>
	</Layout>
</template>
