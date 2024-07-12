<script setup lang="ts">
	import Layout from '../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Pagination } from '../../Common/Types/Pagination'
	import { Link, router } from '@inertiajs/vue3'
	import { Page } from '../../Common/Types/Page'
	import { Bookmark } from '../Types/Bookmark'
	import truncate from 'lodash/truncate'

	const props = defineProps({
		bookmarks: {
			type: Object as PropType<Pagination<Bookmark>>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const headers = [
		{ title: 'Name', key: 'name' },
		{ title: 'URL', key: 'url' },
		{ title: '', key: 'actions' },
	]

	const changePage = (page: number) => {
		if (page === props.bookmarks.page_current) {
			return
		}

		router.reload({ data: { page } })
	}
</script>

<template>
	<Layout :page="page">
		<v-data-table-server
			:items-per-page="bookmarks.page_size"
			:items-per-page-options="[bookmarks.page_size]"
			:items-length="bookmarks.items_total"
			:page="bookmarks.page_current"
			:headers="headers"
			:items="bookmarks.data"
			disable-sort
			@update:page="changePage"
			class="mt-8"
		>
			<template #item.url="{ item }">
				<a
					:href="item.url"
					:title="item.url"
					target="_blank"
					v-text="truncate(item.url, { length: 60 })"
				/>
			</template>

			<template #item.actions="{ item }">
				<Link :href="route('bookmarks.edit', item.uuid)">Edit</Link>
			</template>
		</v-data-table-server>
	</Layout>
</template>
