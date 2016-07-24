import _ from "lodash"
import TimePicker from "../../TimePicker"
import DatePicker from "../../DatePicker"
import Selectable from "../../Selectable"
import UButton from "../../../Button"
import FormError from "../../Error"

import {
	addDate,
	addPersons,
	addDistribution,
	addTimeTo,
	addTimeFrom,
	addType,
	addBookable,
	addBooking,
	getMembers,
	addMember,
	calculate,
	payReservation,
	cancelReservation,
	markReservationsAsPaid,
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
			addPersons,
			addDistribution,
			addTimeTo,
			addTimeFrom,
			addType,
			addBookable,
			addBooking,
			addMember,
			getMembers,
			payReservation,
			cancelReservation,
			markReservationsAsPaid,
			makeReservation,
			calculate
		},
		getters: {
			loading: (state) => state.loading.isLoading,
			errors: (state) => state.errors,
			resources: (state) => state.resources,
			members: (state) => state.members,
			distributions: (state) => state.distributions,
			member: (state) => {
				let currentMember = _.find(state.members, (m) => {
					return m.id == state.booking.member
				});
				if(currentMember) return currentMember

				return null
			},
			selected: (state) => state.booking,
			calculated: (state) => state.prices.calculated,
			hasChanged: (state) => state.booking.hasChanged
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
		booking: {},
		persons: null,
	},

	/**
	 *
	 */
	computed : {
		isNew() {
			return this.booking.isNew
		},
		hasResources () {
			return this.resources.length == 0
		},
		canBeCanceled () {
			return moment(new Date()).isBefore(moment(new Date(this.booking.time_from)))
				&& !this.isPaid
		},
		isPaid() {
			return this.selected.paid
		},
		canMakeReservation(){
			return (!this.isNew && this.member)? true : false
		},
		canPayWithCard() {
			return (this.member && this.member.hasCreditCard)? true: false;
		},
		message() {
			return  !this.isNew ? 'Ten en cuenta que al haber editado estas creando un reserva nueva!!!': ''
		},
		title () {
			return !this.isNew && this.hasChanged ? "Editar reserva" : "Crear una reserva"
		}
	},
	/**
	 * This is called before the element is rendered on the page
	 */
	beforeCompile () {
		this.getMembers()
		this.$http.get('/api/bookable-types').then((response) => {
			this.types = response.data
			if (!this.isNew) {
				this.addMember(this.booking.member_id)
				this.addType(this.booking.type)
			}
		})
		if (!this.isNew) {
			this.addBooking(this.booking)
			setTimeout(()=>{
				this.addBookable(this.booking.bookable_id, false)
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
			this.addPersons(this.persons)
			this.makeReservation({ payment: 'cash' })
		},
		reserveAndPay () {
			this.addPersons(this.persons)
			this.makeReservation({ payment: 'card' })
		},
		pay () {
			this.payReservation(this.booking.id)
		},
		cancel () {
			this.cancelReservation(this.booking.id)
		},
		markAsPaid () {
			this.markReservationsAsPaid(this.booking.id)
		}
	}
}