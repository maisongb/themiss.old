<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>{{ $meta['title'] or 'The Miss' }}</title>

	<meta property="og:title" content="{{ $meta['title'] or 'The Miss' }}"/>
	<meta property="og:site_name" content="The Miss"/>
	<meta property="og:image" content="{{ $meta['image'] or URL::to('/public') }}"/>
	
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
	

	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=736433713035947";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	
	{{ HTML::script('js/plugins.min.js') }}
	{{ HTML::script('js/main.min.js') }}
</body>
</html>