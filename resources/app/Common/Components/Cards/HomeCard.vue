<script setup lang="ts">
	import { Link } from '@inertiajs/vue3'
	import { PropType } from 'vue'
	import { Card } from '../../Types/Card'

	defineProps({
		card: {
			type: Object as PropType<Card>,
			required: true,
		},
	})
</script>

<template>
	<Link :href="card.href" class="text-decoration-none">
		<v-card
			:title="card.title"
			:text="card.body"
			:prepend-icon="card.icon"
			link
			height="100%"
			class="px-6 py-4"
		/>
	</Link>
</template>
