<script setup lang="ts">
	import { mdiClose, mdiPlus } from '@mdi/js'
	import { computed } from 'vue'

	const emit = defineEmits<{ (e: 'toggle'): void }>()

	const props = defineProps({
		boolean: {
			type: Boolean,
			required: true,
		},
		size: {
			type: String,
			default: 'x-small',
		},
	})

	const icon = computed(() => (props.boolean ? mdiClose : mdiPlus))
</script>

<template>
	<v-btn :icon="icon" @click="emit('toggle')" :size="size" />
</template>
