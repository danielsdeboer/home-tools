<script setup lang="ts">
	import Layout from '../../Common/Components/Layout.vue'
	import { resolveIcon } from '../../Common/Icons/moduleIcons'
	import HomeCardGrid from '../../Common/Components/Cards/HomeCardGrid.vue'

	const icon = resolveIcon('gardening')

	const cards = [
		{
			title: 'Gardens',
			body: 'Create and update gardens and their contents.',
			icon: icon('garden'),
			href: route('admin.farm.gardens.index'),
		},
		{
			title: 'Plants',
			body: 'Create and update plants.',
			icon: icon('plant'),
			href: route('admin.farm.plants.index'),
		},
		{
			title: 'Plots',
			body: 'Add plants to gardens; add observations; track planting, germination, and harvest dates.',
			icon: icon('plot'),
			href: route('admin.farm.plots.index'),
		},
		{
			title: 'Projects',
			body: 'Create lists of plants for specific purposes.',
			icon: icon('project'),
			href: route('admin.farm.projects.index'),
		},
		{
			title: 'Observations',
			body: 'View observations from gardens, plants, and plots.',
			icon: icon('observation'),
			href: route('admin.farm.observations.index'),
		},
	]
</script>

<template>
	<Layout html-title="Gardening / Home Tools">
		<h1>Gardening Home</h1>

		<HomeCardGrid :cards="cards" />
	</Layout>
</template>
