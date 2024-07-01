<script setup lang="ts">
	import { computed } from 'vue'

	const props = defineProps({
		text: {
			type: String,
			required: true,
		},
	})

	const lines = computed(() => props.text.split('\n').filter((p) => !!p))
</script>

<template>
	<div class="paragraphs">
		<p v-for="line in lines" :key="line">{{ line }}</p>
	</div>
</template>

<style lang="css" scoped>
	.paragraphs > p:not(:last-of-type) {
		margin-bottom: 1rem;
	}
</style>
