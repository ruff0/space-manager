export default{
  /**
   * Name of the component
   * More info: http://vuejs.org/api/#name
   */
  name: 'FormError',

  /**
   * Public properties
   */
  props: {
		errors: {type: Array, default(){ return [] }}
  },
}