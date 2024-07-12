<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { Link, router } from '@inertiajs/vue3'
	import { Page } from '../../../Common/Types/Page'
	import { ShoppingItem } from '../../Types/ShoppingItem'

	const props = defineProps({
		items: {
			type: Object as PropType<Pagination<ShoppingItem>>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const headers = [{ title: 'Name', key: 'name' }]

	const changePage = (page: number) => {
		if (page === props.items.page_current) {
			return
		}

		router.reload({ data: { page } })
	}
</script>

<template>
	<Layout :page="page">
		<v-data-table-server
			:items-per-page="items.page_size"
			:items-per-page-options="[items.page_size]"
			:items-length="items.items_total"
			:page="items.page_current"
			:headers="headers"
			:items="items.data"
			disable-sort
			@update:page="changePage"
			class="mt-8"
		>
			<template #item.name="{ item }">
				<Link :href="`items/${item.uuid}`">{{ item.name }}</Link>
			</template>
		</v-data-table-server>
	</Layout>
</template>
