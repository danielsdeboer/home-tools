export interface PlantStub {
	uuid: string
	name: string
}

export interface Plant extends PlantStub {
	variety: string
	botanical: string
}

export interface PlantPlot extends PlantStub {
	planted_at: string
	garden: {
		name: string
	}
}

export interface PlantPlotsCount {
	plots_count: number
}
