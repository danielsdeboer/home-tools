export interface Pagination<T> {
	page_current: number
	page_last: number
	page_size: number
	item_from: number
	items_to: number
	items_total: number
	data: T[]
}
