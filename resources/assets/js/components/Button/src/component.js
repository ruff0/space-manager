export default{
  /**
   * Name of the component
   * More info: http://vuejs.org/api/#name
   */
  name: 'Button',

  /**
   * The data object for the component it self
   * More info: http://vuejs.org/api/#data
   */
  data(){
    return {
			laddaInstance: null
    }
  },

	/**
	 *
	 */
	watch: {
		progress(value, oldValue) {
			this.setProgress(value)
		}
	},

	/**
	 * Computed properties
	 */
	computed : {
		klass () {
			return {
				'btn-ladda btn-ladda-progress': this.ladda,
				'legitRipple' : this.ripple,
				'btn-loading': this.loading
			}
		}
	},

	/**
	 * Public Properties
	 */
	props: {
		ladda : { type: Object, default () { return false } },
		ripple : { type: Boolean, default(){ return false }},
		progress : {type: Number, default () { return 1 }, coerce (value) { return parseFloat(value) }},
		color : { type: String, default(){ return 'default' }}
	},

  /**
   * This is called when the component is ready
   * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
   */
  ready () {
		if(this.ladda)
		{
			this.loadLadda()
		}
  },

  /**
   * Child components of this one
   * More info: http://vuejs.org/guide/components.html
   */
  components: {},

	/**
	 * Methods
	 */
	methods: {
		loadLadda() {
			this.laddaInstance = Ladda.create( this.$el )
		},
		startLadda() {
			this.laddaInstance.start()
			this.setProgress(this.progress)
		},
		setProgress(progress) {
			this.laddaInstance.setProgress(progress)
			if (progress === 1) {
				this.laddaInstance.stop()
			}
		}

	}
}