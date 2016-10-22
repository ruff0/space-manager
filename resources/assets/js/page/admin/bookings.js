/* ------------------------------------------------------------------------------
 *
 *  # Task list view
 *
 *  Specific JS code additions for task_manager_list.html page
 *
 *  Version: 1.0
 *  Latest update: Aug 1, 2015
 *
 * ---------------------------------------------------------------------------- */


// Create an array with the values of all the input boxes in a column
$.fn.dataTable.ext.order['dom-text'] = function (settings, col) {
	return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
		return $('input', td).val();
	});
}

// Create an array with the values of all the select options in a column
$.fn.dataTable.ext.order['dom-select'] = function (settings, col) {
	return this.api().column(col, {order: 'index'}).nodes().map(function (td, i) {
		return $('select', td).val();
	});
}

// Table setup
// ------------------------------
// Initialize data table
$('.bookings-list').DataTable({
	autoWidth: true,
	columnDefs: [
		{
			type: "natural",
			width: '5%',
			targets: 0
		},
		{
			visible: false,
			targets: 1
		},
		{
			width: '20%',
			targets: 2
		},
		{
			width: '20%',
			targets: 3
		},
		{
			width: '15%',
			targets: [4, 5]
		}
	],
	order: [[1, 'desc']],
	dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
	language: {
		search: '<span>Filtro:</span> _INPUT_',
		lengthMenu: '<span>Mostrar:</span> _MENU_',
		paginate: {'first': 'Primera', 'last': 'Ultima', 'next': '&rarr;', 'previous': '&larr;'}
	},
	lengthMenu: [15, 25, 50, 75, 100],
	displayLength: 25,
	drawCallback: function (settings) {
		var api = this.api();
		var rows = api.rows({page: 'current'}).nodes();
		var last = null;

		//Grouod rows
		api.column(1, {page:'current'}).data().each(function (group, i) {
		    if (last !== group) {
		        $(rows).eq(i).before(
		            '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		        )
		        last = group;
		    }
		});

		// Datepicker
		$(".datepicker").datepicker({
			showOtherMonths: true,
			dateFormat: "d MM, y"
		});

		// Select2
		$('.select').select2({
			width: '150px',
			minimumResultsForSearch: Infinity
		});

		// Reverse last 3 dropdowns orientation
		// $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		// $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

		// Destroy Select2
		$('.select').select2().select2('destroy');
	}
});


// External table additions
// ------------------------------

// Add placeholder to the datatable filter option
$('.dataTables_filter input[type=search]').attr('placeholder', 'Escribe para filtrar...');


// Enable Select2 select for the length option
$('.dataTables_length select').select2({
	minimumResultsForSearch: Infinity,
	width: 'auto'
});


var availableContainers = $("[data-list='available-resources']").toArray();
var selectedContainers = $("[data-list='selected-resources']").toArray();

// Draggable for resources
var drake = dragula(selectedContainers.concat(availableContainers), {
	mirrorContainer: document.querySelector('.resources-list-container'),
	moves: function (el, container, handle) {
		return handle.classList.contains('dragula-handle');
	},
	accepts: function (el, target, source, sibling) {
		return true;
	}
});

drake.on('drag', function (el, source)
{
	$(".resources-list-container").addClass('bg-slate-300').addClass('active')
}).on('dragend', function(el)
{
	$(".resources-list-container").removeClass('bg-slate-300').removeClass('active')
}).on('drop', function(el, target, source, sibling)
{
	if( $(target).data("list") == "selected-resources")
	{
		$(el).find(".form").removeClass('hidden')
	}

})