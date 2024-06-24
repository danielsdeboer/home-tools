<script setup lang="ts">
	import { InertiaForm, useForm } from '@inertiajs/vue3'
	import { PropType, ref } from 'vue'
	import { Observation } from '../../../Gardening/Types/Observations.js'
	import { requiredField } from '../../Validation/required'
	import { mdiCalendar } from '@mdi/js'
	import FormErrors from '../Form/FormErrors.vue'

	const emit = defineEmits<{ (e: 'cancel'): void }>()

	const props = defineProps({
		observation: {
			type: Object as PropType<Observation>,
			default: undefined,
		},
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		persist: {
			type: Function as PropType<
				(form: InertiaForm, observation?: Observation) => void
			>,
			required: true,
		},
	})

	const form = useForm({
		content: props.observation?.content ?? null,
		observed_at: props.observation?.observed_at
			? new Date(props.observation.observed_at)
			: null,
		status: props.observation?.status ?? null,
	})

	const formIsValid = ref(false)

	const callPersist = () => {
		props.persist(form, props.observation)
	}
</script>

<template>
	<v-form
		@submit.prevent="callPersist"
		v-model="formIsValid"
		style="width: 100%"
	>
		<FormErrors :errors="props.errors" class="mb-4" />

		<v-textarea
			v-model="form.content"
			label="Observation"
			class="mb-1"
			:rules="[requiredField('observation')]"
			:readonly="form.processing"
			@keyup.ctrl.enter="callPersist"
		/>

		<v-date-input
			v-model="form.observed_at"
			label="Observation Date (Optional)"
			class="mb-2"
			:prepend-inner-icon="mdiCalendar"
			prepend-icon=""
			clearable
			:readonly="form.processing"
			@keyup.ctrl.enter="callPersist"
		/>

		<v-radio-group v-model="form.status" inline label="Status (Optional)">
			<v-radio label="None" value="none" color="none" />
			<v-radio label="Info" value="info" color="info" />
			<v-radio label="Success" value="success" color="success" />
			<v-radio label="Warning" value="warning" color="warning" />
			<v-radio label="Error" value="error" color="error" />
		</v-radio-group>

		<v-btn
			block
			@click="emit('cancel')"
			text="Cancel"
			class="mb-3"
			color="error"
		/>

		<v-btn
			type="submit"
			block
			:loading="form.processing"
			:disabled="!formIsValid || form.processing"
			text="Save"
			color="primary"
		/>
	</v-form>
</template>
