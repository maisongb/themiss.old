@extends ('layouts.master')

@section('body')
	@if(isset($errors) && !empty($errors))
		{{ $errors->first('login') }}
	@endif
	{{ Form::open(['route' => array('dashboard.upload.save', $profile->username), 'method' => 'post']) }}
		<div class="row">
			<div class="large-8 large-centered columns">
				{{ Form::label('picture', 'Picture') }}
				{{ Form::file('picture', Input::old('picture')) }}
			</div>
			<div class="large-8 large-centered columns">
				{{ Form::submit('Upload File', array('class' => 'button')) }}
			</div>
		</div>
	{{ Form::close() }}
@stop