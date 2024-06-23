<script setup lang="ts">
	import { PropType } from 'vue'

	defineProps({
		items: {
			type: Array as PropType<[string, string][]>,
			default: () => [],
		},
	})
</script>

<template>
	<v-sheet rounded class="py-6 px-8" height="100%">
		<div class="data-display-grid">
			<template v-for="item in items">
				<div>
					<strong>{{ item[0] }}:</strong>
				</div>
				<div>{{ item[1] }}</div>
			</template>

			<slot />
		</div>
	</v-sheet>
</template>
