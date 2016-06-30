export default{
	/**
	 * Name of the component
	 * More info: http://vuejs.org/api/#name
	 */
	name: 'TimePicker',

	/**
	 * The data object for the component it self
	 * More info: http://vuejs.org/api/#data
	 */
	data(){
		return {
			timepicker: null,
		}
	},

 /**
	 *
	 */
	events: {
		'set': function (picker) {
			this.selected = picker.get('select', 'HHi')
			this.$emit('change', this.selected)
		}
	},
	/**
	 * Public properties
	 */
	props: {
		selected: null,
		value: {type: String},
		interval: {type: Number, default: 60},
		min: { type: Array, default: () => { return [8, 0] } },
		max: { type: Array, default: () => { return [21, 0] } },
		format: {type: String, default: 'HH:i'},
		formatLabel: {type: String, default: 'HH:i'},
		formatSubmit: {type: String, default: 'HHi'},
		hiddenPrefix: {type: String, default: ''},
		hiddenSuffix: {type: String, default: ''}
	},
	/**
	 * This is called when the component is ready
	 * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
	 */
	ready () {
		let self = this

		this.timepicker = $(this.$el).pickatime({
			interval: this.interval,
			min: this.min,
			max: this.max,
			// Escape any “rule” characters with an exclamation mark (!).
			format: this.format,
			formatLabel: this.formatLabel,
			formatSubmit: this.formatSubmit,
			hiddenPrefix: this.hiddenPrefix,
			hiddenSuffix: this.hiddenSuffix,
			onSet: function (context) {
				self.$emit('set', this)
			},
			onStart: function () {
				self.selected = self.value
				this.set('select', self.value)
			}
		});

	},

	/**
	 * Child components of this one
	 * More info: http://vuejs.org/guide/components.html
	 */
	components: {}
}