<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { mdiBinoculars, mdiSprout } from '@mdi/js'
	import { InertiaForm, useForm } from '@inertiajs/vue3'
	import { computed, Prop, PropType, ref } from 'vue'
	import { Plot, PlotShow } from '../../Types/Plots'
	import { Link } from '@inertiajs/vue3'
	import { parseAndFormatDate } from '../../../Common/Dates/parseAndFormatDate'
	import { Page } from '../../../Common/Types/Page'
	import DataList from '../../../Common/Components/Data/DataList.vue'
	import SectionList from '../../../Common/Components/Sections/SectionList.vue'
	import Section from '../../../Common/Components/Sections/Section.vue'
	import ObservationsTimeline from '../../../Common/Components/Observations/ObservationsTimeline.vue'
	import SectionHeader from '../../../Common/Components/Sections/SectionHeader.vue'
	import FormErrors from '../../../Common/Components/Form/FormErrors.vue'
	import { requiredField } from '../../../Common/Validation/required'
	import { Select } from '../../../Common/Types/Select'

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
		plants: {
			type: Array as Prop<Select>,
			required: true,
		},
	})

	const title = computed(
		() =>
			`${props.plot.name} - ${props.plot.plant.name} in ${props.plot.garden.name}`,
	)

	const plantTableHeaders = [
		{ title: 'Plant Name', key: 'name' },
		{ title: 'Variety', key: 'variety' },
	]

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

	// Plants //

	const isAddingPlant = ref(false)
	const plantForm = useForm({ plant_uuid: null })
	const plantFormIsValid = ref(false)

	const addPlant = () => {
		plantForm.post(route('gardening.plots.plants.store', props.plot), {
			onSuccess: () => {
				isAddingPlant.value = false
			},
		})
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

					<v-empty-state v-else title="No Observations Yet" size="40px" />
				</Section>
			</Section>

			<Section>
				<SectionHeader
					:icon="mdiSprout"
					text="Plants in this plot"
					:has-create="true"
					:is-creating="isAddingPlant"
					@toggle-create="isAddingPlant = !isAddingPlant"
				/>

				<v-form
					v-if="isAddingPlant"
					@submit.prevent="addPlant"
					v-model="plantFormIsValid"
					style="width: 100%"
				>
					<FormErrors :errors="errors" class="mb-4" />

					<v-select
						v-model="plantForm.plant_uuid"
						label="Plant"
						:rules="[requiredField('plant')]"
						:readonly="plantForm.processing"
						:items="plants"
						class="mt-4"
					/>

					<div class="d-flex ga-4 mt-2">
						<v-btn
							color="error"
							:disabled="plantForm.processing"
							text="Cancel"
							@click="isAddingPlant = false"
						/>

						<v-btn
							type="submit"
							color="primary"
							:loading="plantForm.processing"
							:disabled="!plantFormIsValid || plantForm.processing"
						>
							Add Plant
						</v-btn>
					</div>
				</v-form>

				<v-data-table
					class="mt-4"
					:headers="plantTableHeaders"
					:items="plot.plants"
					:items-per-page="-1"
					hide-default-footer
				>
					<template #item.name="{ item }">
						<Link :href="route('gardening.plants.show', item)">
							{{ item.name }}
						</Link>
					</template>
				</v-data-table>
			</Section>
		</SectionList>
	</Layout>
</template>
