<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { mdiPlus } from '@mdi/js'
	import { router } from '@inertiajs/vue3'
	import { PropType } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { Link } from '@inertiajs/vue3'
	import { Plant } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'

	const props = defineProps({
		plants: {
			type: Object as PropType<Pagination<Plant>>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const headers = [
		{ title: 'Name', key: 'name' },
		{ title: 'Variety', key: 'variety' },
		{ title: 'Botanical', key: 'botanical' },
	]
</script>

<template>
	<Layout
		:create-route="page.create_route"
		:header="page.header"
		:breadcrumbs="page.breadcrumbs"
	>
		<v-data-table :headers="headers" :items="plants.data" class="mt-8">
			<template #item.name="{ item }">
				<Link :href="route('gardening.plants.show', item)">{{
					item.name
				}}</Link>
			</template>
		</v-data-table>
	</Layout>
</template>
