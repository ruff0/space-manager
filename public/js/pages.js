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
$('.bookables-list').DataTable({
	autoWidth: true,
	columnDefs: [
		{
			type: "natural",
			width: '100px',
			targets: 0
		},
		{
			width: '20%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			width: '15%',
			targets: [4, 5]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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
	$(el).find(".form").show()
})

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
$('.meetingrooms-list').DataTable({
	autoWidth: true,
	columnDefs: [
		{
			type: "natural",
			width: '100px',
			targets: 0
		},
		{
			width: '20%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			width: '15%',
			targets: [4, 5]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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
$('.offices-list').DataTable({
	autoWidth: true,
	columnDefs: [
		{
			type: "natural",
			width: '100px',
			targets: 0
		},
		{
			width: '20%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			width: '15%',
			targets: [4, 5]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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
$('.classrooms-list').DataTable({
	autoWidth: true,
	columnDefs: [
		{
			type: "natural",
			width: '100px',
			targets: 0
		},
		{
			width: '20%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			width: '15%',
			targets: [4, 5]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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
$('.spots-list').DataTable({
	autoWidth: true,
	columnDefs: [
		{
			type: "natural",
			width: '100px',
			targets: 0
		},
		{
			width: '20%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			width: '15%',
			targets: [4, 5]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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
$('.bookabletypes-list').DataTable({
	autoWidth: true,
	columnDefs: [
		{
			type: "natural",
			width: '100px',
			targets: 0
		},
		{
			width: '20%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			width: '15%',
			targets: [4, 5]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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
$('.plantypes-list').DataTable({
	autoWidth: true,
	columnDefs: [
		{
			type: "natural",
			width: '100px',
			targets: 0
		},
		{
			width: '20%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			width: '15%',
			targets: [4, 5]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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
$('.members-list').DataTable({
	autoWidth: false,
	columnDefs: [
		{
			type: "natural",
			width: '100px',
			targets: 0
		},
		{
			width: '20%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			orderable: false,
			width: '100px',
			targets: 7
		},
		{
			width: '15%',
			targets: [4, 5, 6]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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


$('#plan_id').change(function(e){
	var el = document.getElementById("save-plan-change")
	var select = e.currentTarget

	value = select.options[select.selectedIndex].value;
	if(value != select.dataset.value)
	{
		el.style.setProperty("display", 'inline-block', 'important');
	}
	else
	{
		el.style.removeProperty("display");
	}

});

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
$('.plans-list').DataTable({
	autoWidth: false,
	columnDefs: [
		{
			type: "natural",
			width: '20px',
			targets: 0
		},
		{
			width: '10%',
			targets: 1
		},
		{
			width: '25%',
			targets: 2
		},
		{
			width: '10%',
			targets: 3
		},
		{
			width: '10%',
			targets: 4
		},
		{
			orderDataType: 'dom-text',
			type: 'string',
			targets: 5
		},
		{
			orderable: false,
			width: '100px',
			targets: 7
		},
		{
			width: '15%',
			targets: [4, 5, 6]
		}
	],
	order: [[0, 'asc']],
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

		// Grouod rows
		// api.column(1, {page:'current'}).data().each(function (group, i) {
		//     if (last !== group) {
		//         $(rows).eq(i).before(
		//             '<tr class="active border-double"><td colspan="8" class="text-semibold">'+group+'</td></tr>'
		//         );
		//
		//         last = group;
		//     }
		// });

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
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
	},
	preDrawCallback: function (settings) {

		// Reverse last 3 dropdowns orientation
		$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');

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
	}, function (isConfirm) {
		if (isConfirm) {
			// swal.enableLoading();
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
//# sourceMappingURL=pages.js.map
