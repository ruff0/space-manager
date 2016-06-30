import {
	ADD_DATE,
	ADD_TIME_TO,
	ADD_TIME_FROM,
	ADD_TYPE,
	ADD_BOOKABLE,
	ADD_ERRORS,
	ADD_RESOURCES,
	CLEAR_RESOURCES,
	SET_LOADING,
	ADD_PRICE,
	ADD_MEMBER,
	ADD_MEMBERS,
	BOOKED,
	CLEAR_PRICE
} from './mutation-types'
import _ from 'lodash'
import bookings from './api/bookings'
import members from './api/members'

export const setLoading = ({dispatch, state}, {loading, progress}) => {
	dispatch(SET_LOADING, {loading, progress})
}

export const makeReservation = ({dispatch, state}, data) => {
	data = _.merge(data, state.booking)
	bookings.store(
		data,
		// handle success
		(resources) => dispatch(BOOKED, data),
		// handle error
		(errors) => dispatch(ADD_ERRORS, errors)
	)
}

export const searchBookables = ({dispatch, state}) => {
	const b = state.booking
	if(b.date && b.time_to && b.time_from && b.type) {
		dispatch(CLEAR_PRICE)
		dispatch(CLEAR_RESOURCES)
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

export const getMembers = ({dispatch, state}) => {
	members.getAll(
		{},
		// handle success
		(members) => dispatch(ADD_MEMBERS, members),
		// handle error
		(errors) => dispatch(ADD_ERRORS, errors)
	)
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

export const addMember = ({dispatch, state}, user) => {
	dispatch(ADD_MEMBER, user)
	searchBookables({dispatch, state})
}

export const addBookable = ({dispatch, state}, bookable) => {
	dispatch(CLEAR_PRICE)
	dispatch(ADD_BOOKABLE, bookable)
	calculate({dispatch, state})
}

export const addBooking = ({dispatch, state}, booking) => {
	dispatch(CLEAR_PRICE)
	dispatch(ADD_DATE, moment(new Date(booking.time_from)).format("YYYYMMDD"))
	dispatch(ADD_TIME_FROM, moment(new Date(booking.time_from)).format("HHmm"))
	dispatch(ADD_TIME_TO, moment(new Date(booking.time_to)).format("HHmm"))
	calculate({dispatch, state})
}