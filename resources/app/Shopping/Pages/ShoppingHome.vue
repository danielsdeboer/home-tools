<script setup lang="ts">
	import Layout from '../../Common/Components/Layout.vue'
	import { resolveIcon } from '../../Common/Icons/moduleIcons'
	import HomeCardGrid from '../../Common/Components/Cards/HomeCardGrid.vue'

	const icon = resolveIcon('shopping')

	const cards = [
		{
			title: 'Items',
			body: 'Create and update stockable items.',
			icon: icon('items'),
			href: route('shopping.items.index'),
		},
	]
</script>

<template>
	<Layout html-title="Shopping / Home Tools">
		<h1>Shopping Home</h1>

		<HomeCardGrid :cards="cards" />
	</Layout>
</template>
