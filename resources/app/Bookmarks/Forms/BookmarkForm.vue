<script setup lang="ts">
	import { required } from '../../Common/Validation/required.js'
	import { computed, PropType, ref } from 'vue'
	import { useForm } from '@inertiajs/vue3'
	import FormErrors from '../../Common/Components/Form/FormErrors.vue'
	import { Bookmark } from '../Types/Bookmark'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		bookmark: {
			type: Object as PropType<Bookmark>,
			default: undefined,
		},
	})

	const form = useForm({
		name: props.bookmark?.name || null,
		url: props.bookmark?.url || null,
	})

	const formIsValid = ref(false)

	const buttonText = computed(() => (props.bookmark ? 'Update' : 'Create'))

	const persist = () => {
		if (props.bookmark) {
			form.patch(route('bookmarks.update', props.bookmark.uuid))
		} else {
			form.post(route('bookmarks.store'))
		}
	}
</script>

<template>
	<v-form @submit.prevent="persist" v-model="formIsValid">
		<FormErrors :errors="props.errors" class="mb-8" />

		<v-text-field
			v-model="form.name"
			label="Name (Optional; if not specified, the URL title will be used)"
			class="mb-2"
		/>

		<v-text-field
			v-model="form.url"
			label="URL"
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
