<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType, ref } from 'vue'
	import { Page } from '../../../Common/Types/Page'
	import { FrostDates } from '../../Types/Settings'
	import { useForm } from '@inertiajs/vue3'
	import { required } from '../../../Common/Validation/required'
	import FormErrors from '../../../Common/Components/Form/FormErrors.vue'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		settings: {
			type: Object as PropType<FrostDates>,
			required: true,
		},
	})

	const form = useForm({
		spring: new Date(props.settings.spring),
		autumn: new Date(props.settings.autumn),
	})

	const formIsValid = ref(false)
</script>

<template>
	<Layout :page="page">
		<v-alert
			title="Date Formatting"
			text="Note that the year will be ignored, and only the month and day will be used."
			type="info"
			variant="tonal"
			class="mt-8"
		/>

		<v-form
			@submit.prevent="form.patch(route('admin.farm.settings.update'))"
			v-model="formIsValid"
			class="mt-6"
		>
			<FormErrors :errors="props.errors" />

			<v-row>
				<v-col>
					<v-date-input
						v-model="form.spring"
						label="Spring Frost Date (Last Expected Frost)"
						:rules="[required]"
						clearable
					/>
				</v-col>

				<v-col>
					<v-date-input
						v-model="form.autumn"
						label="Autumn Frost Date (First Expected Frost)"
						:rules="[required]"
						class="mb-2"
						clearable
					/>
				</v-col>
			</v-row>

			<v-btn
				class="mt-2"
				type="submit"
				block
				:loading="form.processing"
				:disabled="!formIsValid || form.processing"
				text="Save Settings"
			/>
		</v-form>
	</Layout>
</template>
