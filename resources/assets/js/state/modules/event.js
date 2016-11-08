import {
    CREATE_EVENT
} from '../mutation-types'

/**
 * Initial State
 * @type {{}}
 */
const state = {
    booking: null,
    title: "",
    description: ""
}

/**
 * Mutations
 * @type {{}}
 */
const mutations = {
    [CREATE_EVENT] (state, event) {
        state.bookingId = event.booking
        state.title = event.title
        state.description = event.description
    }
}

/**
 * Booking Module
 */
export default {
    state,
    mutations
}