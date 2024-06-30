import {
	mdiBinoculars,
	mdiGridLarge,
	mdiSelectMarker,
	mdiSprout,
} from '@mdi/js'
import { mdiNotebook } from '@mdi/js/commonjs/mdi'

export const moduleIcons = {
	gardening: {
		plant: mdiSprout,
		garden: mdiGridLarge,
		plot: mdiSelectMarker,
		observation: mdiBinoculars,
		project: mdiNotebook,
	},
}

export const resolveIcon =
	(module: keyof typeof moduleIcons) =>
	(icon: keyof (typeof moduleIcons)[keyof typeof moduleIcons]) =>
		moduleIcons[module][icon]
