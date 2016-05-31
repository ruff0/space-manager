/**
 * Main Plugins
 */
var Vue = require('vue'),
		VueResource = require('vue-resource');
/**
 * Components
 */
var Calendar = {
	Scheduler: require('./components/Calendar/Scheduler.vue'),
}

var Discounts = {
	Discount: require('./components/Discount/Discount.vue'),
}

/**
 * Vue Config
 */
Vue.config.debug = true;

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
	},
});