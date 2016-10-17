export default{
    /**
     * Name of the component
     * More info: http://vuejs.org/api/#name
     */
    name: 'Event',

    /**
     * The data object for the component it self
     * More info: http://vuejs.org/api/#data
     */
    data(){
        return {
            msg: 'Hello World event!'
        }
    },

    /**
     * Public properties
     */
    props : {
        event : {}
    },

    /**
     * Computed properties
     */
    computed: {
        isNew() {
            return this.event.isNew
        },
        title () {
            return this.isNew ? "Crear un evento" : "Editar evento"
        }
    },

    /**
     * This is called when the component is ready
     * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
     */
    ready () {
        console.log('Component is ready')
    },

    /**
     * Child components of this one
     * More info: http://vuejs.org/guide/components.html
     */
    components: {}
}