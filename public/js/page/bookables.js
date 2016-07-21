$el = $("#bookings-wizzard")

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $el.data('token')
	}
});

var data = {
	date: null,
	time_from:null,
	time_to:null
};
var bookables = {};

$el.steps({
	headerTag: "h6",
	bodyTag: "fieldset",
	transitionEffect: "fade",
	titleTemplate: '<span class="number">#index#</span> #title#',
	labels: {
		previous: 'Anterior',
		next: 'Siguiente',
		finish: 'Rerervar & Pagar'
	},
	onStepChanging: function (event, currentIndex, newIndex) {
		// Allways allow previous action even if the current form is not valid!
		if (currentIndex > newIndex) {
			$('.secure-payment').remove();
			return true;
		}

		if (newIndex === 1) {
			$(".bookables").addClass('blocked');
			if($('input[name=bookable-type]:checked').length <= 0)
			{
				$(".errors").empty().html("<li>Debes de seleccionar una opción</li>").fadeIn(500)
				return false;
			}
			$(".errors").empty().hide()


			data.type = $('input[name=bookable-type]:checked').val();

			// Remove the inputs we don't
			$('[data-notVisible]').show();
			var toRemove = $('input[name=bookable-type]:checked').data('bookabletypenotvisible');
			var itemsToRemove = $('[data-notVisible="' + toRemove + '"]');


			if(itemsToRemove.length > 0 ){
				itemsToRemove.hide();
			}
			$('.bookables').hide();
			$('.bookables[data-bookableType=' + data.type + ']').show()

			// Disable certain dates
			$('.pickadate-date').pickadate({
				min: true,
				disable: [
					[2015, 8, 3],
					[2015, 8, 12],
					[2015, 8, 20]
				],

				// Escape any “rule” characters with an exclamation mark (!).
				format: 'dddd, dd mmm, yyyy',
				formatSubmit: 'yyyymmdd',
				hiddenPrefix: 'date',
				hiddenSuffix: ''
			});
			// Disabling ranges
			$('.pickatime-from').pickatime({
				interval: 60,
				min: [8, 0],
				max: [21, 0],
				// Escape any “rule” characters with an exclamation mark (!).
				format: 'HH:i ',
				formatLabel: 'HH:i',
				formatSubmit: 'HHi',
				hiddenPrefix: 'time-',
				hiddenSuffix: 'from'
			});

			$('.pickatime-to').pickatime({
				interval: 60,
				min: [8, 0],
				max: [21, 0],
				// Escape any “rule” characters with an exclamation mark (!).
				format: 'HH:i',
				formatLabel: 'HH:i',
				formatSubmit: 'HHi',
				hiddenPrefix: 'time',
				hiddenSuffix: '-to'
			});

			$('input[type="text"]').on('change', function (e){

				if (itemsToRemove.length == 0) {
					data.time_from = null;
					data.time_to = null;
				}
				data.date = $("[name=datedate]").val()
				data.time_from = $("[name=time-from]").val()
				data.time_to = $("[name=time-to]").val()

				if (itemsToRemove.length > 0) {
					data.time_from = '0800';
					data.time_to = '2100';
				}
				if (data.date != "" && data.time_from != "" && data.time_to != "")
				{
					$.ajax({
						data: data,
						url: '/api/bookings',
						type: 'GET',
						dataType: 'json',
						success: function (result) {
							$(".bookables").removeClass('blocked');

							$.each(result.notavailable, function (key, bookable) {
								$('[data-bookable=' + bookable.id + ']').addClass('notavailable');
								$('[data-bookable=' + bookable.id + ']').removeClass('selected')
								$('[data-bookable=' + bookable.id + '] input[type=radio]').prop('checked', false);
							})

							$.each(result.available, function (key, bookable) {
								var totalPrice = bookable.discount.percentage > 0 ? bookable.discount.price : bookable.totalPrice;
								var message = bookable.message;
								if (bookable.discount.percentage > 0)
									message += "<br>" + bookable.discount.message;
								if(bookable.raw_price > 0)
								{
									$('[data-bookable=' + bookable.id + ']').removeClass('notavailable');
									$('[data-bookable=' + bookable.id + ']').find('.times').html(bookable.times)
									$('[data-bookable=' + bookable.id + ']').find('.total-price').html(totalPrice)
									$('[data-bookable=' + bookable.id + ']').find('.message').html(message)
								}
								else
								{
									$('[data-bookable=' + bookable.id + ']').addClass('notavailable');
								}
							})
						},
						error: function (result) {
							// console.log(result);
						},
					});
				}
			});

			return true;
		}

		if (newIndex === 2) {
			if ($('input[name=bookable]:checked').length <= 0) {
				$(".errors").empty().html("<li>Debes de seleccionar una opción</li>").fadeIn(500)
				return false;
			}
			$(".errors").empty().hide()
			data.bookable = $('input[name=bookable]:checked').val();

			$(".actions.clearfix").prepend(
				'<div class="pull-left no-padding secure-payment">'+
					'<img src="/images/secure_payment.png" class="img-responsive" alt="Secure payment">'+
				'</div>'
			);
			var $return = false;

			$.ajax({
				url: '/api/bookings/calculate',
				data: data,
				dataType: 'json',
				type: 'POST',  // user.destroy
				success: function (result) {
					$("#vat_percentage").empty().html(result.vatPercentage + "%");
					$("#vat").empty().html(result.vatFormated);
					$("#total").empty().html(result.totalFormated);
					$("#subtotal").empty().html(result.subtotalFormated);
					$("#pre_bill tbody").empty();

					$.each(result.lines, function (key, value) {
						$image = "<img src='" + value.name + "'/>";

						$line = $("<tr>" +
							"<td class='concept'>" +
							"<span>" + value.name + "</span><br/>" +
							"<span class='text-muted'>" + value.description + "</span>" +
							" </td> " +
							"<td class='image'></td> " +
							"<td class='price'>" + value.priceFormated + "</td> " +
							"<td class='qty'>" + value.amount + "</td> " +
							"<td class='line_total'>" + value.totalFormated + "</td> " +
							"</tr>");

						$("#pre_bill tbody").append($line);
					});
				},
				error: function (result) {
					console.log(result);
				}
			});

			return true;
		}

		// Needed in some cases if the user went back (clean up)
		if (currentIndex < newIndex) {
			// // To remove error styles
			// form.find(".body:eq(" + newIndex + ") label.error").remove();
			// form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
		}
	},
	onFinished: function (event, currentIndex) {
		$.ajax({
			url: '/api/bookings',
			data: data,
			dataType: 'json',
			type: 'POST',  // user.destroy
			success: function (response) {
				var text = response;
				var messages = '';

				$.each(text.success.messages, function (index, value) {
					messages += "<li>" + value + "</li>";
				});

				if (text.success.messages.length > 0) {
					$(".errors").empty().html("").hide();
					$(".success").empty().html(messages).fadeIn(500);
				}

			},
			error: function (response) {
				if (response.status == 422) {
					var text = JSON.parse(response.responseText);
					var errors = '';

					$.each(text.error.messages, function (index, value) {
						errors += "<li>" + value + "</li>";
					});

					if (text.error.messages.length > 0) {
						$('#needsPaymentMethod').modal({
							show: true
						});
						$(".errors").empty().html(errors).fadeIn(500);
					}
				}
			}
		});
	}
});

