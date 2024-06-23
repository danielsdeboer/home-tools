<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import GardensForm from '../../Forms/GardensForm.vue'
	import { Page } from '../../../Common/Types/Page'
	import { Garden } from '../../Types/Gardens'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		garden: {
			type: Object as PropType<Garden>,
			required: true,
		},
	})
</script>

<template>
	<Layout :breadcrumbs="page.breadcrumbs" :header="page.header">
		<GardensForm class="mt-8" :errors="errors" :garden="garden" />
	</Layout>
</template>
