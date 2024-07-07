<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType, ref } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { Link, router } from '@inertiajs/vue3'
	import { Plant, PlantPlotsCount } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'
	import { route } from 'ziggy-js'
	import { objectFilter } from '../../../Common/Objects/objectFilter'
	import isNumber from 'lodash/isNumber'

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

	const form = ref({
		search: props.search,
		active: false,
	})

	const headers = [
		{ title: 'Name', key: 'name' },
		{ title: 'Variety', key: 'variety' },
		{ title: 'Botanical', key: 'botanical' },
		{ title: 'Active Plots', key: 'active_plots_count' },
		{ title: 'All Plots', key: 'plots_count' },
	]

	const reload = (page?: number) => {
		if (!isNumber(page)) {
			page = undefined
		}

		router.reload({
			data: {
				page: page ?? props.plants.page_current,
				...objectFilter(form.value),
			},
		})
	}
</script>

<template>
	<Layout :page="page">
		<v-data-table-server
			:items-per-page="plants.page_size"
			:items-per-page-options="[plants.page_size]"
			:items-length="plants.items_total"
			:page="plants.page_current"
			:headers="headers"
			:items="plants.data"
			disable-sort
			@update:page="reload"
			class="mt-8"
		>
			<template #top>
				<v-sheet class="py-4 px-6">
					<v-row dense>
						<v-col>
							<v-text-field
								density="compact"
								v-model="form.search"
								placeholder="Search name or variety..."
								hide-details
								@keyup.enter="reload"
							/>
						</v-col>
					</v-row>

					<v-row dense>
						<v-col>
							<v-switch
								class="ml-2"
								density="compact"
								label="Only Active"
								hide-details
								v-model="form.active"
								:color="form.active ? 'primary' : undefined"
							/>
						</v-col>

						<v-col cols="auto">
							<v-btn @click="reload" color="primary">Search</v-btn>
						</v-col>
					</v-row>
				</v-sheet>
			</template>

			<template #item.name="{ item }">
				<Link :href="route('gardening.plants.show', item)" v-text="item.name" />
			</template>
		</v-data-table-server>
	</Layout>
</template>
