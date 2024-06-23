import { parseISO, format } from 'date-fns'

export const parseAndFormatDate = (date: string): string => {
	const parsed = parseISO(date)

	return format(parsed, 'yyyy-MM-dd')
}
