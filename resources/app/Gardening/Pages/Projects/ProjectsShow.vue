<script setup lang="ts">
	import Layout from '../../../Common/Components/Layout.vue'
	import { Prop, PropType, ref } from 'vue'
	import { Plant } from '../../Types/Plants'
	import { Page } from '../../../Common/Types/Page'
	import SectionList from '../../../Common/Components/Sections/SectionList.vue'
	import Section from '../../../Common/Components/Sections/Section.vue'
	import WhitespaceText from '../../../Common/Components/Form/Content/WhitespaceText.vue'
	import { Project } from '../../Types/Projects'
	import SectionHeader from '../../../Common/Components/Sections/SectionHeader.vue'
	import { mdiSprout } from '@mdi/js'
	import { InertiaForm, Link, useForm } from '@inertiajs/vue3'
	import { requiredField } from '../../../Common/Validation/required'
	import FormErrors from '../../../Common/Components/Form/FormErrors.vue'
	import { Select } from '../../../Common/Types/Select'
	import PlantsForm from '../../Forms/PlantsForm.vue'
	import { mdiNotebookPlus } from '@mdi/js/commonjs/mdi'

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
	]

	// Plants Add //

	const isAddingPlant = ref(false)
	const plantForm = useForm({ plant_uuid: null })
	const plantFormIsValid = ref(false)

	const addPlant = () => {
		plantForm.post(route('gardening.projects.plants.store', props.project), {
			onSuccess: () => {
				isAddingPlant.value = false
				plantForm.reset()
			},
		})
	}

	// Plants Create & Add //

	const isCreatingPlant = ref(false)

	const createAndAddPlant = (form: InertiaForm) => {
		console.log(form, props.project)
		form.post(route('gardening.projects.plants.new', props.project), {
			onSuccess: () => {
				isCreatingPlant.value = false
				form.reset()
			},
		})
	}

	const toggleForm = (form: 'create' | 'add') => {
		if (form === 'create') {
			isCreatingPlant.value = !isCreatingPlant.value
			isAddingPlant.value = false
		} else {
			isAddingPlant.value = !isAddingPlant.value
			isCreatingPlant.value = false
		}
	}
</script>

<template>
	<Layout
		:edit-route="page.edit_route"
		:breadcrumbs="page.breadcrumbs"
		:header="page.header"
	>
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

				<v-form
					v-if="isAddingPlant"
					@submit.prevent="addPlant"
					v-model="plantFormIsValid"
					style="width: 100%"
				>
					<FormErrors :errors="errors" class="mb-4" />

					<v-select
						v-model="plantForm.plant_uuid"
						label="Plant"
						:rules="[requiredField('plant')]"
						:readonly="plantForm.processing"
						:items="plants"
						class="mt-4"
					/>

					<div class="d-flex ga-4 mt-2">
						<v-btn
							color="error"
							:disabled="plantForm.processing"
							text="Cancel"
							@click="toggleForm('add')"
						/>

						<v-btn
							type="submit"
							color="primary"
							:loading="plantForm.processing"
							:disabled="!plantFormIsValid || plantForm.processing"
						>
							Add Plant
						</v-btn>
					</div>
				</v-form>

				<!-- Plant Create Form -->

				<PlantsForm
					v-if="isCreatingPlant"
					:errors="errors"
					:store-cb="createAndAddPlant"
					@cancel="toggleForm('create')"
					cancel
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
						<Link :href="route('gardening.plants.show', item)">
							{{ item.name }}
						</Link>
					</template>
				</v-data-table>
			</Section>
		</SectionList>
	</Layout>
</template>
