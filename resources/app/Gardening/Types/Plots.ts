import { Plant } from './Plants'
import { GardenShow } from './Gardens'
import { Observation } from './Observations'

export interface Plot {
	uuid: string
	name: string
	description: string | null
	planted_at: string
	germinated_at: string | null
	harvested_at: string | null
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
