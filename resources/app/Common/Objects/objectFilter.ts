// Take an object and return it with any keys that are undefined, null, or
// empty strings removed.
export const objectFilter = (object: Record<string, unknown>) => {
	const filteredObject = {}

	for (const key in object) {
		if (
			object[key] !== undefined &&
			object[key] !== null &&
			object[key] !== ''
		) {
			filteredObject[key] = object[key]
		}
	}

	return filteredObject
}
