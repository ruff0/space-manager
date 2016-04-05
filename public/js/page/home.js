$(window).load(function () {
	if(App.needsProfile){
		$('#needsProfile').modal({
			backdrop : 'static',
			keyboard : false,
			show : true
		});
	}
});