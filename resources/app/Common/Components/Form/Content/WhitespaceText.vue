<script setup lang="ts">
	import { computed } from 'vue'

	const props = defineProps({
		text: {
			type: String,
			required: true,
		},
	})

	const lines = computed(() => props.text.split('\n'))
</script>

<template>
	<div>
		<p v-for="line in lines" :key="line">{{ line }}</p>
	</div>
</template>

<style lang="css" scoped>
	p::after {
		content: '\00a0 ';
	}
</style>
