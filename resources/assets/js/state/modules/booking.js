import {
	ADD_DATE,
	ADD_TIME_TO,
	ADD_TIME_FROM,
	ADD_TYPE,
	ADD_BOOKABLE
} from '../mutation-types'

/**
 * Initial State
 * @type {{}}
 */
const state = {
	errors: [],
	resources: [],
	bookable: null,
	time_to: null,
	time_from: null,
	date: null,
	type: null
}

/**
 * Mutations
 * @type {{}}
 */
const mutations = {
	[ADD_DATE] (state, date) {
		state.date = date
	},
	[ADD_TIME_TO] (state, timeTo) {
		state.time_to = timeTo
	},
	[ADD_TIME_FROM] (state, timeFrom) {
		state.time_from = timeFrom
	},
	[ADD_BOOKABLE] (state, bookable) {
		state.bookable = bookable
	},
	[ADD_TYPE] (state, type) {
		state.type = type
	}
}

/**
 * Booking Module
 */
export default {
	state,
	mutations
}