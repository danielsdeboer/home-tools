<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType, ref } from 'vue'
	import { GardenStub } from '../../Types/Gardens'
	import { PlantStub } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'
	import PlotsForm from '../../Forms/PlotsForm.vue'
	import { InertiaForm } from '@inertiajs/vue3'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		gardens: {
			type: Array as PropType<GardenStub[]>,
			required: true,
		},
		plants: {
			type: Array as PropType<PlantStub[]>,
			required: true,
		},
	})

	const store = (form: InertiaForm) => {
		form.post(route('gardening.plots.store'))
	}
</script>

<template>
	<Layout :header="page.header" :breadcrumbs="page.breadcrumbs">
		<PlotsForm
			:errors="errors"
			:plants="plants"
			:gardens="gardens"
			:persist="store"
			class="mt-4"
	/></Layout>
</template>
