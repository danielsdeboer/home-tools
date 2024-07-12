<script setup lang="ts">
	import { PropType } from 'vue'
	import { Card } from '../../Types/Card'
	import HomeCard from './HomeCard.vue'

	defineProps({
		cards: {
			type: Array as PropType<Card[]>,
			required: true,
		},
	})
</script>

<template>
	<v-row class="mt-4">
		<v-col cols="12" md="4" v-for="(card, index) in cards" :key="index">
			<HomeCard :card="card" />
		</v-col>
	</v-row>
</template>
