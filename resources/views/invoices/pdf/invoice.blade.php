<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ULab • Ideas Meeting Point</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<!-- Global stylesheets -->
	<link href="{{ url('/css/pdf.css') }}" rel="stylesheet" type="text/css">
	<style>
		body, html {
			background-color: #ffffff;
		}
	</style>
	<!-- /global stylesheets -->
</head>

<body class="@yield('body-class')">
<!-- Page container -->
<div class="page-container">
	<div class="container">
		<div class="content">
			@include('invoices.invoice')
		</div>
	</div>
</div>
<!-- /page container -->
</body>
</html>
