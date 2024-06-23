export interface ObservationsCount {
	observations_count: number
}

export interface Observation {
	uuid: string
	content: string
	observed_at: string
	status: 'info' | 'warning' | 'danger' | 'success'
}
