@extends ('layouts.master')

@section('body')
	<div class="row">
		@foreach($photos as $photo)
			<div class="small-2 large-4 columns">
				<figure>
					<a href="upload/photo/{{ $photo['id'] }}" class="th">
						<img 
						src="{{ $photo['picture'] }}" 
						alt="{{ '' }}">
					</a>
					<figcaption>{{ '' }}</figcaption>
				</figure>
			</div>
		@endforeach
	</div>
@stop