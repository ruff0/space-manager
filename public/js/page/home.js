var defaults = {
	needsMemberData: false,
	cancelSubscription: false,
	needsPaymentMethod: false
};

App = App || defaults;
/**
 * If needed we load the modal
 */
if (App && App.needsMemberData) {
	$('#needsMemberData').modal({
		backdrop: 'static',
		keyboard: false,
		show: true
	});
}

if (App && App.needsPaymentMethod) {
	$('#needsPaymentMethod').modal({
		show: true
	});
}

if (App && App.cancelSubscription) {
	$('#cancelSubscription').modal({
		show: true
	});
}