<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import {
		Plot,
		PlotGardenName,
		PlotIndex,
		PlotPlantName,
		PlotShow,
	} from '../../Types/Plots'
	import { Link, router } from '@inertiajs/vue3'
	import { parseAndFormatDate } from '../../../Common/Dates/parseAndFormatDate'
	import { Page } from '../../../Common/Types/Page'

	const props = defineProps({
		plots: {
			type: Object as PropType<Pagination<PlotIndex>>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const headers = [
		{ title: 'Name', key: 'name' },
		{ title: 'Garden Name', key: 'garden.name' },
		{
			title: 'Planted On',
			key: 'planted_at',
			value: (item: PlotIndex) => parseAndFormatDate(item.planted_at),
		},
		{
			title: 'Germinated On',
			key: 'germinated_at',
			value: (item: PlotIndex) =>
				item.germinated_at
					? parseAndFormatDate(item.germinated_at)
					: '(Not Set)',
		},
		{
			title: 'Harvested On',
			key: 'harvested_at',
			value: (item: PlotIndex) =>
				item.harvested_at ? parseAndFormatDate(item.harvested_at) : '(Not Set)',
		},
		{ title: 'Observations', key: 'observations_count' },
		{ title: 'Plants', key: 'plants_count' },
	]

	const changePage = (page: number) => {
		if (page === props.plots.page_current) {
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
			:items-per-page="plots.page_size"
			:items-per-page-options="[plots.page_size]"
			:items-length="plots.items_total"
			:page="plots.page_current"
			:headers="headers"
			:items="plots.data"
			disable-sort
			@update:page="changePage"
			class="mt-8"
		>
			<template #item.name="{ item }">
				<Link :href="route('gardening.plots.show', item)">
					{{ item.name }}
				</Link>
			</template>

			<template #item.garden.name="{ item }">
				<Link :href="route('gardening.gardens.show', item.garden)">
					{{ item.garden.name }}
				</Link>
			</template>
		</v-data-table-server>
	</Layout>
</template>
