<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { PropType } from 'vue'
	import { Page } from '../../../Common/Types/Page'
	import { GardeningSettingsTable } from '../../Types/Settings'
	import { useDate } from 'vuetify'
	import { mdiPencil } from '@mdi/js'
	import { Link } from '@inertiajs/vue3'

	const date = useDate()

	const props = defineProps({
		settings: {
			type: Object as PropType<GardeningSettingsTable>,
			required: true,
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
	})

	const headers = [
		{ title: 'Name', key: 'name' },
		{
			title: 'Value',
			key: 'value',
			value: (item: object) => date.format(item.value, 'monthAndDate'),
		},
	]
</script>

<template>
	<Layout :page="page">
		<template #header-actions>
			<Link :href="route('admin.farm.settings.edit')">
				<v-btn :icon="mdiPencil" size="small" />
			</Link>
		</template>

		<v-data-table
			hide-default-footer
			:headers="headers"
			:items="settings"
			class="mt-8"
		/>
	</Layout>
</template>
