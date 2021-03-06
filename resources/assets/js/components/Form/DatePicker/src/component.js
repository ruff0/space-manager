export default{

  /**
   * Name of the component
   * More info: http://vuejs.org/api/#name
   */
  name: 'DatePicker',

  /**
   * The data object for the component it self
   * More info: http://vuejs.org/api/#data
   */
  data() {
    return {
			datepicker: null,
    }
  },

	/**
	 *
	 */
	events: {
		'set': function (picker) {
			this.selected = picker.get('select', 'yyyymmdd')
			this.$emit('change', this.selected)
		}
	},

	/**
	 * Public properties
	 */
	props: {
		disabled: {
			type: Boolean, default: () => {
				return false
			}
		},
		selected: null,
		value: {
			coerce: (value) => {
				const date =  value ? moment( value ).format('YYYY/MM/DD') : null
				return date
			}
		},
		interval: {type: Number, default: 60},
		disable: {
			type: Array, default: () => {
				return [
					[2015, 8, 3],
					[2015, 8, 12],
					[2015, 8, 20]
				]
			}
			},
		min: {
			type: Array, default: () => {
				return true
			}
		},
		max: {
			type: Array, default: () => {
				return undefined
			}
		},
		format: {type: String, default: 'dddd, dd mmm, yyyy'},
		formatLabel: {type: String, default: 'dddd, dd mmm, yyyy'},
		formatSubmit: {type: String, default: 'yyyy/mm/dd'},
		hiddenPrefix: {type: String, default: ''},
		hiddenSuffix: {type: String, default: ''}
	},

  /**
   * This is called when the component is ready
   * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
   */
  ready () {
		let self = this

		this.datepicker = $(this.$el).pickadate({
			interval: this.interval,
			min: this.min,
			max: this.max,
			editable: this.disabled,
			// Escape any “rule” characters with an exclamation mark (!).
			format: this.format,
			formatLabel: this.formatLabel,
			formatSubmit: this.formatSubmit,
			hiddenPrefix: this.hiddenPrefix,
			hiddenSuffix: this.hiddenSuffix,
			onSet: function (context) {
				self.$emit('set', this)
			}
		});

		// this.datepicker.set('select', this.value, {format: 'yyyymmdd'})
  },

  /**
   * Child components of this one
   * More info: http://vuejs.org/guide/components.html
   */
  components: {}
}