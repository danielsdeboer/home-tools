<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Pagination } from '../../../Common/Types/Pagination'
	import { router } from '@inertiajs/vue3'
	import { Page } from '../../../Common/Types/Page'
	import { Observation, Observable } from '../../Types/Observations'
	import { mdiBinoculars } from '@mdi/js'
	import ObservationsTimeline from '../../../Common/Components/Observations/ObservationsTimeline.vue'
	import { Link } from '@inertiajs/vue3'
	import { resolveIcon } from '../../../Common/Icons/moduleIcons'

	const props = defineProps({
		observations: {
			type: Object as PropType<Pagination<Observation & Observable>>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const changePage = (page: number) => {
		if (page === props.observations.page_current) {
			return
		}

		router.reload({
			data: { page },
			onFinish: () => window.scrollTo(0, 0),
		})
	}

	const routeFor = (observation: Observable) => {
		if (observation.observable_type === 'plant') {
			return route('gardening.plants.show', observation.observable_uuid)
		}

		if (observation.observable_type === 'plot') {
			return route('gardening.plots.show', observation.observable_uuid)
		}

		if (observation.observable_type === 'garden') {
			return route('gardening.gardens.show', observation.observable_uuid)
		}

		return '#'
	}

	const resolveGardeningIcon = resolveIcon('gardening')
</script>

<template>
	<Layout :header="page.header" :breadcrumbs="page.breadcrumbs">
		<ObservationsTimeline
			v-if="observations.data.length"
			:observations="observations.data"
			class="mt-4"
		>
			<template #default="{ observation }">
				<Link :href="routeFor(observation)" class="d-block mt-4">
					<v-icon
						:icon="resolveGardeningIcon(observation.observable_type)"
						size="small"
						class="mr-2"
					/>
					{{ observation.observable_name }}
				</Link>
			</template>
		</ObservationsTimeline>

		<v-empty-state
			v-else
			:icon="mdiBinoculars"
			title="No Observations Yet"
			size="40px"
		/>

		<v-pagination
			v-if="observations.data.length"
			class="mt-8"
			:length="observations.page_last"
			:model-value="observations.page_current"
			@update:model-value="changePage"
		/>
	</Layout>
</template>
