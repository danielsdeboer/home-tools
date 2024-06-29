export interface ObservationsCount {
	observations_count: number
}

export interface Observation {
	uuid: string
	content: string
	observed_at: string
	status: 'info' | 'warning' | 'danger' | 'success'
}

export interface Observable {
	observable_uuid: string
	observable_type: 'garden' | 'plot' | 'plant'
	observable_name: string
}
