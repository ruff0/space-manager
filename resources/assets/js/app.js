/**
 * Main Plugins
 */
var Vue = require('vue'),
	VueResource = require('vue-resource');
/**
 * Components
 */
var Form = {
		CreditCard: require('./components/Form/CreditCard.vue'),
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
new Vue({
	el: 'body',
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
	},
});
