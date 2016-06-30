import _ from "lodash"
import TimePicker from "../../TimePicker"
import DatePicker from "../../DatePicker"
import Selectable from "../../Selectable"
import UButton from "../../../Button"
import FormError from "../../Error"

import {
	addDate,
	addTimeTo,
	addTimeFrom,
	addType,
	addBookable,
	addBooking,
	getMembers,
	addMember,
	calculate,
	makeReservation
} from '../../../../state/actions'




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
			addBooking,
			addMember,
			getMembers,
			makeReservation,
			calculate
		},
		getters: {
			loading: (state) => state.loading.isLoading,
			errors: (state) => state.errors,
			resources: (state) => state.resources,
			members: (state) => state.members,
			member: (state) => {
				let currentMember = _.find(state.members, (m) => {
					return m.id == state.booking.member
				});
				if(currentMember) return currentMember

				return null
			},
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
	props: {
		booking: {}
	},

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
	beforeCompile () {
		this.getMembers()
		this.$http.get('/api/bookable-types').then((response) => {
			this.types = response.data
			if (this.booking) {
				this.addMember(this.booking.member_id)
				this.addType(this.booking.bookable_id)

			}
		})
		if (this.booking) {
			this.addBooking(this.booking)
			setTimeout(()=>{
				this.addBookable(this.booking.bookable_id)
			}, 1500)
		}
	},

  /**
   * This is called when the component is ready
   * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
   */
  ready () {

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
		reserve () {
			this.makeReservation({ payment: 'cash' })
		},
		reserveAndPay () {
			this.makeReservation({ payment: 'card' })
		}
	}
}