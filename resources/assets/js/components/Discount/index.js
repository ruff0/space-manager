export default {

	props: {
		token: {
			type: String,
			required: true
		},
		member: {
			type: Number,
			required: true
		},
		discounts: {
			type: Object,
			default(){
				return {
					plans: {percentage: 0, date_to: null},
					bookings: {percentage: 0, date_to: null},
					events: {percentage: 0, date_to: null}
				}
			}
		}
	},

	data(){
		return {}
	},

	ready () {

		// Disable certain dates
		$('.pickadate-date').pickadate({
			// Escape any “rule” characters with an exclamation mark (!).
			format: 'dddd, dd mmm, yyyy',
			formatSubmit: 'yyyymmdd',
			hiddenPrefix: '',
			hiddenSuffix: '_date_to'
		});
	},
	methods: {
		save() {
			this.$http.post(`/api/members/${this.member}/discounts`, {
				_token: this.token,
				member: this.member,
				discounts: this.discounts
			}).then( function(response){});
		}
	}

}