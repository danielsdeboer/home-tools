export type ResourceIcon = 'garden'

export interface Breadcrumb {
	title: string
	href: string
	disabled: boolean
}

export interface Header {
	text: string
	icon?: ResourceIcon
}

export interface Page {
	create_route?: string
	edit_route?: string
	breadcrumbs?: Breadcrumb[]
	header?: Header
	html_title?: string
}
