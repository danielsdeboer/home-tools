<script setup lang="ts">
	import Layout from '../../Common/Components/Layout.vue'
	import { mdiBookmarkMultiple, mdiShopping, mdiSprout } from '@mdi/js'
	import HomeCardGrid from '../../Common/Components/Cards/HomeCardGrid.vue'

	const cards = [
		{
			title: 'Gardening',
			body: 'Create and update gardens and their contents.',
			icon: mdiSprout,
			href: route('admin.farm.index'),
		},
		{
			title: 'Shopping',
			body: 'Create shopping lists and do stock counts.',
			icon: mdiShopping,
			href: route('shopping.index'),
		},
		{
			title: 'Bookmarks',
			body: 'Create and update bookmarks.',
			icon: mdiBookmarkMultiple,
			href: route('admin.bookmarks.index'),
		},
	]
</script>

<template>
	<Layout>
		<h1>Home Tools</h1>

		<HomeCardGrid :cards="cards" />
	</Layout>
</template>
