@foreach($pictures as $picture)
	<div class="picture-container">
		<figure class="picture">
			<a href="{{route('pictures.single', array('username' => $picture->user->username, 'id' => $picture->id))}}">
				<img src="{{$picture->url}}" alt="{{$picture->user->last_name}}">
			</a>
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