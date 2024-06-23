<script setup lang="ts">
	import { computed, PropType, ref } from 'vue'
	import { mdiEyeOff, mdiEye } from '@mdi/js'
	import { useForm } from '@inertiajs/vue3'

	const props = defineProps({
		errors: {
			type: Object as PropType<Record<string, string>>,
			default: () => ({}),
		},
	})

	const form = useForm({
		email: '',
		password: '',
	})
	const passwordVisible = ref(false)
	const formIsValid = ref(false)

	const hasErrors = computed(() => Object.keys(props.errors).length > 0)

	const required = (value: string) => !!value || 'This field is required'
</script>

<template>
	<v-app>
		<v-main
			class="h-screen w-100 overflow-hidden d-flex flex-column justify-center align-center"
		>
			<div class="d-flex flex-column ga-5" style="min-width: 20rem">
				<h1>Home Tools</h1>

				<v-alert v-if="hasErrors" title="Login Error" type="error">
					<div v-for="(error, key) in errors" :key="key" v-text="error" />
				</v-alert>

				<v-form @submit.prevent="form.post('/')" v-model="formIsValid">
					<v-text-field
						v-model="form.email"
						label="Email"
						placeholder="email@domain.com"
						:rules="[required]"
						class="mb-2"
					/>

					<v-text-field
						:append-inner-icon="passwordVisible ? mdiEyeOff : mdiEye"
						v-model="form.password"
						:type="passwordVisible ? 'text' : 'password'"
						:rules="[required]"
						label="Password"
						@click:append-inner="passwordVisible = !passwordVisible"
					/>

					<v-btn
						class="mt-2"
						type="submit"
						block
						:loading="form.processing"
						:disabled="!formIsValid || form.processing"
					>
						<span v-text="'Login'" />
					</v-btn>
				</v-form>
			</div>
		</v-main>
	</v-app>
</template>
