export const required = (value: string, field?: string) => {
	const name = field ? `The ${field} field` : 'This field'

	return !!value || `${name} is required`
}

export const requiredField = (field: string) => (value: string) =>
	required(value, field)
