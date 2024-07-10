<script setup lang="ts">
	import Layout from '../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Page } from '../../Common/Types/Page'
	import BookmarkForm from '../Forms/BookmarkForm.vue'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})
</script>

<template>
	<Layout :page="page">
		<BookmarkForm class="mt-8" :errors="errors" />
	</Layout>
</template>
