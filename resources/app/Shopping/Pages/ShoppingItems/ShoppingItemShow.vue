<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Page } from '../../../Common/Types/Page'
	import Section from '../../../Common/Components/Sections/Section.vue'
	import SectionList from '../../../Common/Components/Sections/SectionList.vue'
	import { ShoppingItem } from '../../Types/ShoppingItem'

	const props = defineProps({
		item: {
			type: Object as PropType<ShoppingItem>,
			required: true,
		},
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
		<SectionList class="mt-8">
			<Section>
				<v-row>
					<v-col cols="12" lg="6">
						<v-sheet rounded class="py-6 px-8" height="100%">
							<div class="data-display-grid">
								<div><strong>Name:</strong></div>
								<div>{{ item.name }}</div>
							</div>
						</v-sheet>
					</v-col>
				</v-row>
			</Section>
		</SectionList>
	</Layout>
</template>
