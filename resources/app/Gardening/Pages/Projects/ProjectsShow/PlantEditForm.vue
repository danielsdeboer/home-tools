<script setup lang="ts">
	import FormErrors from '../../../../Common/Components/Form/FormErrors.vue'
	import { PropType, ref } from 'vue'
	import { useForm } from '@inertiajs/vue3'
	import { Project } from '../../../Types/Projects'
	import { Plant } from '../../../Types/Plants'

	const emit = defineEmits<{ (e: 'cancel'): void }>()

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		project: {
			type: Object as PropType<Project>,
			required: true,
		},
		plant: {
			type: Object as PropType<Plant & { notes: string }>,
		},
	})

	const form = useForm({ notes: props.plant.notes })
	const formIsValid = ref(false)

	const persist = () => {
		form.patch(
			route('admin.farm.projects.plants.update', [props.project, props.plant]),
			{
				onSuccess: () => {
					emit('cancel')
				},
			},
		)
	}
</script>

<template>
	<v-form @submit.prevent="persist" v-model="formIsValid" style="width: 100%">
		<FormErrors :errors="errors" class="mb-4" />

		<v-textarea
			v-model="form.notes"
			label="Notes (Optional)"
			:readonly="form.processing"
			class="mt-4"
		/>

		<div class="d-flex ga-4 mt-2">
			<v-btn
				color="error"
				:disabled="form.processing"
				text="Cancel"
				@click="emit('cancel')"
			/>

			<v-btn
				type="submit"
				color="primary"
				:loading="form.processing"
				:disabled="!formIsValid || form.processing"
			>
				Edit Plant
			</v-btn>
		</div>
	</v-form>
</template>
