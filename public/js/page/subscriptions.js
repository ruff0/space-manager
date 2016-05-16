$el = $("#subscriptions-wizzard")
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $el.data('token')
	}
});

var data = {};
var plans = {};

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

		// Always allow previous action even if the current form is not valid!
		if (currentIndex > newIndex) {
			return true;
		}

		// Forbid next action on "Warning" step if the user is to young
		if (newIndex === 1) {

			if($('input[name=plan-type]:checked').length <= 0)
			{
				$(".errors").empty().html("<li>Debes de seleccionar una opción</li>").fadeIn(500)
				return false;
			}
			$(".errors").empty().hide()
			data.type = $('input[name=plan-type]:checked').val();

			$('.plans').hide();
			$('.plans[data-type=' + data.type + ']').show()

			return true;
		}

		if (newIndex === 2) {

			if ($('input[name=date_from]:checked').length <= 0) {
				$(".errors").empty().html("<li>Debes de seleccionar desde cuando quieres empezar a contratar</li>").fadeIn(500)
				return false;
			}

			var date_from = moment().format('YYYYMMDD');
			if ($('input[name=date_from]:checked').val() == 'next-month') {
				date_from = moment().endOf('month').format('YYYYMMDD');
			}

			data.date_from = date_from;

			$.ajax({
				data: data,
				url: '/api/subscriptions',
				type: 'GET',
				dataType: 'json',
				success: function (result) {
					$(".plans").removeClass('blocked');

					$.each(result.notavailable, function (key, plan) {
						$('[data-plan=' + plan.id + ']').addClass('notavailable');
						$('[data-plan=' + plan.id + ']').removeClass('selected')
						$('[data-plan=' + plan.id + '] input[type=radio]').prop('checked', false);
					})

					$.each(result.available, function (key, plan) {
						$('[data-plan=' + plan.id + ']').removeClass('notavailable');
					})
				},
				error: function (result) {
					// console.log(result);
				},
			});


			return true;
		}


		if (newIndex === 3) {

			$(".errors").empty().hide()

			if($('input[name=plan]:checked').length <= 0)
			{
				$(".errors").empty().html("<li>Debes de seleccionar un plan</li>").fadeIn(500)
				return false;
			}

			data.plan = $('input[name=plan]:checked').val();

			$('.rooms').hide();
			$(".rooms").addClass('blocked').addClass('notavailable');

			$('.rooms[data-plan=' + data.plan + ']').show()

			$.ajax({
				url: '/api/subscriptions/rooms',
				data: data,
				dataType: 'json',
				type: 'POST',  // user.destroy
				success: function (result) {
					$(".rooms").removeClass('blocked');
					$.each(result.notavailable, function (key, room) {
						$('[data-room=' + room.id + '][data-plan=' + data.plan + ']').addClass('notavailable');
						$('[data-room=' + room.id + '][data-plan=' + data.plan + ']').removeClass('selected')
						$('[data-room=' + room.id + '][data-plan=' + data.plan + '] input[type=radio]').prop('checked', false);
					})
					$.each(result.available, function (key, room) {
						$('[data-room=' + room.id + '][data-plan=' + data.plan + ']').removeClass('notavailable');
					})
				},
				error: function (result) {
					$(".rooms").addClass('blocked').addClass('notavailable');
				}
			});


			return true;
		}

		if (newIndex === 4) {
			$(".errors").empty().hide()

			if ($('input[name=room]:checked').length <= 0) {
				$(".errors").empty().html("<li>Debes de seleccionar el puesto o sala que quieres contratar</li>").fadeIn(500)
				return false;
			}

			data.room = $('input[name=room]:checked').val();

			$.ajax({
				url: '/api/subscriptions/calculate',
				data: data,
				dataType: 'json',
				type: 'POST',  // user.destroy
				success: function (result) {
					$("#vat_percentage").empty().html(result.vatPercentage);
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
					var errors = []
					$.each(result.error.messages, function(key, value){
						errors.push("<li>"+value+"</li>")
					});

					$(".errors").empty().html(errors.join("")).fadeIn(500)
				}
			});


			return true;
		}

		// Needed in some cases if the user went back (clean up)
		if (currentIndex < newIndex) {
			$(".errors").empty().html("").hide()
			$(".success").empty().html("").hide()
			// // To remove error styles
			// form.find(".body:eq(" + newIndex + ") label.error").remove();
			// form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
		}
	},
	onFinished: function (event, currentIndex) {
		$.ajax({
			url: '/api/subscriptions',
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

					$("form .actions").hide()
				}

			},
			error: function (response) {
				if (response.status == 422) {
					var text = JSON.parse(response.responseText);
					var errors = [];

					$.each(text.error.messages, function (index, value) {
						errors.push("<li>" + value + "</li>");
					});


					if (text.error.needsPaymentMethod) {
						$('#needsPaymentMethod').modal({
							show: true
						});
					}

					if (errors.length > 0) {
						$(".success").empty().html("").hide();
						$(".errors").empty().html(errors.join("")).fadeIn(500);
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
	$el.parents('fieldset').find('.thumbnail').removeClass('selected')
	$el.parents('.thumbnail').addClass('selected')
})

$("label[data-time]").off('click').on('click', function(e){
	$el = $(e.currentTarget);
	$("label[data-time]").removeClass('active')
	$("label[data-time]").removeClass('bg-success-400')
	$("label[data-time]").addClass('bg-info-400')
	$el.addClass('active')
	$el.addClass('bg-success-400')
	$el.removeClass('bg-info-400')
})

