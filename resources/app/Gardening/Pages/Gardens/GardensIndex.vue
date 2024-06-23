<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { GardenShow } from '../../Types/Gardens'
	import { Link } from '@inertiajs/vue3'
	import { Page } from '../../../Common/Types/Page'

	const props = defineProps({
		gardens: {
			type: Array as PropType<Pagination<GardenShow>>,
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
</script>

<template>
	<Layout
		:create-route="page.create_route"
		:header="page.header"
		:breadcrumbs="page.breadcrumbs"
	>
		<v-data-table :headers="headers" :items="gardens.data" class="mt-8">
			<template #item.name="{ item }">
				<Link :href="`gardens/${item.uuid}`">{{ item.name }}</Link>
			</template>
		</v-data-table>
	</Layout>
</template>
