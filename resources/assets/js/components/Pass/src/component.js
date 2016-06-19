import _ from 'lodash'

export default {
  /**
   * Name of the component
   * More info: http://vuejs.org/api/#name
   */
  name: 'Passes',

  /**
   * The data object for the component it self
   * More info: http://vuejs.org/api/#data
   */
  data(){
    return {
      available: [],
			passes: [],
			edit: false,
			selectedToDestroy: null,
			loading: true,
			select2: null,
			selected: {
				id: null,
				hours: null,
				date_to: null,
				bookable: null
			}
    }
  },

	/**
	 * The public attributes that this component accepts
	 */
	props: {
		token: {
			type: String,
			required: true
		},
		member: {
			type: Number,
			required: true
		},
		passes: {
			type: Array,
			default(){
				return []
			}
		}
	},

	computed: {
		filteredAvailables() {
			return _.filter(this.available, (a) => {
				return !_.find(this.passes, (p) => {
					return p.bookable.id == a.id
				})
			})


		}
	},

	/**
	 * This is called when the component is created
	 */
	created () {

	},

  /**
   * This is called when the component is ready
   * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
   */
  ready () {
		this.load()

		// Disable certain dates
		$('.pickadate-date').pickadate({
			// Escape any “rule” characters with an exclamation mark (!).
			format: 'dddd, dd mmm, yyyy',
			formatSubmit: 'yyyymmdd',
			hiddenPrefix: '',
			hiddenSuffix: '_date_to'
		});

		this.select2 = $('.select').select2({
			minimumResultsForSearch: Infinity
		}).on("select2:select", (value) => {
			let bookable = _.find(this.available, function (o) {
				return o.id == value.params.data.id;
			});
			this.selected.bookable = bookable
		});
	},

  /**
   * Child components of this one
   * More info: http://vuejs.org/guide/components.html
   */
  components: {},

	/**
	 *
	 */
	filters: {
		moment: function (date) {
			return moment(date).format('MMMM Do YYYY');
		}
	},

	/**
	 *
	 */
	methods: {
		clean () {
			this.selected = {
				id: null,
				hours: null,
				date_to: null,
				bookable: null
			};
		},

		reset () {
			this.select2.val(null).trigger("change")
			this.clean()
			this.edit = false
		},

		load () {
			this.loadPasses()
			this.loadBookables()
		},

		loadPasses () {

			this.loading = true

			this.$http.get(`/api/members/${this.member}/passes`).then(response => {
				this.passes = response.data

				this.loading = false
			});
		},

		loadBookables () {

			this.loading = true

			this.$http.get(`/api/bookables`).then(response => {
				this.available = response.data

				this.loading = false
			});
		},

		selectToDestroy (pass) {
			this.reset()
			this.selectedToDestroy = pass;
		},

		dismiss () {
			this.selectedToDestroy = null;			
		},

		destroy () {
			if(!this.selectedToDestroy)
				return dismiss()

			let pass = this.selectedToDestroy;

			this.loading = true;
			this.$http.delete(`/api/members/${this.member}/passes/${pass.id}`, {
				'_token': this.token,
			}).then(response => {
				this.passes.$remove(pass)
				this.selectedToDestroy = null
				this.loading = false
			})
		},

		save () {
			this.loading = true;
			this.$http.post(`/api/members/${this.member}/passes`, {

				'_token' : this.token,
				'hours' : this.selected.hours,
				'date_to' : this.selected.date_to,
				'bookable' : this.selected.bookable

			}).then(response => {
				this.selected.id = response.data.id
				this.passes.push(this.selected)
				this.reset()
				this.loading = false
			});
		},

		add () {
			this.dismiss()
			this.edit = true
			this.clean()
		}

	}
}