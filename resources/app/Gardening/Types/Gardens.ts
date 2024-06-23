import { PlotShow } from './Plots'
import { Observation } from './Observations'

export interface GardenStub {
	uuid: string
	name: string
}

export interface Garden extends GardenStub {
	location: string
	description: string
}

export interface GardenShow extends Garden {
	plots: PlotShow[]
	observations: Observation[]
}
