<script setup lang="ts">
	import CreateCloseToggle from '../Buttons/CreateCloseToggle.vue'

	const emit = defineEmits<{ (e: 'toggleCreate') }>()

	defineProps({
		icon: {
			type: String,
			default: undefined,
		},
		text: {
			type: String,
			default: undefined,
		},
		hasCreate: {
			type: Boolean,
			default: true,
		},
		isCreating: {
			type: Boolean,
			default: false,
		},
	})
</script>

<template>
	<div class="d-flex justify-space-between align-center">
		<div class="d-flex align-center ga-3 mb-2">
			<v-icon v-if="icon" :icon="icon" size="large" />

			<h2 v-text="text" />
		</div>

		<div class="d-flex align-center ga-3">
			<slot name="icons" />

			<CreateCloseToggle
				v-if="hasCreate"
				:boolean="isCreating"
				@toggle="emit('toggleCreate')"
			/>
		</div>
	</div>
</template>
