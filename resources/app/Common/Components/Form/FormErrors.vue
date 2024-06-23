<script setup lang="ts">
	import { computed, PropType } from 'vue'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
	})

	const hasErrors = computed(() => Object.keys(props.errors).length > 0)
</script>

<template>
	<v-alert v-if="hasErrors" title="Form Error" type="error">
		<div v-for="(error, key) in errors" :key="key" v-text="error" />
	</v-alert>
</template>
