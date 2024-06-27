<script setup lang="ts">
	import { PropType, ref } from 'vue'
	import { InertiaForm, useForm } from '@inertiajs/vue3'
	import FormErrors from '../../Common/Components/Form/FormErrors.vue'
	import isEmpty from 'lodash/isEmpty'
	import { mdiImage } from '@mdi/js/commonjs/mdi'

	const emit = defineEmits<{ (e: 'cancel'): void }>()

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		persist: {
			type: Function as PropType<(form: InertiaForm) => void>,
			required: true,
		},
	})

	const form = useForm({ photo: null })

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
			<v-col>
				<v-file-input
					v-model="form.photo"
					accept="image/*"
					label="Select an image to upload"
					:prepend-icon="mdiImage"
				/>
			</v-col>
		</v-row>

		<v-row class="mt-0" dense>
			<v-col cols="12" md="6">
				<v-btn block @click="emit('cancel')" text="Cancel" color="error" />
			</v-col>

			<v-col cols="12" md="6">
				<v-btn
					type="submit"
					block
					:loading="form.processing"
					:disabled="!formIsValid || form.processing"
					text="Upload"
					color="primary"
				/>
			</v-col>
		</v-row>
	</v-form>
</template>
