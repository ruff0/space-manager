export default {

	props : {
		member : {
			type : Number,
			required : true
		}
	},

	data(){
		return {
			plans: {
				percentage : 0,
				date_to: null
			},
			bookings: {
				percentage : 0,
				date_to: null
			},
			events: {
				percentage : 0,
				date_to: null
			}
		}
	},

	ready () {
		console.log('ready')
		console.log(this.member)
	}
}