import {
	ADD_DATE,
	ADD_TIME_TO,
	ADD_TIME_FROM,
	ADD_TYPE,
	ADD_BOOKABLE,
	ADD_ERRORS,
	ADD_RESOURCES,
	SET_LOADING,
	ADD_PRICE
} from './mutation-types'
import bookings from './api/bookings'

export const setLoading = ({dispatch, state}, {loading, progress}) => {
	dispatch(SET_LOADING, {loading, progress})
}


export const searchBookables = ({dispatch, state}) => {
	const b = state.booking
	if(b.date && b.time_to && b.time_from && b.type) {
		bookings.getAll(
			state.booking,
			// handle success
			(resources) => dispatch(ADD_RESOURCES, resources),
		  // handle error
			(errors) => dispatch(ADD_ERRORS, errors)
		)
	}
}

export const calculate = ({dispatch, state}) => {
	const b = state.booking
	if(b.date && b.time_to && b.time_from && b.type && b.bookable) {
		bookings.calculate(
			state.booking,
			// handle success
			(prices) => dispatch(ADD_PRICE, prices),
		  // handle error
			(errors) => dispatch(ADD_ERRORS, errors)
		)
	}
}

export const addResources = ({dispatch, state}, resources) => {
	dispatch(ADD_RESOURCES, resources)
}

export const addErrors = ({dispatch, state}, errors) => {
	dispatch(ADD_ERRORS, errors)
}

export const addDate = ({dispatch, state}, date) => {
	dispatch(ADD_DATE, date)
	searchBookables({dispatch, state})
}

export const addTimeTo = ({dispatch, state}, timeTo) => {
	dispatch(ADD_TIME_TO, timeTo)
	searchBookables({dispatch, state})
}

export const addTimeFrom = ({dispatch, state}, timeFrom) => {
	dispatch(ADD_TIME_FROM, timeFrom)
	searchBookables({dispatch, state})
}

export const addType = ({dispatch, state}, type) => {
	dispatch(ADD_TYPE, type)
	searchBookables({dispatch, state})
}

export const addBookable = ({dispatch, state}, bookable) => {
	dispatch(ADD_BOOKABLE, bookable)
	searchBookables({dispatch, state})
}