export default{
  /**
   * Name of the component
   * More info: http://vuejs.org/api/#name
   */
  name: 'PriceTable',

	/**
	 * Vuex instance
	 */
	vuex: {
		getters: {
			loading: (state) => state.loading.isLoading,
			errors: (state) => state.errors,
			prices: (state) => state.prices,
			resources: (state) => state.resources,
			subtotal: (state) => state.prices.subtotalFormated,
			total: (state) => state.prices.totalFormated,
			vat: (state) => state.prices.vatFormated,
			percentage: (state) => state.prices.vatPercentage,
			lines: (state) => state.prices.lines,
			calculated: (state) => state.prices.calculated
		}
	},
  /**
   * The data object for the component it self
   * More info: http://vuejs.org/api/#data
   */
  data () {
    return {}
  },

  /**
   * This is called when the component is ready
   * You can find further documentation : http://vuejs.org/guide/instance.html#Lifecycle-Diagram
   */
  ready () {},

  /**
   * Child components of this one
   * More info: http://vuejs.org/guide/components.html
   */
  components: {}
}