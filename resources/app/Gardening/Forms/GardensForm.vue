<script setup lang="ts">
	import { required } from '../../Common/Validation/required.js'
	import { computed, PropType, ref } from 'vue'
	import { useForm } from '@inertiajs/vue3'
	import FormErrors from '../../Common/Components/Form/FormErrors.vue'
	import { Garden } from '../Types/Gardens'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		garden: {
			type: Object as PropType<Garden>,
			default: undefined,
		},
	})

	const form = useForm({
		name: props.garden?.name || null,
		location: props.garden?.location || null,
		description: props.garden?.description || null,
	})

	const formIsValid = ref(false)

	const buttonText = computed(() => (props.garden ? 'Update' : 'Create'))

	const persist = () => {
		if (props.garden) {
			form.patch(route('gardening.gardens.update', props.garden.uuid))
		} else {
			form.post(route('gardening.gardens.store'))
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
		/>

		<v-text-field
			v-model="form.location"
			label="Location"
			:rules="[required]"
			class="mb-2"
		/>

		<v-textarea v-model="form.description" label="Description" class="mb-2" />

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
