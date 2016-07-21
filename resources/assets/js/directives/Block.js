export default {
	bind: function () {},
	update: function (newValue, oldValue) {
		if (newValue) {
			$(this.el).block({
				message: '<i class="icon-spinner10 spinner"></i>',
				overlayCSS: {
					backgroundColor: '#fafafa',
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

