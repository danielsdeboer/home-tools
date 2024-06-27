<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { GardenStub } from '../../Types/Gardens'
	import { PlantStub } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'
	import PlotsForm from '../../Forms/PlotsForm.vue'
	import { InertiaForm } from '@inertiajs/vue3'
	import { Plot } from '../../Types/Plots'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		plot: {
			type: Object as PropType<Plot & PlantStub & GardenStub>,
			required: true,
		},
		gardens: {
			type: Array as PropType<GardenStub[]>,
			required: true,
		},
	})

	const update = (form: InertiaForm) => {
		form.patch(route('gardening.plots.update', props.plot))
	}
</script>

<template>
	<Layout :header="page.header" :breadcrumbs="page.breadcrumbs">
		<PlotsForm
			:errors="errors"
			:gardens="gardens"
			:plot="plot"
			:persist="update"
			class="mt-4"
	/></Layout>
</template>
