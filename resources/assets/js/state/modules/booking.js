import {
	ADD_DATE,
	ADD_TIME_TO,
	ADD_TIME_FROM,
	ADD_TYPE,
	ADD_BOOKABLE,
	ADD_MEMBER,
	PAID,
	UNPAID
} from '../mutation-types'

/**
 * Initial State
 * @type {{}}
 */
const state = {
	bookable: null,
	time_to: null,
	time_from: null,
	date: null,
	type: null,
	member: null,
	paid: false
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
	},
	[ADD_MEMBER] (state, member) {
		state.member = member
	},
	[PAID](state) {
		state.paid =  true
	},
	[UNPAID](state) {
		state.paid =  false
	}
}

/**
 * Booking Module
 */
export default {
	state,
	mutations
}