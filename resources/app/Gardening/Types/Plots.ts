import { Plant, PlantsCount } from './Plants'
import { GardenShow, GardenStub } from './Gardens'
import { Observation, ObservationsCount } from './Observations'

export interface Plot {
	uuid: string
	name: string
	description: string | null
	planted_at: string
	germinated_at: string | null
	harvested_at: string | null
	status: 'current' | 'done'
}

export interface PlotGardenName {
	garden_name: string
}

export interface PlotPlantName {
	plant_name: string
}

export interface PlotShow extends Plot {
	plants: Plant[]
	garden: GardenShow
	observations: Observation[]
}

export interface PlotIndex extends Plot, PlantsCount, ObservationsCount {
	garden: GardenStub
}
