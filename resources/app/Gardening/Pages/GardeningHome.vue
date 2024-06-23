<script setup lang="ts">
	import Layout from '../../Common/Components/Layout.vue'
	import { router, Link } from '@inertiajs/vue3'
</script>

<template>
	<Layout>
		<h1>Gardening</h1>

		<v-divider class="my-8" />

		<v-row>
			<v-col cols="12" md="4">
				<Link href="/gardening/gardens" class="text-decoration-none">
					<v-card
						title="Gardens"
						text="Create and update gardens and their contents."
						link
						height="100%"
						class="px-6 py-4"
					/>
				</Link>
			</v-col>

			<v-col cols="12" md="4">
				<Link href="/gardening/plants" class="text-decoration-none">
					<v-card
						title="Plants"
						text="Create and update plants."
						link
						height="100%"
						class="px-6 py-4"
					/>
				</Link>
			</v-col>

			<v-col cols="12" md="4">
				<Link href="/gardening/plots" class="text-decoration-none">
					<v-card
						title="Plots"
						text="Add plants to gardens; add observations; track planting, germination, and harvest dates."
						link
						height="100%"
						class="px-6 py-4"
					/>
				</Link>
			</v-col>
		</v-row>
	</Layout>
</template>
