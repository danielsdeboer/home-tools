<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { InertiaForm, Link } from '@inertiajs/vue3'
	import { PropType, ref } from 'vue'
	import { GardenShow } from '../../Types/Gardens'
	import { PlotShow } from '../../Types/Plots'
	import { parseAndFormatDate } from '../../../Common/Dates/parseAndFormatDate'
	import PlotsForm from '../../Forms/PlotsForm.vue'
	import { Plant } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'
	import ObservationsTimeline from '../../../Common/Components/Observations/ObservationsTimeline.vue'
	import WhitespaceText from '../../../Common/Components/Form/Content/WhitespaceText.vue'
	import { mdiBinoculars, mdiSelectMarker } from '@mdi/js'
	import Section from '../../../Common/Components/Sections/Section.vue'
	import SectionHeader from '../../../Common/Components/Sections/SectionHeader.vue'
	import SectionList from '../../../Common/Components/Sections/SectionList.vue'
	import { Observation } from '../../Types/Observations'

	const props = defineProps({
		garden: {
			type: Object as PropType<GardenShow>,
			required: true,
		},
		plants: {
			type: Object as PropType<Plant>,
			required: true,
		},
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const isCreatingPlot = ref(false)
	const isCreatingObservation = ref(false)
	const isEditingObservationUuid = ref(undefined)

	const plotTableHeaders = [
		{ title: 'Name', key: 'name' },
		{ title: 'Plant', key: 'plant.name' },
		{
			title: 'Planted On',
			key: 'planted_at',
			value: (item: PlotShow) => parseAndFormatDate(item.planted_at),
		},
	]

	const storePlot = (form: InertiaForm) => {
		form.post(route('gardening.gardens.plots.store', props.garden), {
			onSuccess: () => {
				isCreatingPlot.value = false
			},
		})
	}

	const storeObservation = (form: InertiaForm) => {
		form.post(route('gardening.gardens.observations.store', props.garden), {
			onSuccess: () => {
				isCreatingObservation.value = false
			},
		})
	}

	const updateObservation = (form: InertiaForm, observation: Observation) => {
		form.patch(
			route('gardening.gardens.observations.update', {
				garden: props.garden.uuid,
				observation: observation.uuid,
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
		:edit-route="page.edit_route"
		:breadcrumbs="page.breadcrumbs"
		:header="page.header"
	>
		<SectionList class="mt-8">
			<Section>
				<v-row>
					<v-col cols="12" lg="6">
						<v-sheet rounded class="py-6 px-8" height="100%">
							<div class="data-display-grid">
								<div><strong>Name:</strong></div>
								<div>{{ garden.name }}</div>

								<div><strong>Location:</strong></div>
								<div>{{ garden.location }}</div>
							</div>
						</v-sheet>
					</v-col>

					<v-col cols="12" lg="6">
						<v-sheet rounded class="py-6 px-8" height="100%">
							<h4 class="mb-4">Description:</h4>

							<WhitespaceText
								v-if="garden.description"
								:text="garden.description"
							/>

							<p v-else>(Not Set)</p>
						</v-sheet>
					</v-col>
				</v-row>
			</Section>

			<Section>
				<SectionHeader
					:icon="mdiBinoculars"
					text="Observations for this garden"
					:has-create="true"
					:is-creating="isCreatingObservation"
					@toggle-create="isCreatingObservation = !isCreatingObservation"
				/>

				<ObservationsTimeline
					v-if="garden.observations.length || isCreatingObservation"
					@cancel-create="isCreatingObservation = false"
					@cancel-edit="isEditingObservationUuid = undefined"
					@init-edit="(e) => (isEditingObservationUuid = e)"
					:error="errors"
					:observations="garden.observations"
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

			<Section>
				<SectionHeader
					:icon="mdiSelectMarker"
					text="Plots in this garden"
					:has-create="true"
					:is-creating="isCreatingPlot"
					@toggle-create="isCreatingPlot = !isCreatingPlot"
				/>

				<PlotsForm
					v-if="isCreatingPlot"
					:errors="errors"
					:plants="plants"
					:garden="garden"
					:persist="storePlot"
					class="mt-4"
				/>

				<v-data-table
					class="mt-4"
					:headers="plotTableHeaders"
					:items="garden.plots"
				>
					<template #item.name="{ item }">
						<Link :href="route('gardening.plots.show', item)">
							{{ item.name }}
						</Link>
					</template>

					<template #item.plant.name="{ item }">
						<Link :href="route('gardening.plants.show', item.plant)">
							{{ item.plant.name }}
						</Link>
					</template>
				</v-data-table>
			</Section>
		</SectionList>
	</Layout>
</template>
