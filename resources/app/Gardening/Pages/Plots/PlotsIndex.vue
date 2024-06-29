<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType, ref } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { PlotIndex } from '../../Types/Plots'
	import { Link, router } from '@inertiajs/vue3'
	import { parseAndFormatDate } from '../../../Common/Dates/parseAndFormatDate'
	import { Page } from '../../../Common/Types/Page'
	import { mdiCircle } from '@mdi/js'

	const props = defineProps({
		plots: {
			type: Object as PropType<Pagination<PlotIndex>>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		search: {
			type: String,
			default: undefined,
		},
	})

	const searchTerm = ref(props.search || '')

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

		router.reload({ data: { page, search: searchTerm.value } })
	}

	const doSearch = () => {
		router.reload({ data: { page: 1, search: searchTerm.value } })
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
			<template #top>
				<div class="d-flex px-4 py-3 ga-4 align-end">
					<v-text-field
						density="compact"
						v-model="searchTerm"
						placeholder="Search by name"
						hide-details
						@keyup.enter="doSearch"
					/>

					<v-btn @click="doSearch" color="primary">Search</v-btn>
				</div>
			</template>

			<template #item.name="{ item }">
				<Link :href="route('gardening.plots.show', item)">
					<v-icon
						:icon="mdiCircle"
						:color="item.status === 'done' ? 'error' : 'success'"
						class="mr-2"
						size="small"
					/>
					<span v-text="item.name" />
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
