@extends ('layouts.master')

@section('body')
	@if(isset($errors))
		{{ var_dump($errors) }}
	@endif
	{{ Form::open(['url' => 'register', 'method' => 'post']) }}
		<div class="row">
			<div class="large-8 large-centered columns">
				{{ Form::label('first_name', 'First Name') }}
				{{ Form::text('first_name', '') }}
			</div>
			<div class="large-8 large-centered columns">
				{{ Form::label('last_name', 'Last Name') }}
				{{ Form::text('last_name', '') }}
			</div>
			<div class="large-8 large-centered columns">
				{{ Form::label('email', 'Email Address') }}
				{{ Form::text('email', '') }}
			</div>
			<div class="large-8 large-centered columns">
				{{ Form::label('password', 'Password') }}
				{{ Form::password('password') }}
			</div>
			<div class="large-8 large-centered columns">
				{{ Form::submit('Sign in', array('class' => 'button')) }}
			</div>
		</div>
	{{ Form::close() }} 
	<a href="{{ $fb_login_uri or '#' }}" class="button">Register With Facebook</a>
	<a href="{{ $instagram_login_uri or '#' }}" class="button">Register With Instagram</a>
@stop