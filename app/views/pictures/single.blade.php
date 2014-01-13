@section('picture_single')
	<div class="row">
		<div class="picture-container">
			<figure class="picture">
				<img src="{{ $picture->url }}" alt="{{ $picture->user->last_name }}">

			</figure>

			<div class="actions">
				<div 
					class="fb-like" 
					data-href="{{ route('pictures.single', ['username' => $picture->user->username, 'id' => $picture->id]) }}" 
					data-layout="button_count" 
					data-action="like" 
					data-show-faces="true" 
					data-share="false">
				</div>
				<a 
					href="#" 
					class="vote"
					data-picture="{{ $picture->id }}">
					Like
				</a>
			</div>
		</div>
	</div>
@stop