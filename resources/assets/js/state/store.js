import Vue from 'vue'
import Vuex from 'vuex'
import _ from 'lodash'
/**
 * Mutation Types
 */
import {
	SET_LOADING,
	ADD_ERRORS,
	ADD_RESOURCES,
	ADD_PRICE,
	CLEAR_RESOURCES,
	CLEAR_PRICE
} from './mutation-types'

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
const initialState = {
	prices : {
		lines: [],
		calculated: false,
		totalFormated: '',
		subtotalFormated: '',
		vatFormated: '',
		vatPercentage: ''
	},
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
	[CLEAR_RESOURCES] (state) {
		state.resources = initialState.resources
	},
	[ADD_PRICE] (state, price) {
		state.prices = price
		state.prices.calculated = true
	},
	[CLEAR_PRICE] (state) {
		state.prices = initialState.prices
	},
}


export default new Vuex.Store({
	state: _.clone(initialState),
	mutations,
	modules: {
		booking
	}
})