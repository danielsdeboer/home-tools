<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { computed, PropType, ref } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { Link, router } from '@inertiajs/vue3'
	import { Plant, PlantPlotsCount } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'
	import { route } from 'ziggy-js'

	const props = defineProps({
		plants: {
			type: Object as PropType<Pagination<Plant & PlantPlotsCount>>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			default: 1,
		},
		search: {
			type: String,
			default: undefined,
		},
	})

	const searchTerm = ref(props.search || '')
	const hasSearchTerm = computed(
		() => searchTerm.value !== undefined && searchTerm.value !== '',
	)

	const headers = [
		{ title: 'Name', key: 'name' },
		{ title: 'Variety', key: 'variety' },
		{ title: 'Botanical', key: 'botanical' },
		{ title: 'In Plots', key: 'plots_count' },
	]

	const changePage = (page: number) => {
		if (page === props.plants.page_current) {
			return
		}

		router.reload({
			data: {
				page,
				...(hasSearchTerm.value && { search: searchTerm.value }),
			},
		})
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
			:items-per-page="plants.page_size"
			:items-per-page-options="[plants.page_size]"
			:items-length="plants.items_total"
			:page="plants.page_current"
			:headers="headers"
			:items="plants.data"
			disable-sort
			@update:page="changePage"
			class="mt-8"
		>
			<template #top>
				<div class="d-flex px-4 py-3 ga-4 align-end">
					<v-text-field
						density="compact"
						v-model="searchTerm"
						placeholder="Search name or variety..."
						hide-details
						@keyup.enter="doSearch"
					/>

					<v-btn @click="doSearch" color="primary">Search</v-btn>
				</div>
			</template>

			<template #item.name="{ item }">
				<Link :href="route('gardening.plants.show', item)" v-text="item.name" />
			</template>
		</v-data-table-server>
	</Layout>
</template>