$("#needsPaymentMethod form").on('submit', function (e) {
	e.preventDefault();
	$.ajax({
		url: $(this).attr('action'),
		data: $(this).serialize(),
		dataType: 'json',
		type: 'POST',  // user.destroy
		success: function (response) {
			$('#needsPaymentMethod').modal('hide');
			$(".errors").empty().html("").hide();
		},
		error: function (response) {
			if (response.status == 422) {
				var text = JSON.parse(response.responseText);
				var errors = '';

				$.each(text.error.messages, function (index, value) {
					errors += "<li>" + value + "</li>";
				});

				if (text.error.messages.length > 0) {
					$('#needsPaymentMethod').modal({
						show: true
					});
					$(".errors").empty().html(errors).fadeIn(500);
				}
			}
		}
	});
});


// Select2 selects
$('.select').select2();


// Simple select without search
$('.select-simple').select2({
	minimumResultsForSearch: Infinity
});

// Styled checkboxes and radios
// $('.styled').uniform({
// 	radioClass: 'choice'
// });


// Styled file input
$('.file-styled').uniform({
	fileButtonClass: 'action btn bg-blue'
});

$("label.thumb-label").off('click').on('click', function(e){
	$el = $(e.currentTarget);
	$el.parents('fieldset').find(".thumbnail").addClass('not-selected');
	$el.parents('fieldset').find(".thumb-label").addClass('bg-info-400').removeClass('bg-success-400');

	$el.parents('fieldset').find('.thumbnail').removeClass('selected')
	$el.parents('.thumbnail').removeClass('not-selected').addClass('selected')
	$('.selected .thumb-label').addClass('bg-success-400').removeClass('bg-info-400')
})

