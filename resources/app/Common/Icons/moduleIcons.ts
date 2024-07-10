import {
	mdiBinoculars,
	mdiGridLarge,
	mdiSelectMarker,
	mdiSprout,
} from '@mdi/js'
import { mdiCube, mdiNotebook } from '@mdi/js/commonjs/mdi'

export const moduleIcons = {
	gardening: {
		plant: mdiSprout,
		garden: mdiGridLarge,
		plot: mdiSelectMarker,
		observation: mdiBinoculars,
		project: mdiNotebook,
	},
	shopping: {
		items: mdiCube,
	},
}

export const resolveIcon =
	(module: keyof typeof moduleIcons) =>
	(icon: keyof (typeof moduleIcons)[keyof typeof moduleIcons]) =>
		moduleIcons[module][icon]
