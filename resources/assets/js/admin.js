/**
 * Main Plugins
 */
var Vue = require('vue'),
		VueResource = require('vue-resource');

import Block  from './directives/Block'


/**
 * Components
 */
var Calendar = {
	Scheduler: require('./components/Calendar/Scheduler.vue'),
}
var Form = {
	Booking: require('./components/Form/Booking'),
	TimePicker: require('./components/Form/TimePicker')
}
var Discounts = {
	Discount: require('./components/Discount/Discount.vue'),
}
var Passes = {
	Pass: require('./components/Pass'),
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

/**
 * Vue instance
 */
var v = new Vue({
	el: 'body',
	events: {},
	data: {},
	methods: {},
	components: {
		'scheduler': Calendar.Scheduler,
		'discount': Discounts.Discount,
		'pass': Passes.Pass,
		'booking-form': Form.Booking,
		'time-picker': Form.TimePicker
	},
});