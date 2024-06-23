<script setup lang="ts">
	import { PropType } from 'vue'
	import { Breadcrumb } from '../../Types/Page'
	import { Link } from '@inertiajs/vue3'

	defineProps({
		breadcrumbs: {
			type: Array as PropType<Breadcrumb[]>,
			required: true,
		},
	})
</script>

<template>
	<v-breadcrumbs class="pa-0">
		<template v-for="(crumb, index) in breadcrumbs" :key="index">
			<Link v-if="!crumb.disabled" :href="crumb.href">
				<v-breadcrumbs-item
					:title="crumb.title"
					:class="index === 0 ? 'pl-0' : ''"
				/>
			</Link>

			<v-breadcrumbs-item
				v-else
				:title="crumb.title"
				:class="index === 0 ? 'pl-0' : ''"
			/>

			<v-breadcrumbs-divider v-if="index < breadcrumbs.length - 1" />
		</template>
	</v-breadcrumbs>
</template>
