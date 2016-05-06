<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ULab • Ideas Meeting Point</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="/fonts/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/css/app.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
</head>

<body class="@yield('body-class')">

@include('admin.common.navbar')

<!-- Page container -->
<div class="page-container">
	@yield('content')
</div>
<!-- /page container -->

<!-- Core JS files -->
<script type="text/javascript" src="/js/all.js"></script>
<script type="text/javascript" src="/js/pages.js"></script>
<script type="text/javascript" src="/js/admin.js"></script>
<!-- /core JS files -->
@if(session('success'))
	<script>
		$(function () {
			new PNotify({
				title : "",
				text: "{{session('success')}}",
				addclass: 'bg-success'
			});
		});
	</script>
@endif

</body>
</html>
