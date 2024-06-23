<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import {
		Plot,
		PlotGardenName,
		PlotPlantName,
		PlotShow,
	} from '../../Types/Plots'
	import { Link } from '@inertiajs/vue3'
	import { parseAndFormatDate } from '../../../Common/Dates/parseAndFormatDate'
	import { ObservationsCount } from '../../Types/Observations'
	import { Page } from '../../../Common/Types/Page'

	const props = defineProps({
		plots: {
			type: Object as PropType<
				Pagination<Plot & ObservationsCount & PlotGardenName & PlotPlantName>
			>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const headers = [
		{ title: 'Name', key: 'name' },
		{ title: 'Plant', key: 'plant.name' },
		{ title: 'Garden', key: 'garden.name' },
		{
			title: 'Planted On',
			key: 'planted_at',
			value: (item: PlotShow) => parseAndFormatDate(item.planted_at),
		},
		{
			title: 'Germinated On',
			key: 'germinated_at',
			value: (item: PlotShow) =>
				item.germinated_at
					? parseAndFormatDate(item.germinated_at)
					: '(Not Set)',
		},
		{
			title: 'Harvested On',
			key: 'harvested_at',
			value: (item: PlotShow) =>
				item.harvested_at ? parseAndFormatDate(item.harvested_at) : '(Not Set)',
		},
		{ title: 'Observations', key: 'observations_count' },
	]
</script>

<template>
	<Layout
		:create-route="page.create_route"
		:header="page.header"
		:breadcrumbs="page.breadcrumbs"
	>
		<v-data-table :headers="headers" :items="plots.data" class="mt-8">
			<template #item.name="{ item }">
				<Link :href="route('gardening.plots.show', item)">
					{{ item.name }}
				</Link>
			</template>

			<template #item.plant.name="{ item }">
				<Link :href="route('gardening.plants.show', item.plant)">
					{{ item.plant.name }}
				</Link>
			</template>

			<template #item.garden.name="{ item }">
				<Link :href="route('gardening.gardens.show', item.garden)">
					{{ item.garden.name }}
				</Link>
			</template>
		</v-data-table>
	</Layout>
</template>
