/**
 * Main Plugins
 */
var Vue = require('vue'),
	VueResource = require('vue-resource'),
	VueQuill = require('./plugins/vue-quill/vue-quill'),
	Moment = require('moment');
    Moment.updateLocale('es', require("../../../node_modules/moment/locale/es.js"));
/**
 * Directives
 */
import Block  from './directives/Block'
import Medium  from './directives/Medium'

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

var Events = {
    Event: require('./components/Events/Event'),
}

/**
 * Vue Config
 */
Vue.config.debug = true;

/**
 * Directives
 */
Vue.directive('block', Block);
Vue.directive('medium', Medium);

/**
 * Vue Services
 */
Vue.use(VueResource);
Vue.use(VueQuill);

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
		'event': Events.Event,
		'event-form': Form.Event,
	},
});
