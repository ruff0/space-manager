$('.invoice-archive').DataTable({
	autoWidth: false,
	columnDefs: [
		{
			width: '30px',
			targets: 0
		},
		{
			visible: false,
			targets: 1
		},
		{
			orderable: false,
			width: '100px',
			targets: 6
		},
		{
			width: '15%',
			targets: 4
		},
		{
			width: '15%',
			targets: 5
		},
		{
			width: '15%',
			targets: 3
		}
	],
	order: [[0, 'desc']],
	dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
	language: {
		search: '<span>Filtro:</span> _INPUT_',
		lengthMenu: '<span>Mostrar:</span> _MENU_',
		paginate: {'first': 'Primera', 'last': 'Ultima', 'next': '&rarr;', 'previous': '&larr;'}
	},
	lengthMenu: [25, 50, 75, 100],
	displayLength: 25,
	drawCallback: function (settings) {
		var api = this.api();
		var rows = api.rows({page: 'current'}).nodes();
		var last = null;

		api.column(1, {page: 'current'}).data().each(function (group, i) {
			if (last !== group) {
				$(rows).eq(i).before(
					'<tr class="active border-double"><td colspan="8" class="text-semibold">' + group + '</td></tr>'
				);

				last = group;
			}
		});
	}
});

// Add placeholder to the datatable filter option
$('.dataTables_filter input[type=search]').attr('placeholder', 'Escribe para filtrar...');

// Enable Select2 select for the length option
$('.dataTables_length select').select2({
	minimumResultsForSearch: Infinity,
	width: 'auto'
});
