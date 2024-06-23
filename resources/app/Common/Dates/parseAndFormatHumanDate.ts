import { parseISO, formatDistance } from 'date-fns'

export const parseAndFormatHumanDate = (date: string): string => {
	const parsed = parseISO(date)

	return `${formatDistance(parsed, new Date())} ago`
}
