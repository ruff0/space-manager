export default{
  /**
   * Name of the component
   * More info: http://vuejs.org/api/#name
   */
  name: 'Selectable',

  /**
   * The data object for the component it self
   * More info: http://vuejs.org/api/#data
   */
  data(){
    return {
			selectable: null
    }
  },

	/**
	 *
	 */
	computed: {
	},

	/**
	 *
	 */
	events: {
		'set': function (selectable, name, evt) {
			if(this.options.length > 0)
			{
				let selected = _.find(this.options, (b) => {
					return b.id == evt.params.data.id
				});

				if (selected)
					this.selected = selected.id

				this.$emit('change', this.selected)
			}
		}
	},
	watch: {
		options: {
			handler (value, oldValue) {
				console.log(value.length == 0)
				if(value.length == 0 && this.selectable) {
					this.selectable.val(null).trigger('change')
				}
			},
			immediate: true
		}
	},
	/**
	 * Public properties
	 */
	props: {
		selected: null,
		options: { type: Array, default: () => { return [] } },
		placeholder: { type: String, default: () => { return 'Selecciona …' } },
		disabled: { type: Boolean, default: () => { return false } },
		optionConditionDisable: { type: String, default: () => { return true } },
		optionConditionOposite: { type: Boolean, default: () => { return false } },

	},
  /**
   * This is called when the component is ready
   * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
   */
  ready () {
		this.selectable = $(this.$el).select2({
			minimumResultsForSearch: Infinity
		}).on("select2:select", (event) => {
			this.$emit('set', this, "select2:select", event)
		})
  },

  /**
   * Child components of this one
   * More info: http://vuejs.org/guide/components.html
   */
  components: {},
	
	methods: {
		isOptionDisabled (option) {
			let disabled = option[this.optionConditionDisable]
			return (this.optionConditionOposite)? !disabled : disabled
		}
	}
	
}