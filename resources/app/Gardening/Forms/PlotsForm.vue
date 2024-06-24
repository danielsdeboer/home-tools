<script setup lang="ts">
	import { PropType, ref } from 'vue'
	import { GardenShow, GardenStub } from '../Types/Gardens'
	import { Plant, PlantStub } from '../Types/Plants'
	import { InertiaForm, useForm } from '@inertiajs/vue3'
	import { required } from '../../Common/Validation/required'
	import { mdiCalendar } from '@mdi/js'
	import FormErrors from '../../Common/Components/Form/FormErrors.vue'
	import { isEmpty } from 'lodash/isEmpty'
	import { Plot } from '../Types/Plots'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		garden: {
			type: Object as PropType<GardenShow>,
			default: undefined,
		},
		plot: {
			type: Object as PropType<Plot & PlantStub & GardenStub>,
			default: undefined,
		},
		gardens: {
			type: Array as PropType<GardenStub[]>,
			default: () => [],
		},
		plants: {
			type: Array as PropType<Plant[]>,
			default: () => [],
		},
		persist: {
			type: Function as PropType<(form: InertiaForm) => void>,
			required: true,
		},
	})

	const form = useForm({
		plant_uuid: props.plot?.plant.uuid ?? null,
		garden_uuid: props.plot?.garden.uuid ?? props.garden?.uuid ?? null,
		name: props.plot?.name ?? null,
		description: props.plot?.description ?? null,
		planted_at: props.plot?.planted_at ? new Date(props.plot.planted_at) : null,
		germinated_at: props.plot?.germinated_at
			? new Date(props.plot.germinated_at)
			: null,
		harvested_at: props.plot?.harvested_at
			? new Date(props.plot.harvested_at)
			: null,
	})

	const formIsValid = ref(false)
</script>

<template>
	<v-form @submit.prevent="persist(form)" v-model="formIsValid">
		<v-row dense v-if="!isEmpty(errors)">
			<v-col>
				<FormErrors :errors="errors" />
			</v-col>
		</v-row>

		<v-row>
			<v-col cols="12" :md="garden ? 6 : 4">
				<v-select
					v-model="form.plant_uuid"
					label="Plant"
					:items="plants"
					item-title="name"
					item-value="uuid"
					:rules="[required]"
				/>
			</v-col>

			<v-col v-if="!garden" cols="12" :md="garden ? 6 : 4">
				<v-select
					v-model="form.garden_uuid"
					label="Garden"
					:items="gardens"
					item-title="name"
					item-value="uuid"
					:rules="[required]"
				/>
			</v-col>

			<v-col :md="garden ? 6 : 4">
				<v-text-field v-model="form.name" label="Name" :rules="[required]" />
			</v-col>
		</v-row>

		<v-row class="mt-0">
			<v-col>
				<v-textarea v-model="form.description" label="Description" />
			</v-col>
		</v-row>

		<v-row class="mt-0">
			<v-col>
				<v-date-input
					v-model="form.planted_at"
					label="Planted On"
					:rules="[required]"
					:prepend-inner-icon="mdiCalendar"
					prepend-icon=""
				/>
			</v-col>

			<v-col>
				<v-date-input
					v-model="form.germinated_at"
					label="Germinated On (Optional)"
					:prepend-inner-icon="mdiCalendar"
					prepend-icon=""
				/>
			</v-col>

			<v-col>
				<v-date-input
					v-model="form.harvested_at"
					label="Harvested On (Optional)"
					:prepend-inner-icon="mdiCalendar"
					prepend-icon=""
				/>
			</v-col>
		</v-row>

		<v-row class="mt-0">
			<v-col>
				<v-btn
					type="submit"
					block
					:loading="form.processing"
					:disabled="!formIsValid || form.processing"
					:text="plot ? 'Edit' : 'Create'"
				/>
			</v-col>
		</v-row>
	</v-form>
</template>
