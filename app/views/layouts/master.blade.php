<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>{{ $meta['title'] or 'The Miss' }}</title>
	
	{{ HTML::style('css/plugins.css') }}
	{{ HTML::style('css/main.css') }}

	{{ HTML::style('http://fonts.googleapis.com/css?family=Bitter:400,700,400italic') }}
	{{ HTML::style('http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css') }}

	<script type="text/javascript">
		var BASE = "{{ URL::to('/'); }}";
	</script>
	
	{{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js') }}
	{{ HTML::script('http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js') }}
</head>
<body>

	@include('layouts.top')

	@yield('body')

	@include('layouts.bottom')
	
	{{ HTML::script('js/plugins.min.js') }}
	{{ HTML::script('js/main.min.js') }}
</body>
</html>