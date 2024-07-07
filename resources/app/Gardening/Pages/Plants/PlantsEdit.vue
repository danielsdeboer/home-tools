<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType, ref } from 'vue'
	import PlantsForm from '../../Forms/PlantsForm.vue'
	import { Plant } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		plant: {
			type: Object as PropType<Plant>,
			required: true,
		},
	})
</script>

<template>
	<Layout :page="page">
		<PlantsForm :errors="props.errors" :plant="plant" class="mt-8" />
	</Layout>
</template>
