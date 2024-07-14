<script setup lang="ts">
	import { required } from '../../Common/Validation/required.js'
	import { computed, PropType, ref } from 'vue'
	import { InertiaForm, useForm } from '@inertiajs/vue3'
	import FormErrors from '../../Common/Components/Form/FormErrors.vue'
	import { Plant } from '../Types/Plants'

	const emit = defineEmits<{ (e: 'cancel'): void }>()

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		plant: {
			type: Object as PropType<Plant & { notes?: string }>,
			default: undefined,
		},
		storeCb: {
			type: Function as PropType<(form: InertiaForm) => void>,
			default: undefined,
		},
		cancel: {
			type: Boolean,
			default: false,
		},
		notes: {
			type: Boolean,
			default: false,
		},
	})

	const form = useForm({
		name: props.plant?.name || null,
		variety: props.plant?.variety || null,
		botanical: props.plant?.botanical || null,
		notes: props.plant?.notes || null,
	})

	const formIsValid = ref(false)

	const buttonText = computed(() => (props.plant ? 'Update' : 'Create'))

	const persist = () => {
		if (props.storeCb) {
			props.storeCb(form)
			return
		}

		if (props.plant) {
			form.patch(route('admin.farm.plants.update', props.plant))
		} else {
			form.post(route('admin.farm.plants.store'))
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

		<v-textarea
			v-if="notes"
			v-model="form.notes"
			label="Notes (Optional)"
			:readonly="form.processing"
			class="mt-4"
		/>

		<v-row>
			<v-col v-if="cancel">
				<v-btn
					class="mt-2"
					block
					:loading="form.processing"
					:disabled="form.processing"
					text="Cancel"
					color="error"
					@click="emit('cancel')"
				/>
			</v-col>

			<v-col>
				<v-btn
					class="mt-2"
					type="submit"
					block
					:loading="form.processing"
					:disabled="!formIsValid || form.processing"
					:text="buttonText"
					color="primary"
				/>
			</v-col>
		</v-row>
	</v-form>
</template>
