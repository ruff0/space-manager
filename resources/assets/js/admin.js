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
var Calendar = {
	Scheduler: require('./components/Calendar/Scheduler.vue'),
}
var Form = {
	Booking: require('./components/Form/Booking'),
	Event: require('./components/Form/Event'),
	TimePicker: require('./components/Form/TimePicker')
}
var Discounts = {
	Discount: require('./components/Discount/Discount.vue'),
}
var Passes = {
	Pass: require('./components/Pass'),
}
var Table = {
	Price: require('./components/Tables/Price'),
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
	store.dispatch(SET_LOADING, { loading: true, progress: 0 })
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
	events: {},
	data: {},
	methods: {},
	components: {
		'scheduler': Calendar.Scheduler,
		'discount': Discounts.Discount,
		'pass': Passes.Pass,
		'booking-form': Form.Booking,
		'event-form': Form.Event,
		'price-table': Table.Price,
		'time-picker': Form.TimePicker
	},
});