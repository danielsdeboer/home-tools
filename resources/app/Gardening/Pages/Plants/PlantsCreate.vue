<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import PlantsForm from '../../Forms/PlantsForm.vue'

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
	<Layout :header="page.header" :breadcrumbs="page.breadcrumbs">
		<PlantsForm :errors="props.errors" class="mt-8" />
	</Layout>
</template>
