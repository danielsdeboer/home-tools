<script setup lang="ts">
	import { mdiClose, mdiPencil } from '@mdi/js'
	import { parseAndFormatDate } from '../../Dates/parseAndFormatDate.js'
	import { parseAndFormatHumanDate } from '../../Dates/parseAndFormatHumanDate.js'
	import { PropType } from 'vue'
	import ObservationForm from './ObservationForm.vue'
	import { InertiaForm } from '@inertiajs/vue3'
	import { Observation } from '../../../Gardening/Types/Observations'
	import WhitespaceText from '../Form/Content/WhitespaceText.vue'

	const emit = defineEmits<{
		(e: 'cancelCreate'): void
		(e: 'cancelEdit'): void
		(e: 'initEdit', uuid: string): void
	}>()

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
		observations: {
			type: Array as PropType<Observation[]>,
			required: true,
		},
		isCreating: {
			type: Boolean,
			required: true,
		},
		editingUuid: {
			type: String,
			default: undefined,
		},
		storeCb: {
			type: Function as PropType<(form: InertiaForm) => void>,
			required: true,
		},
		updateCb: {
			type: Function as PropType<(form: InertiaForm) => void>,
			required: true,
		},
	})

	const isEditing = (observation: Observation) =>
		props.editingUuid === observation.uuid
</script>

<template>
	<v-timeline
		side="end"
		truncate-line="both"
		justify="auto"
		style="grid-template-columns: max-content min-content auto"
		size="small"
	>
		<v-timeline-item v-if="isCreating" width="100%" fill-dot>
			<template v-slot:opposite> New observation </template>

			<v-alert>
				<v-row>
					<v-col>
						<ObservationForm :errors="errors" :persist="storeCb" />
					</v-col>

					<v-col cols="auto">
						<v-btn
							:icon="mdiClose"
							size="x-small"
							@click="emit('cancelCreate')"
						/>
					</v-col>
				</v-row>
			</v-alert>
		</v-timeline-item>

		<v-timeline-item
			v-for="observation in observations"
			:key="observation.uuid"
			:dot-color="observation.status"
			width="100%"
			fill-dot
		>
			<template v-slot:opposite>
				<div class="text-right">
					<p v-text="parseAndFormatDate(observation.observed_at)" />
					<p
						class="text-caption"
						v-text="parseAndFormatHumanDate(observation.observed_at)"
					/>
				</div>
			</template>

			<v-alert border="start" :border-color="observation.status">
				<v-row>
					<v-col v-if="isEditing(observation)">
						<ObservationForm
							:observation="observation"
							:errors="errors"
							:persist="updateCb"
						/>
					</v-col>

					<v-col v-else>
						<WhitespaceText :text="observation.content" />
					</v-col>

					<v-col cols="auto">
						<v-btn
							v-if="isEditing(observation)"
							:icon="mdiClose"
							size="x-small"
							@click="emit('cancelEdit')"
						/>

						<v-btn
							v-else
							:icon="mdiPencil"
							size="x-small"
							@click="emit('initEdit', observation.uuid)"
							:disabled="!!editingUuid"
						/>
					</v-col>
				</v-row>
			</v-alert>
		</v-timeline-item>
	</v-timeline>
</template>
