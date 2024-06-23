<script setup lang="ts">
	import { InertiaForm, useForm } from '@inertiajs/vue3'
	import { PropType, ref } from 'vue'
	import { Observation } from '../../../Gardening/Types/Observations.js'
	import { requiredField } from '../../Validation/required'
	import { mdiCalendar } from '@mdi/js'
	import FormErrors from '../Form/FormErrors.vue'
	import { Link } from '../../../Gardening/Types/Link'

	const props = defineProps({
		link: {
			type: Object as PropType<Link>,
			default: undefined,
		},
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		persist: {
			type: Function as PropType<(form: InertiaForm, link?: Link) => void>,
			required: true,
		},
	})

	const form = useForm({
		link: props.link?.content ?? null,
		description: props.description?.status ?? null,
	})

	const formIsValid = ref(false)

	const callPersist = () => {
		props.persist(form, props.link)
	}
</script>

<template>
	<v-form
		@submit.prevent="callPersist"
		v-model="formIsValid"
		style="width: 100%"
	>
		<FormErrors :errors="props.errors" class="mb-4" />

		<v-text-field
			v-model="form.link"
			label="URL"
			class="mb-1"
			:rules="[requiredField('url')]"
			:readonly="form.processing"
			@keyup.ctrl.enter="callPersist"
		/>

		<v-textarea
			v-model="form.description"
			label="Description (Optional)"
			class="mb-1"
			:readonly="form.processing"
			@keyup.ctrl.enter="callPersist"
		/>

		<v-btn
			type="submit"
			block
			:loading="form.processing"
			:disabled="!formIsValid || form.processing"
			text="Save"
		/>
	</v-form>
</template>
