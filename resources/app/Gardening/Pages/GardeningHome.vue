<script setup lang="ts">
	import Layout from '../../Common/Components/Layout.vue'
	import { Link } from '@inertiajs/vue3'
	import { resolveIcon } from '../../Common/Icons/moduleIcons'

	const icon = resolveIcon('gardening')
</script>

<template>
	<Layout>
		<h1>Gardening</h1>

		<v-row class="mt-4">
			<v-col cols="12" md="4">
				<Link
					:href="route('gardening.gardens.index')"
					class="text-decoration-none"
				>
					<v-card
						title="Gardens"
						text="Create and update gardens and their contents."
						:prepend-icon="icon('garden')"
						link
						height="100%"
						class="px-6 py-4"
					/>
				</Link>
			</v-col>

			<v-col cols="12" md="4">
				<Link
					:href="route('gardening.plants.index')"
					class="text-decoration-none"
				>
					<v-card
						title="Plants"
						text="Create and update plants."
						:prepend-icon="icon('plant')"
						link
						height="100%"
						class="px-6 py-4"
					/>
				</Link>
			</v-col>

			<v-col cols="12" md="4">
				<Link
					:href="route('gardening.plots.index')"
					class="text-decoration-none"
				>
					<v-card
						title="Plots"
						text="Add plants to gardens; add observations; track planting, germination, and harvest dates."
						:prepend-icon="icon('plot')"
						link
						height="100%"
						class="px-6 py-4"
					/>
				</Link>
			</v-col>
		</v-row>
	</Layout>
</template>
