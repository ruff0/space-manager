import FileUpload from "../../../Form/File.vue";
import FormError from "../../../Form/Error";
import UButton from "../../../Button";
import Moment from "moment";
import {createEvent} from "../../../../state/actions";
export default{
    /**
     * Name of the component
     * More info: http://vuejs.org/api/#name
     */
    name: 'Event',

    vuex: {
        actions: {
            createEvent
        },
        getters: {
            loading: (state) => state.loading.isLoading,
            errors: (state) => state.errors,
        }
    },

    /**
     * The data object for the component it self
     * More info: http://vuejs.org/api/#data
     */
    data(){
        return {
            content: {
                ops: [{insert: ""}],
            },
            config: {
                placeholder: "Aquí pon la descripción de tú evento",
            },
            title: "",
            image: { id: null },
        }
    },

    /**
     * Public properties
     */
    props: {
        booking: null,
        event: {}
    },


    /**
     * Computed properties
     */
    computed: {
        isNew() {
            return this.event.isNew
        },
        header () {
            return this.isNew ? "Crear un evento" : "Editar evento"
        },
        eventImage () {
            return "/" + this.event.image
        },
        room () {
            if (this.booking)
                return this.booking.bookable.name
        },
        dateFrom () {
            if(this.booking)
                return Moment(this.booking.time_from);

            return Moment(this.event.date + " " + this.event.to)
        },
        dateTo () {
            if (this.booking)
                return Moment(this.booking.time_to);

            return Moment(this.event.date + " " + this.event.from)
        },
        descriptiveDate () {
            // vie, 11 de noviembre de 2016
            return this.dateFrom.format("dddd, DD") + " de " + this.dateFrom.format("MMMM") + " de " + this.dateFrom.format("YYYY")
        },
        descriptiveTime() {

            // 19:00 – 21:00 Hora estándar de Europa central Hora de España (Madrid)
            return this.dateFrom.format("HH:mm") + " - " + this.dateTo.format("HH:mm") + "hrs."
        },
        month () {
            return this.dateFrom.format("MMM")
        },
        day () {
            return this.dateFrom.format("DD")
        }


    },


    /**
     * This is called when the component is ready
     * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
     */
    ready () {
        console.log('Component is ready')
    },

    methods: {
        cancel() {
            window.history.back()
        },
        save(){
            this.createEvent({
                booking: this.booking.id,
                title: this.title,
                description: this.content.ops[0].insert,
                image: this.image.id,
            })
        },
        setImage(e) {
            this.image = e
        },
    },

    /**
     * Child components of this one
     * More info: http://vuejs.org/guide/components.html
     */
    components: {
        UButton,
        FormError,
        FileUpload
    }
}