<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { computed, PropType, ref } from 'vue'
	import { Plant, PlantPlot } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'
	import SectionList from '../../../Common/Components/Sections/SectionList.vue'
	import DataList from '../../../Common/Components/Data/DataList.vue'
	import SectionHeader from '../../../Common/Components/Sections/SectionHeader.vue'
	import { mdiBinoculars, mdiSelectMarker } from '@mdi/js'
	import Section from '../../../Common/Components/Sections/Section.vue'
	import { InertiaForm, Link } from '@inertiajs/vue3'
	import { PlotShow } from '../../Types/Plots'
	import { parseAndFormatDate } from '../../../Common/Dates/parseAndFormatDate'
	import ObservationsTimeline from '../../../Common/Components/Observations/ObservationsTimeline.vue'
	import { Observation } from '../../Types/Observations'
	import { mdiLink } from '@mdi/js/commonjs/mdi'
	import LinksForm from '../../../Common/Components/Links/LinksForm.vue'
	import WhitespaceText from '../../../Common/Components/Form/Content/WhitespaceText.vue'

	const props = defineProps({
		plant: {
			type: Object as PropType<Plant & PlantPlot>,
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

	const isCreatingObservation = ref(false)
	const isEditingObservationUuid = ref(undefined)

	const isCreatingLink = ref(false)
	const isEditingLinkUuid = ref(undefined)

	const dataListItems = computed(() => [
		['Name', props.plant.name],
		['Variety', props.plant.variety],
		['Botanical Name', props.plant.botanical],
	])

	const plotTableHeaders = [
		{ title: 'Plot Name', key: 'name' },
		{ title: 'Garden Name', key: 'garden.name' },
		{
			title: 'Planted On',
			key: 'planted_at',
			value: (item: PlotShow) => parseAndFormatDate(item.planted_at),
		},
	]

	const storeObservation = (form: InertiaForm) => {
		form.post(route('gardening.plants.observations.store', props.plant), {
			onSuccess: () => {
				isCreatingObservation.value = false
			},
		})
	}

	const updateObservation = (form: InertiaForm, observation: Observation) => {
		form.patch(
			route('gardening.plants.observations.update', {
				plant: props.plant.uuid,
				observation: observation.uuid,
			}),
			{
				onSuccess: () => {
					isEditingObservationUuid.value = undefined
				},
			},
		)
	}

	const storeLink = (form: InertiaForm) => {
		form.post(route('gardening.plants.links.store', props.plant), {
			onSuccess: () => {
				isCreatingLink.value = false
			},
		})
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
				<DataList :items="dataListItems" />
			</Section>

			<Section>
				<SectionHeader
					:icon="mdiBinoculars"
					text="Observations for this plant"
					:has-create="true"
					:is-creating="isCreatingObservation"
					@toggle-create="isCreatingObservation = !isCreatingObservation"
				/>

				<ObservationsTimeline
					v-if="plant.observations.length || isCreatingObservation"
					@cancel-create="isCreatingObservation = false"
					@cancel-edit="isEditingObservationUuid = undefined"
					@init-edit="(e) => (isEditingObservationUuid = e)"
					:error="errors"
					:observations="plant.observations"
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
					size="40px"
				/>
			</Section>

			<Section>
				<SectionHeader
					:icon="mdiLink"
					text="Links for this plant"
					:has-create="true"
					:is-creating="isCreatingLink"
					@toggle-create="isCreatingLink = !isCreatingLink"
				/>

				<LinksForm
					v-if="isCreatingLink"
					:errors="errors"
					:persist="storeLink"
				/>

				<v-empty-state
					v-if="!isCreatingLink && plant.links.length === 0"
					:icon="mdiLink"
					title="No Links Yet"
					size="40px"
				/>

				<div v-if="!isCreatingLink && plant.links.length" class="mt-4">
					<v-sheet rounded class="py-2">
						<v-table density="compact">
							<thead>
								<tr>
									<th>Link</th>
									<th>Description</th>
								</tr>
							</thead>

							<tbody>
								<tr v-for="link in plant.links" :key="link.uuid">
									<td>
										<a :href="link.link" target="_blank">
											{{ link.link }}
										</a>
									</td>

									<td>
										<WhitespaceText
											v-if="link.description"
											:text="link.description"
										/>

										<p v-else>(Not Set)</p>
									</td>
								</tr>
							</tbody>
						</v-table>
					</v-sheet>
				</div>
			</Section>

			<Section>
				<SectionHeader
					:icon="mdiSelectMarker"
					:has-create="false"
					text="Plots containing this plant"
				/>

				<v-data-table
					class="mt-4"
					:headers="plotTableHeaders"
					:items="plant.plots"
					:items-per-page="-1"
					hide-default-footer
				>
					<template #item.name="{ item }">
						<Link :href="route('gardening.plots.show', item)">
							{{ item.name }}
						</Link>
					</template>
				</v-data-table>
			</Section>
		</SectionList>
	</Layout>
</template>
