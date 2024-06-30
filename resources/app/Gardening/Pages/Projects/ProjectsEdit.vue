<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Page } from '../../../Common/Types/Page'
	import ProjectForm from '../../Forms/ProjectForm.vue'
	import { Project } from '../../Types/Projects'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		project: {
			type: Object as PropType<Project>,
			required: true,
		},
	})
</script>

<template>
	<Layout :header="page.header" :breadcrumbs="page.breadcrumbs">
		<ProjectForm :errors="props.errors" :project="project" class="mt-8" />
	</Layout>
</template>
