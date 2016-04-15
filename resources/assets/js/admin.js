
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

	swal({
		title: "¿Estas seguro?",
		text: "¡Este elemento no será recuperable si lo borras!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#FF7043",
		confirmButtonText: "Si, borralo. ¡me da ígual!",
		cancelButtonText:"Mejor no lo borres"
	}).then(function (isConfirm) {
		if (isConfirm) {
			swal.enableLoading();
			$.ajax({
				url: $el.attr('href'),
				type: 'DELETE',  // user.destroy
				success: function (result) {
					new PNotify({
						title: "",
						text: result.message,
						addclass: 'bg-success'
					});

					$("tr[data-plan=" + $el.data('id') + "]").fadeOut(500);
				},
				error: function (resutl) {
					new PNotify({
						title: "",
						text: result.message,
						addclass: 'bg-danger'
					});
				}
			});
		}
	})
});


$('.select').select2({
	containerCssClass: 'select-lg'
});