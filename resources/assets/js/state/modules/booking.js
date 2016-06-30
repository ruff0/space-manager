import {
	ADD_DATE,
	ADD_TIME_TO,
	ADD_TIME_FROM,
	ADD_TYPE,
	ADD_BOOKABLE,
	ADD_MEMBER
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
	type: null,
	member: null,
}

/**
 * Mutations
 * @type {{}}
 */
const mutations = {
	[ADD_DATE] (state, date) {
		console.log(ADD_DATE, date)
		state.date = date
	},
	[ADD_TIME_TO] (state, timeTo) {
		console.log(ADD_TIME_TO, timeTo)
		state.time_to = timeTo
	},
	[ADD_TIME_FROM] (state, timeFrom) {
		console.log(ADD_TIME_FROM, timeFrom)
		state.time_from = timeFrom
	},
	[ADD_BOOKABLE] (state, bookable) {
		console.log(ADD_BOOKABLE, bookable)
		state.bookable = bookable
	},
	[ADD_TYPE] (state, type) {
		console.log(ADD_TYPE, type)
		state.type = type
	},
	[ADD_MEMBER] (state, member) {
		console.log(ADD_MEMBER, member)
		state.member = member
	}
}

/**
 * Booking Module
 */
export default {
	state,
	mutations
}