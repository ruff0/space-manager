export default{
    /**
     * Name of the component
     * More info: http://vuejs.org/api/#name
     */
    name: 'Button',

    /**
     * Vuex instance
     */
    vuex: {
        getters: {
            progress: (state) => state.loading.progress,
            isLoading: (state) => state.loading.isLoading
        }
    },
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
        progress: {
            handler(value) {
                this.setProgress(value)
            },
            immediate: true
        }
    },

    /**
     * Computed properties
     */
    computed: {
        klass () {
            return {
                'btn-ladda btn-ladda-progress': this.ladda,
                'legitRipple': this.ripple,
                'btn-loading': this.loading
            }
        }
    },

    /**
     * Public Properties
     */
    props: {
        ladda: {
            type: Object, default () {
                return false
            }
        },
        ripple: {
            type: Boolean, default(){
                return false
            }
        },
        color: {
            type: String, default(){
                return 'default'
            }
        }
    },

    /**
     * This is called when the component is ready
     * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
     */
    ready () {
        this.load()
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
        load() {
            if (!this.isLoaded() && this.isLadda()) this.laddaInstance = Ladda.create(this.$el)
        },

        start() {
            if (this.isLoaded()) this.laddaInstance.start()
        },

        stop() {
            if (this.isLoaded()) this.laddaInstance.stop()
        },

        setProgress(progress) {
            if (this.isLoaded()) {
                this.laddaInstance.setProgress(progress)
                if (progress == 1) {
                    this.stop()
                }
            }
        },

        isLadda() {
            return this.ladda
        },

        isLoaded() {
            return this.laddaInstance
        }


    }
}