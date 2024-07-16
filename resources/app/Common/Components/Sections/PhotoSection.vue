<script setup lang="ts">
	import { mdiImage } from '@mdi/js'
	import Section from './Section.vue'
	import SectionHeader from './SectionHeader.vue'
	import PhotosForm from '../../../Gardening/Forms/PhotosForm.vue'
	import { computed, PropType, ref } from 'vue'
	import { Photo } from '../../../Gardening/Types/Photo'
	import { InertiaForm } from '@inertiajs/vue3'
	import { Observation } from '../../../Gardening/Types/Observations'

	const props = defineProps({
		photos: {
			type: Array as PropType<Photo[]>,
			required: true,
		},
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		persist: {
			type: Function as PropType<
				(form: InertiaForm, observation?: Observation) => void
			>,
			required: true,
		},
	})

	const isCreatingPhoto = ref(false)

	const showPhotoDialog = ref(false)
	const showPhotoUuid = ref(null)
	const showPhoto = computed<Photo | undefined>(() => {
		return props.photos.find((photo) => photo.uuid === showPhotoUuid.value)
	})

	const setShowPhoto = (uuid: string) => {
		showPhotoDialog.value = true

		showPhotoUuid.value = uuid
	}

	const unsetShowPhoto = () => {
		showPhotoDialog.value = false

		showPhotoUuid.value = null
	}
</script>

<template>
	<Section>
		<SectionHeader
			:icon="mdiImage"
			text="Photos"
			:has-create="true"
			:is-creating="isCreatingPhoto"
			@toggle-create="isCreatingPhoto = !isCreatingPhoto"
		/>

		<PhotosForm
			v-if="isCreatingPhoto"
			:errors
			:persist
			class="mt-4"
			@cancel="isCreatingPhoto = false"
		/>

		<div class="photo-thumbnail-grid mt-4">
			<v-img
				v-for="photo in photos"
				:key="photo.uuid"
				:src="photo.thumb || photo.src"
				aspect-ratio="1"
				@click="setShowPhoto(photo.uuid)"
			/>
		</div>

		<v-empty-state
			v-if="!isCreatingPhoto && !photos?.length"
			:icon="mdiImage"
			title="No Photos Yet"
			size="20px"
		/>

		<v-dialog v-model="showPhotoDialog" width="auto" @click="unsetShowPhoto">
			<div
				style="height: 90vh; width: 95vw"
				class="d-flex align-center justify-center"
			>
				<v-img v-if="showPhoto" :src="showPhoto.src" width="100%" />
			</div>
		</v-dialog>
	</Section>
</template>
