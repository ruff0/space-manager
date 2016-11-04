/**
 * Main Plugins
 */
var Vue = require('vue'),
	VueResource = require('vue-resource');


/**
 * Directives
 */
import Block  from './directives/Block'

/**
 * State manager
 */
import store from './state/store'

/**
 * Actions
 */
import {SET_LOADING} from './state/mutation-types'

/**
 * Components
 */
var Form = {
		CreditCard: require('./components/Form/CreditCard.vue'),
		Event: require('./components/Form/Event'),
	}

/**
 * Vue Config
 */
Vue.config.debug = true;

/**
 * Directives
 */
Vue.directive('block', Block);

/**
 * Vue Services
 */
Vue.use(VueResource);


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value')

/**
 * Loading state interceptor
 */
Vue.http.interceptors.push((request, next) => {
	store.dispatch(SET_LOADING, {loading: true, progress: 0})
	next((response) => {
		setTimeout(() => {
			store.dispatch(SET_LOADING, {loading: false, progress: 1})
		}, 200)
	})
});


/**
 * Vue instance
 */
var v = new Vue({
	el: 'body',
	store: store,
	events: {
		'stripe::valid': function (valid) {
			this.isValid = valid
		},
	},
	data: {
		isValid: false,
		coupon: {},
	},
	methods: {},
	components: {
		'credit-card': Form.CreditCard,
		'event-form': Form.Event,
	},
});
