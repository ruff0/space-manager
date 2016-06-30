import _ from 'lodash'

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
			immediate: true,
			handler (value, oldValue) {
				if(value.length == 0 && this.selectable) {
					this.selectable.val(null).trigger('change')
					return;
				}
			}
		},
		value: {
			immediate: true,
			handler (value, oldValue) {
				if (value && this.selectable) {
					this.selectable.val(value).trigger('change')
				}
			}
		}
	},
	/**
	 * Public properties
	 */
	props: {
		selected: null,
		value: { default: () => { return null } },
		searchbox: { type: Boolean, default: () => { return false } },
		options: { type: Array, default: () => { return [] } },
		optionsLabel: { type: String, default: () => { return 'name' } },
		withImage: { type: Boolean, default: () => { return true } },
		imageNode: { type: String, default: () => { return 'image' } },
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
		let options =

		this.selectable = $(this.$el).select2( this.composeOptions() )
			.on("select2:select", (event) => {
				this.$emit('set', this, "select2:select", event)
			})

		this.selectable.val(this.value).trigger('change')
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
		},

		composeOptions () {
			let options = {};

			if(!this.searchbox) options.minimumResultsForSearch = Infinity

			options.templateResult = this.formatState

			return options
		},
		formatState (state) {
			let selected = _.find(this.options, (b) => {
				return b.id == state.id
			})

			if(this.withImage && selected && selected[this.imageNode]) {
				var $state = $(
					'<span><img src="' + selected[this.imageNode] + '"/> ' + state.text + '</span>'
				);
				return $state;
			}
			return state.text;
		}
	}
	
}