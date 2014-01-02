@extends ('layouts.master')

@section('body')
	<div class="row">
		@foreach($pictures as $picture)
			<div class="small-2 large-4 columns">
				<figure>
					<a href="upload/picture/{{ $picture['id'] }}" class="th">
						<img 
						src="{{ $picture['images']['thumbnail']['url'] }}" 
						alt="{{ '' }}">
					</a>
					<figcaption>{{ '' }}</figcaption>
				</figure>
			</div>
		@endforeach
	</div>
@stop