@section('pictures_list')
	<div class="row">
		@foreach($pictures as $picture)
			<div class="picture-container">
				<figure class="picture">
					<img src="{{$picture->url}}" alt="{{$picture->user->last_name}}">
				</figure>

				<div class="actions">
					<a 
						href="#" 
						class="vote"
						data-picture="{{ $picture->id }}">
						Like
					</a>
				</div>
			</div>
		@endforeach
	</div>
@stop