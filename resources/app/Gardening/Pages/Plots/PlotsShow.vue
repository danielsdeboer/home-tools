<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { mdiBinoculars } from '@mdi/js'
	import { InertiaForm } from '@inertiajs/vue3'
	import { computed, PropType, ref } from 'vue'
	import { Plot, PlotShow } from '../../Types/Plots'
	import { Link } from '@inertiajs/vue3'
	import { parseAndFormatDate } from '../../../Common/Dates/parseAndFormatDate'
	import { Page } from '../../../Common/Types/Page'
	import DataList from '../../../Common/Components/Data/DataList.vue'
	import SectionList from '../../../Common/Components/Sections/SectionList.vue'
	import Section from '../../../Common/Components/Sections/Section.vue'
	import ObservationsTimeline from '../../../Common/Components/Observations/ObservationsTimeline.vue'
	import SectionHeader from '../../../Common/Components/Sections/SectionHeader.vue'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		plot: {
			type: Object as PropType<PlotShow>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const title = computed(
		() =>
			`${props.plot.name} - ${props.plot.plant.name} in ${props.plot.garden.name}`,
	)

	// Observations //

	const isCreatingObservation = ref(false)
	const isEditingObservationUuid = ref(null)

	const storeObservation = (form: InertiaForm) => {
		form.post(route('gardening.plots.observations.store', props.plot), {
			onSuccess: () => {
				isCreatingObservation.value = false
			},
		})
	}

	const updateObservation = (form: InertiaForm, plot: Plot) => {
		form.patch(
			route('gardening.plants.observations.update', {
				plot: props.plot,
				observation,
			}),
			{
				onSuccess: () => {
					isEditingObservationUuid.value = undefined
				},
			},
		)
	}
</script>

<template>
	<Layout
		:breadcrumbs="page.breadcrumbs"
		:header="page.header"
		:edit-route="page.edit_route"
	>
		<SectionList>
			<Section class="mt-8">
				<v-row>
					<v-col>
						<v-sheet class="py-6 px-8" rounded>
							<h4>Description</h4>
							<div class="mt-2">
								{{ plot.description }}
							</div>
						</v-sheet>
					</v-col>
				</v-row>

				<v-row>
					<v-col cols="12" lg="6">
						<DataList>
							<div><strong>Plot Name:</strong></div>
							<div>{{ plot.name }}</div>

							<div><strong>Plant Name:</strong></div>
							<div>
								<Link
									:href="route('gardening.plants.show', plot.plant)"
									v-text="plot.plant.name"
								/>
							</div>

							<div><strong>Garden Name:</strong></div>
							<div>
								<Link
									:href="route('gardening.gardens.show', plot.garden)"
									v-text="plot.garden.name"
								/>
							</div>
						</DataList>
					</v-col>

					<v-col cols="12" lg="6">
						<DataList>
							<div><strong>Planted On:</strong></div>
							<div>{{ parseAndFormatDate(plot.planted_at) }}</div>

							<div><strong>Germinated On:</strong></div>
							<div>
								{{
									plot.germinated_at
										? parseAndFormatDate(plot.germinated_at)
										: '(Not Set)'
								}}
							</div>

							<div><strong>Harvested On:</strong></div>
							<div>
								{{
									plot.harvested_at
										? parseAndFormatDate(plot.harvested_at)
										: '(Not Set)'
								}}
							</div>
						</DataList>
					</v-col>
				</v-row>
			</Section>

			<Section>
				<Section>
					<SectionHeader
						:icon="mdiBinoculars"
						text="Observations for this plot"
						:has-create="true"
						:is-creating="isCreatingObservation"
						@toggle-create="isCreatingObservation = !isCreatingObservation"
					/>

					<ObservationsTimeline
						v-if="plot.observations.length || isCreatingObservation"
						@cancel-create="isCreatingObservation = false"
						@cancel-edit="isEditingObservationUuid = undefined"
						@init-edit="(e) => (isEditingObservationUuid = e)"
						:error="errors"
						:observations="plot.observations"
						:is-creating="isCreatingObservation"
						:editing-uuid="isEditingObservationUuid"
						:store-cb="storeObservation"
						:update-cb="updateObservation"
						class="mt-4"
					/>

					<v-empty-state
						v-else
						:icon="mdiBinoculars"
						title="No Observations Yet"
					/>
				</Section>
			</Section>
		</SectionList>
	</Layout>
</template>
