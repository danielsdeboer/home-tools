<script setup lang="ts">
	import { requiredField } from '../../../../Common/Validation/required.js'
	import FormErrors from '../../../../Common/Components/Form/FormErrors.vue'
	import { Prop, PropType, ref } from 'vue'
	import { useForm } from '@inertiajs/vue3'
	import { Select } from '../../../../Common/Types/Select'
	import { Project } from '../../../Types/Projects'
	import { Plant } from '../../../Types/Plants'

	const emit = defineEmits<{ (e: 'cancel'): void }>()

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		plants: {
			type: Array as Prop<Select>,
			required: true,
		},
		project: {
			type: Object as PropType<Project>,
			required: true,
		},
	})

	const plantForm = useForm({ plant_uuid: null, notes: null })
	const plantFormIsValid = ref(false)

	const addPlant = () => {
		plantForm.post(route('admin.farm.projects.plants.store', props.project), {
			onSuccess: () => {
				emit('cancel')
				plantForm.reset()
			},
		})
	}
</script>

<template>
	<v-form
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

		<v-textarea
			v-model="plantForm.notes"
			label="Notes (Optional)"
			:readonly="plantForm.processing"
			class="mt-4"
		/>

		<div class="d-flex ga-4 mt-2">
			<v-btn
				color="error"
				:disabled="plantForm.processing"
				text="Cancel"
				@click="emit('cancel')"
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
</template>
