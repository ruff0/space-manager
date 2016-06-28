import _ from "lodash"
import TimePicker from "../../TimePicker"


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
			select2: null,
			types: [],
			selected:{
				type: null,
				date: null,
				time_to: null,
				time_from: null
			}
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
		this.$http.get('/api/bookable-types').then((response) => {
			this.types = response.data
		})

		this.select2 = $('.select').select2({
			minimumResultsForSearch: Infinity
		}).on("select2:select", (value) => {
			let bookable = _.find(this.bookables, (b) => {
				return b.id == value.params.data.id;
			});
			this.selected.type = bookable
		});

		$('.pickadate-date').pickadate({
			min: true,
			disable: [
				[2015, 8, 3],
				[2015, 8, 12],
				[2015, 8, 20]
			],
			// Escape any “rule” characters with an exclamation mark (!).
			format: 'dddd, dd mmm, yyyy',
			formatSubmit: 'yyyymmdd',
			hiddenPrefix: 'date',
			hiddenSuffix: ''
		});

		$('.pickatime-to').pickatime({
			interval: 60,
			min: [8, 0],
			max: [21, 0],
			// Escape any “rule” characters with an exclamation mark (!).
			format: 'HH:i',
			formatLabel: 'HH:i',
			formatSubmit: 'HHi',
			hiddenPrefix: 'time',
			hiddenSuffix: '-to'
		});
  },

  /**
   * Child components of this one
   * More info: http://vuejs.org/guide/components.html
   */
  components: {
		TimePicker
	}
}