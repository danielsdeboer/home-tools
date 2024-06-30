<script setup lang="ts">
	import { required } from '../../Common/Validation/required.js'
	import { computed, PropType, ref } from 'vue'
	import { useForm } from '@inertiajs/vue3'
	import FormErrors from '../../Common/Components/Form/FormErrors.vue'
	import { Project } from '../Types/Projects'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		project: {
			type: Object as PropType<Project>,
			default: undefined,
		},
	})

	const form = useForm({
		name: props.project?.name || null,
		description: props.project?.description || null,
	})

	const formIsValid = ref(false)

	const buttonText = computed(() => (props.project ? 'Update' : 'Create'))

	const persist = () => {
		if (props.project) {
			form.patch(route('gardening.projects.update', props.project))
		} else {
			form.post(route('gardening.projects.store'))
		}
	}
</script>

<template>
	<v-form @submit.prevent="persist" v-model="formIsValid">
		<FormErrors :errors="props.errors" />

		<v-text-field
			v-model="form.name"
			label="Name"
			:rules="[required]"
			class="mb-2"
			@keydown.ctrl.enter="persist"
		/>

		<v-textarea
			v-model="form.description"
			label="Description"
			:rules="[required]"
			class="mb-2"
			@keydown.ctrl.enter="persist"
		/>

		<v-btn
			class="mt-2"
			type="submit"
			block
			:loading="form.processing"
			:disabled="!formIsValid || form.processing"
			:text="buttonText"
		/>
	</v-form>
</template>
