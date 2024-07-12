<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Page } from '../../../Common/Types/Page'
	import { ShoppingItem } from '../../Types/ShoppingItem'
	import ShoppingItemForm from '../../Forms/ShoppingItemForm.vue'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		item: {
			type: Object as PropType<ShoppingItem>,
			required: true,
		},
	})
</script>

<template>
	<Layout :page="page">
		<ShoppingItemForm class="mt-8" :errors :item />
	</Layout>
</template>
