import _ from "lodash"
import TimePicker from "../../TimePicker"
import DatePicker from "../../DatePicker"
import Selectable from "../../Selectable"
import UButton from "../../../Button"
import FormError from "../../Error"


export default{
  /**
   * Name of the component
   * More info: http://vuejs.org/api/#name
   */
  name: 'Booking',

  /**
   * The data object for the component it self
   * More info: http://vuejs.org/api/#data
   */
  data () {
    return {
			types: [],
			resources: [],
			progress: 1,
			errors: [],
			selected : {
				type: null,
				date: null,
				time_to: null,
				time_from: null,
				bookable: null
			}
    }
  },

	/**
	 * Public properties
	 */
	props: {
		token: { type: String, required: true }
	},

	/**
	 *
	 */
	computed : {
		hasResources () {
			return this.resources.length === 0
		}
	},
	/**
	 * This is called before the element is rendered on the page
	 */
	beforeCompile () {

	},

  /**
   * This is called when the component is ready
   * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
   */
  ready () {
		this.loading = true
		this.$http.get('/api/bookable-types').then((response) => {
			this.types = response.data
			this.loading = false
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
		search () {
			this.selected._token = this.token
			this.loading = true

			this.$http.get('/api/bookings', {
					before: () => {
						this.progress = 0
					},
					params:	this.selected
				}
			).then((response) => {
				this.progress = 1
				const data = response.data
				this.resources = data.available.concat(data.notavailable)
				this.errors = []

			}, (response) => {
				if(response.status == 422)
				{
					this.progress = 1
					this.errors = response.data
				}
			})
		},

		calculate () {
			this.selected._token = this.token
			this.loading = true
			this.$http.post('/api/bookings/calculate', this.selected, {
				before: () => {
					this.progress = 0
				}
			}).then((response) => {
				this.progress = 1
				const data = response.data
				this.resources = data.available.concat(data.notavailable)
			}, (response) => {
				if (response.status == 422) {
					this.progress = 1
					this.errors = response.data
				}
			})
		},
	}
}