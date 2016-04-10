
/**
 * Creates a ajax request from a anchor
 */
$("[role=delete-form]").on('click', function (e) {
	e.preventDefault();
	var $el = $(e.currentTarget);

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $el.data('token')
		}
	});

	$.ajax({
		url: $el.attr('href'),
		type: 'DELETE',  // user.destroy
		success: function (result) {
			new PNotify({
				title: "",
				text: result.message,
				addclass: 'bg-success'
			});
			
			$("tr[data-plan="+ $el.data('id') +"]").fadeOut(500);
		},
		error: function (resutl) {
			new PNotify({
				title: "",
				text: result.message,
				addclass: 'bg-danger'
			});
		}
	});
});                                 