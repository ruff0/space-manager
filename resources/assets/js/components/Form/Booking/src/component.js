import _ from "lodash"
import TimePicker from "../../TimePicker"
import DatePicker from "../../DatePicker"
import Selectable from "../../Selectable"
import UButton from "../../../Button"
import FormError from "../../Error"
import {addDate, addTimeTo, addTimeFrom, addType, addBookable, calculate} from '../../../../state/actions'




export default {
  /**
   * Name of the component
   * More info: http://vuejs.org/api/#name
   */
  name: 'Booking',

	/**
	 * Vuex instance
	 */
	vuex: {
		actions : {
			addDate,
			addTimeTo,
			addTimeFrom,
			addType,
			addBookable,
			calculate
		},
		getters: {
			loading: (state) => state.loading.isLoading,
			errors: (state) => state.errors,
			resources: (state) => state.resources,
			selected: (state) => state.booking,
			calculated: (state) => state.prices.calculated
		}
	},

  /**
   * The data object for the component it self
   * More info: http://vuejs.org/api/#data
   */
  data () {
    return {
			types: []
    }
  },

	/**
	 * Public properties
	 */
	props: {},

	/**
	 *
	 */
	computed : {
		hasResources () {
			return this.resources.length == 0
		}
	},
	/**
	 * This is called before the element is rendered on the page
	 */
	beforeCompile () {},

  /**
   * This is called when the component is ready
   * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
   */
  ready () {
		this.$http.get('/api/bookable-types').then((response) => {
			this.types = response.data
		})
  },

  /**
   * Child components of this one
   * More info: http://vuejs.org/guide/components.html
   */
  components: {
		TimePicker,
		DatePicker,
		Selectable,
		UButton,
		FormError
	},

	/**
	 *
	 */
	methods: {
		reserve(){

		},
		reserveAndPay(){

		}
	}
}