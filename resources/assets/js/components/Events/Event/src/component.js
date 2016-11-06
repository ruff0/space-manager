import FileUpload from '../../../Form/File.vue';
import FormError from "../../../Form/Error";
import UButton from "../../../Button";
import Moment from "moment"

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
        ops: [],
      },
      config: {
        placeholder: 'Compose an epic...',
        debug: 'info',
      },
      title: '',
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

    room () {
      return this.booking.bookable.name
    },

    dateFrom () {
      return Moment(this.booking.time_from);
    },
    dateTo () {
      return Moment(this.booking.time_to);
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

  methods : {
    cancel() {},
    create(){
      this.createEvent({
        bookingId: this.booking,
        title: this.title,
        description: this.content.ops[0].insert
      })
    }
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