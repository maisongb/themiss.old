@extends ('layouts.master')

@section('body')
	@if($user_data)
		<a 
			href="#" 
			class="follow"
			data-user="{{$profile->user->id}}"
			data-followed="{{ $user_data->hasFollowed($profile->user->id) ? 'true' : 'false' }}">
			Follow {{$profile->user->username}}
		</a>
	@endif
	
	<div class="row">
		@include('pictures.list')
	</div>
@stop