export default {
	bind: function () {
		// do preparation work
		// e.g. add event listeners or expensive stuff
		// that needs to be run only once
		console.log(this.el)
	},
	update: function (newValue, oldValue) {
		if (newValue) {
			$(this.el).block({
				message: '<i class="icon-spinner10 spinner"></i>',
				overlayCSS: {
					backgroundColor: '#1B2024',
					opacity: 0.85,
					cursor: 'wait'
				},
				css: {
					border: 0,
					padding: 0,
					backgroundColor: 'none',
					color: '#fff'
				}
			});
		} else {
			$(this.el).unblock()
		}
	}
}

