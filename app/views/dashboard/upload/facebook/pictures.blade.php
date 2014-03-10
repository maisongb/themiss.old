@extends ('layouts.master')

@section('body')
	<div class="row">
		{{ Form::open(['route' => ['dashboard.upload.save', $user_data->username], 'method' => 'post', 'class' => 'social-picture-selector']) }}
		@foreach($photos as $photo)
			<div class="small-2 large-4 columns">
				<figure>
					<a href="upload/photo/{{ $photo['id'] }}" class="th">
						<img 
						src="{{ $photo['source'] }}" 
						alt="{{ '' }}"
						class="picture">
					</a>
					<figcaption>{{ '' }}</figcaption>
				</figure>
			</div>
		@endforeach

		{{ Form::hidden('provider', 'facebook') }}
		{{ Form::hidden('picture') }}
		<div class="large-8 large-centered columns">
			{{ Form::submit('Upload File', array('class' => 'button')) }}
		</div>
		{{ Form::close() }}
	</div>
@stop