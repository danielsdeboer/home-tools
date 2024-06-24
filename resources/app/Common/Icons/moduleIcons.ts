import { mdiGridLarge, mdiSelectMarker, mdiSprout } from '@mdi/js'

export const moduleIcons = {
	gardening: {
		plant: mdiSprout,
		garden: mdiGridLarge,
		plot: mdiSelectMarker,
	},
}

export const resolveIcon =
	(module: keyof typeof moduleIcons) =>
	(icon: keyof (typeof moduleIcons)[keyof typeof moduleIcons]) =>
		moduleIcons[module][icon]
