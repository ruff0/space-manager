import Vue from 'vue'
import Vuex from 'vuex'
/**
 * Mutation Types
 */
import {SET_LOADING, ADD_ERRORS, ADD_RESOURCES, ADD_PRICE} from './mutation-types'

/**
 * Middlewares
 */

/**
 * Modules
 */
import booking from './modules/booking'

Vue.use(Vuex)


/**
 * Global app state
 * @type {{loading: {progress: number, isLoading: boolean}}}
 */
const state = {
	prices : {},
	resources: [],
	errors: [],
	loading: {
		progress: 1,
		isLoading: false
	}
}

/**
 * Global app mutations
 * @type {{}}
 */
const mutations = {
	[SET_LOADING] (state, {loading = true, progress = 1}) {
		state.loading.isLoading = loading
		state.loading.progress = progress
	},
	[ADD_ERRORS] (state, errors) {
		state.errors = errors
	},
	[ADD_RESOURCES] (state, resources) {
		state.resources = resources
	},
	[ADD_PRICE] (state, price) {
		state.prices = price
	}

}


export default new Vuex.Store({
	state,
	mutations,
	modules: {
		booking
	}
})