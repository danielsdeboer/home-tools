<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { computed, Prop, PropType, ref } from 'vue'
	import { Plant } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'
	import SectionList from '../../../Common/Components/Sections/SectionList.vue'
	import Section from '../../../Common/Components/Sections/Section.vue'
	import WhitespaceText from '../../../Common/Components/Form/Content/WhitespaceText.vue'
	import { Project } from '../../Types/Projects'
	import SectionHeader from '../../../Common/Components/Sections/SectionHeader.vue'
	import { mdiPencil, mdiSprout } from '@mdi/js'
	import { InertiaForm, Link } from '@inertiajs/vue3'
	import { Select } from '../../../Common/Types/Select'
	import PlantsForm from '../../Forms/PlantsForm.vue'
	import { mdiNotebookPlus } from '@mdi/js/commonjs/mdi'
	import PlantAddForm from './ProjectsShow/PlantAddForm.vue'
	import PlantEditForm from './ProjectsShow/PlantEditForm.vue'

	const props = defineProps({
		project: {
			type: Object as PropType<Project & { plants: Plant[] }>,
			required: true,
		},
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		page: {
			type: Object as PropType<Page>,
			required: true,
		},
		plants: {
			type: Array as Prop<Select>,
			required: true,
		},
	})

	// Plants //

	const plantTableHeaders = [
		{ title: 'Plant Name', key: 'name' },
		{ title: 'Variety', key: 'variety' },
		{ title: 'Botanical Name', key: 'botanical' },
		{ title: 'Notes', key: 'notes' },
		{ title: 'Actions', key: 'actions' },
	]

	// Plants Add //

	const isAddingPlant = ref(false)
	const isCreatingPlant = ref(false)
	const isEditingPlantUuid = ref('')

	const plantBeingEdited = computed(() =>
		props.project.plants.find((p) => p.uuid === isEditingPlantUuid.value),
	)

	const createAndAddPlant = (form: InertiaForm) => {
		form.post(route('admin.farm.projects.plants.new', props.project), {
			onSuccess: () => {
				isCreatingPlant.value = false
				form.reset()
			},
		})
	}

	const toggleForm = (form: 'create' | 'add' | 'edit', uuid?: string) => {
		switch (form) {
			case 'create':
				isCreatingPlant.value = !isCreatingPlant.value
				isAddingPlant.value = false
				isEditingPlantUuid.value = ''
				break
			case 'add':
				isAddingPlant.value = !isAddingPlant.value
				isCreatingPlant.value = false
				isEditingPlantUuid.value = ''
				break
			case 'edit':
				isEditingPlantUuid.value = uuid
				isAddingPlant.value = false
				isCreatingPlant.value = false
				break
		}
	}
</script>

<template>
	<Layout :page="page">
		<SectionList class="mt-8">
			<Section>
				<v-sheet class="px-6 py-4">
					<WhitespaceText :text="project.description" />
				</v-sheet>
			</Section>

			<Section>
				<SectionHeader
					:icon="mdiSprout"
					text="Plants in this project"
					:is-creating="isAddingPlant"
					@toggle-create="toggleForm('add')"
				>
					<template #icons>
						<v-btn
							:icon="mdiNotebookPlus"
							@click="toggleForm('create')"
							size="x-small"
						/>
					</template>
				</SectionHeader>

				<!-- Plant Add Form -->

				<PlantAddForm
					v-if="isAddingPlant"
					:project="project"
					:plants="plants"
					:errors="errors"
					@cancel="toggleForm('add')"
				/>

				<!-- Plant Edit Form -->

				<PlantEditForm
					v-if="isEditingPlantUuid"
					:project="project"
					:plant="plantBeingEdited"
					:error="errors"
					@cancel="toggleForm('edit')"
				/>

				<!-- Plant Create Form -->

				<PlantsForm
					v-if="isCreatingPlant"
					:errors="errors"
					:store-cb="createAndAddPlant"
					@cancel="toggleForm('create')"
					cancel
					notes
					class="mt-4"
				/>

				<v-data-table
					class="mt-4"
					:headers="plantTableHeaders"
					:items="project.plants"
					:items-per-page="-1"
					hide-default-footer
				>
					<template #item.name="{ item }">
						<Link :href="route('admin.farm.plants.show', item)">
							{{ item.name }}
						</Link>
					</template>

					<template #item.notes="{ item }">
						<WhitespaceText v-if="item.notes" :text="item.notes" class="py-3" />

						<span v-else>(Not Set)</span>
					</template>

					<template #item.actions="{ item }">
						<v-btn
							:icon="mdiPencil"
							@click="toggleForm('edit', item.uuid)"
							size="small"
							flat
						/>
					</template>
				</v-data-table>
			</Section>
		</SectionList>
	</Layout>
</template>
