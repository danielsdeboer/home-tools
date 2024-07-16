<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType, ref } from 'vue'
	import { GardenStub } from '../../Types/Gardens'
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
	})

	const store = (form: InertiaForm) => {
		form.post(route('admin.farm.plots.store'))
	}
</script>

<template>
	<Layout :page="page">
		<PlotsForm
			:errors="errors"
			:gardens="gardens"
			:persist="store"
			class="mt-4"
	/></Layout>
</template>
