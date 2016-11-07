import _ from "lodash";
import TimePicker from "../../TimePicker";
import DatePicker from "../../DatePicker";
import Selectable from "../../Selectable";
import UButton from "../../../Button";
import FormError from "../../Error";
import FileUpload from '../../File.vue'

import {
    createEvent
} from "../../../../state/actions";

export default{
    /**
     * Name of the component
     * More info: http://vuejs.org/api/#name
     */
    name: 'Event',

    vuex: {
      actions : {
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
            form: {
                title: "",
                description: ""
            }
        }
    },
    /**
     *
     */
    events: {
        'vdropzone-success': function (file) {
            console.log('A file was successfully uploaded')
        },
        'vdropzone-success': function (file) {
            console.log('A file was successfully uploaded')
        }
    },

    /**
     * Public properties
     */
    props : {
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

    methods: {
        cancel(){},
        create(){
            this.createEvent({
                bookingId: this.booking,
                title: this.form.title,
                description: this.form.description
            })
        }

    },

    /**
     * Child components of this one
     * More info: http://vuejs.org/guide/components.html
     */
    components: {
        TimePicker,
        DatePicker,
        Selectable,
        UButton,
        FormError,
        FileUpload
    }
}