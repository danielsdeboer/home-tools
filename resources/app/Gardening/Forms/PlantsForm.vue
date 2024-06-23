<script setup lang="ts">
	import { required } from '../../Common/Validation/required.js'
	import { computed, PropType, ref } from 'vue'
	import { useForm } from '@inertiajs/vue3'
	import FormErrors from '../../Common/Components/Form/FormErrors.vue'
	import { Plant } from '../Types/Plants'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		plant: {
			type: Object as PropType<Plant>,
			default: undefined,
		},
	})

	const form = useForm({
		name: props.plant?.name || null,
		variety: props.plant?.variety || null,
		botanical: props.plant?.botanical || null,
	})

	const formIsValid = ref(false)

	const buttonText = computed(() => (props.plant ? 'Update' : 'Create'))

	const persist = () => {
		if (props.plant) {
			form.patch(route('gardening.plants.update', props.plant))
		} else {
			form.post(route('gardening.plants.store'))
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
			v-model="form.variety"
			label="Variety"
			:rules="[required]"
			class="mb-2"
		/>

		<v-text-field
			v-model="form.botanical"
			label="Botanical"
			:rules="[required]"
			class="mb-2"
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
