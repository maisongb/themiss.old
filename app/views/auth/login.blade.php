@extends ('layouts.master')

@section('body')
	@if(isset($errors) && !empty($errors))
		{{ $errors->first('login') }}
	@endif
	{{ Form::open(['url' => 'login', 'method' => 'post']) }}
		<div class="row">
			<div class="large-8 large-centered columns">
				{{ Form::label('email', 'Email Address') }}
				{{ Form::text('email', Input::old('email')) }}
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
	<a href="{{ $fb_login_uri or '#' }}" class="button">Login With Facebook</a>
	<a href="{{ $instagram_login_uri or '#' }}" class="button">Login With Instagram</a>
@stop