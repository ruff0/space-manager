import {
	ADD_DATE,
	ADD_PERSONS,
	ADD_DISTRIBUTION,
	ADD_TIME_TO,
	ADD_TIME_FROM,
	ADD_TYPE,
	ADD_BOOKABLE,
	BOOKING_HAS_CHANGED,
	ADD_ERRORS,
	ADD_RESOURCES,
	CLEAR_RESOURCES,
	SET_LOADING,
	ADD_PRICE,
	ADD_MEMBER,
	ADD_MEMBERS,
	BOOKED,
	PAID,
	UNPAID,
	CANCELED,
	CLEAR_PRICE,
	CREATE_EVENT
} from './mutation-types'
import _ from 'lodash'
import events from './api/events'
import bookings from './api/bookings'
import members from './api/members'

export const setLoading = ({dispatch, state}, {loading, progress}) => {
	dispatch(SET_LOADING, {loading, progress})
}

export const payReservation = ({dispatch, state}, id) => {
	const data = _.merge({
		payment: 'card',
		action: 'pay',
		id
	}, state.booking)

	bookings.patch(
		data,
		// handle success
		(resources) => dispatch(PAID, data),
		// handle error
		(errors) => dispatch(ADD_ERRORS, errors)
	)
}

export const cancelReservation = ({dispatch, state}, id) => {
	bookings.cancel(
		id,
		// handle success
		(resources) => dispatch(CANCELED, data),
		// handle error
		(errors) => dispatch(ADD_ERRORS, errors)
	)
}

export const markReservationsAsPaid = ({dispatch, state}, id) => {
	const data = _.merge({
		payment: 'cash',
		action: 'markAsPaid',
		id
	})
	
	bookings.patch(
		data,
		// handle success
		(resources) => dispatch(PAID, data),
		// handle error
		(errors) => dispatch(ADD_ERRORS, errors)
	)
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

export const calculate = ({dispatch, state}, changed) => {
	const b = state.booking
	if(b.date && b.time_to && b.time_from && b.type && b.bookable) {
		bookings.calculate(
			state.booking,
			// handle success
			(prices) => {
				dispatch(ADD_PRICE, prices)
				if(changed)
				{
					dispatch(BOOKING_HAS_CHANGED, true)
				}
			},
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

export const addPersons = ({dispatch, state}, persons) => {
	dispatch(ADD_PERSONS, persons)
}

export const addDistribution = ({dispatch, state}, distribution) => {
	dispatch(ADD_DISTRIBUTION, distribution)
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

export const addBookable = ({dispatch, state}, bookable, changed = true) => {
	dispatch(CLEAR_PRICE)
	dispatch(ADD_BOOKABLE, bookable)
	calculate({dispatch, state}, changed)
}

export const addBooking = ({dispatch, state}, booking) => {
	dispatch(CLEAR_PRICE)

	const date = booking.time_from ? moment(new Date(booking.time_from)).format("YYYYMMDD") : null
	const time_from = booking.time_from ? moment(new Date(booking.time_from)).format("HHmm") : null
	const time_to = booking.time_to ? moment(new Date(booking.time_to)).format("HHmm") : null

	dispatch(ADD_DATE, date)
	dispatch(ADD_TIME_FROM, time_from)
	dispatch(ADD_TIME_TO, time_to)
	dispatch(booking.paid ? PAID : UNPAID)
	dispatch(ADD_DISTRIBUTION, booking.distribution)
	dispatch(ADD_PERSONS, booking.persons)

	calculate({dispatch, state})
}


export const createEvent = ({dispatch, state}, data) => {
	data = _.merge(state.event, data)
	events.store(
		data,
		// handle success
		(resources) => dispatch(CREATE_EVENT, data),
		// handle error
		(errors) => dispatch(ADD_ERRORS, errors)
	)


}