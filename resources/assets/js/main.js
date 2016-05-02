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
		cancelButtonText: "Mejor no lo borres"
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
				error: function (result) {
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
Dropzone.autoDiscover = false;
// File limitations
var options = {
	paramName: "file", // The name that will be used to transfer the file
	dictDefaultMessage: 'Arrastra aqui tus archivos <br/> <strong>o haz click aqui</strong>',
	maxFilesize: 4, // MB
	maxFiles: 4,
	url: "/admin/files",
	maxThumbnailFilesize: 1,
	addRemoveLinks: true,
	sending: function (file, xhr, formData) {
		// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
		formData.append("_token", $('[name=_token]').val()); // Laravel expect the token post value to be named _token by default
	},
};
var dropzone = new Dropzone("#dropzone", options);
dropzone.disable();


$('#image-modal').on('show.bs.modal', function () {
	var selectedImages = [];
	dropzone.enable();

	$("#image-modal").find(".content .row").empty();
	$.ajax({
		url: '/admin/files',
		type: 'GET',  // user.destroy
		success: function (result) {
			$.each(result.files, function (key, value) {
				var $element = $(
					'<div class="col-lg-2 col-sm-6">' +
					'<div class="thumbnail">' +
					'<div class="thumb">' +
					'<img src="/' + value.pathname + '" alt="">' +
					'<div class="caption-overflow">' +
					'<span>' +
					'<a href="#" data-id="'+ value.id + '" data-path="'+ value.pathname + '" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5">' +
					'<i class="icon-check"></i>' +
					'</a>' +
					'</span>' +
					'</div>' +
					'</div>' +
					// '<div class="caption">'+
					// 	'<p class="no-margin text-semibold">Image name</p>'+
					// '</div>'+
					'</div>' +
					'</div>');
				$("#image-modal").find(".content .row").append($element);
			})

			$("#image-modal").find('#add-images').on('click', function (e) {
				e.preventDefault();
				$.each(selectedImages, function (key, value) {
					var $element = $(
						'<div class="col-lg-2 col-sm-6">' +
						'<div class="thumbnail">' +
						'<div class="thumb">' +
						'<img src="/' + value.pathname + '" alt="">' +
						'<div class="caption-overflow">' +
						'<span>' +
						'<a href="#" data-id="' + value.id + '" class="btn btn-cross border-white text-white btn-flat btn-icon btn-rounded ml-5">' +
						'<i class="icon-cross2"></i>' +
						'</a>' +
						'</span>' +
						'</div>' +
						'</div>' +
						'<input type="hidden" name="images[]" value="'+ value.id +'"/>'+
						// '<div class="caption">'+
						// 	'<p class="no-margin text-semibold">Image name</p>'+
						// '</div>'+
						'</div>' +
						'</div>');
					$("#images-to-add").append($element);
				})
				$("#image-modal").modal('hide');
			});

			$("#image-modal").find('a.btn').on('click', function (e) {
				e.preventDefault();
				var data = {
					'id' : $(this).data('id'),
					'pathname' : $(this).data('path')
				};
				var exists = selectedImages.indexOf(data);
				if (exists == -1) {
					selectedImages.push(data)
					$(this).addClass('border-success');
					$(this).removeClass('border-white');
					$(this).find('.icon-check').addClass('text-success');
					$(this).parent().parent().css({
						'opacity': .5,
						'visibility': 'visible',
						'background': "#333"
					})
				}
				else {
					selectedImages.splice(exists, 1);
					$(this).removeClass('border-success');
					$(this).addClass('border-white');
					$(this).find('.icon-check').removeClass('text-success');
					$(this).parent().parent().css({
						'opacity': 0,
						'visibility': 'hidden',
						'background': "transparent"
					})
				}

			})
		},
		error: function (result) {
			console.log(result)
		}
	})
})
$('#image-modal').on('hidden.bs.modal', function () {
	$("#image-modal").find('#add-images').off('click');
	$('.btn-cross').off('click');
	$('.btn-cross').on('click', function (e) {
		e.preventDefault();
		$(this).parent().parent().parent().parent().parent().remove()
	});
	dropzone.disable();
})

$('.btn-cross').on('click', function (e) {
	e.preventDefault();
	$(this).parent().parent().parent().parent().parent().remove()
});