<script setup lang="ts">
	import Layout from '../../Common/Components/Layout.vue'
	import { resolveIcon } from '../../Common/Icons/moduleIcons'
	import HomeCardGrid from '../../Common/Components/Cards/HomeCardGrid.vue'
	import { computed, PropType } from 'vue'
	import { FrostDates } from '../Types/Settings'
	import { useDate } from 'vuetify'

	const props = defineProps({
		frostDates: {
			type: Object as PropType<FrostDates>,
			required: true,
		},
	})

	const icon = resolveIcon('gardening')
	const date = useDate()

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
		{
			title: 'Settings',
			body: 'Change gardening settings such as frost dates.',
			icon: icon('setting'),
			href: route('admin.farm.settings.index'),
		},
	]

	const daysToSpring = computed(() =>
		date.getDiff(props.frostDates.spring, new Date(), 'days'),
	)

	const daysToAutumn = computed(() =>
		date.getDiff(props.frostDates.autumn, new Date(), 'days'),
	)

	const getAlertColor = (days: number) => {
		if (days < 7) {
			return 'error'
		}

		if (days < 30) {
			return 'warning'
		}

		return 'info'
	}
</script>

<template>
	<Layout html-title="Gardening / Home Tools">
		<h1>Gardening Home</h1>

		<v-row class="mt-6">
			<v-col>
				<v-alert
					:title="`${daysToSpring} days till last spring frost`"
					type="info"
					variant="tonal"
				/>
			</v-col>

			<v-col>
				<v-alert
					:title="`${daysToAutumn} days till first autumn frost`"
					:type="getAlertColor(daysToAutumn)"
					variant="tonal"
				/>
			</v-col>
		</v-row>

		<HomeCardGrid :cards="cards" />
	</Layout>
</template>
