@extends ('layouts.master')

@section('body')
	<div class="row">
		@foreach($albums as $album)
			<div class="small-2 large-4 columns">
				<figure>
					<a href="facebook/album/{{ $album['id'] }}" class="th">
						<img 
						src="https://graph.facebook.com/{{ $album['cover_photo'] }}/picture?access_token={{ $user_data->facebook_token }}" 
						alt="{{ $album['name'] }}">
					</a>
					<figcaption>{{ $album['name'] }}</figcaption>
				</figure>
			</div>
		@endforeach
	</div>
@stop