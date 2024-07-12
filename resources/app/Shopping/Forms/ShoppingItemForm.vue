<script setup lang="ts">
	import { required } from '../../Common/Validation/required.js'
	import { computed, PropType, ref } from 'vue'
	import { useForm } from '@inertiajs/vue3'
	import FormErrors from '../../Common/Components/Form/FormErrors.vue'
	import { ShoppingItem } from '../Types/ShoppingItem'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		item: {
			type: Object as PropType<ShoppingItem>,
			default: undefined,
		},
	})

	const form = useForm({
		name: props.item?.name || null,
	})

	const formIsValid = ref(false)

	const buttonText = computed(() => (props.item ? 'Update' : 'Create'))

	const persist = () => {
		if (props.item) {
			form.patch(route('shopping.items.update', props.item.uuid))
		} else {
			form.post(route('shopping.items.store'))
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
