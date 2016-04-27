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
		<!-- Page container -->
		<div class="page-container">
			@yield('content')
		</div>
		<!-- /page container -->

		@include ('utils.scripts')

		<!-- Core JS files -->
		<script type="text/javascript" src="/js/all.js"></script>
		@yield('vendor-scripts')
		<script type="text/javascript" src="/js/app.js"></script>
		<!-- /core JS files -->

		@yield('page-scripts')
	</body>
</html>
