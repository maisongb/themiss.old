@extends ('layouts.master')
@include('pictures.single')

@section('body')
	@if($user_data)
		<a 
			href="#" 
			class="follow"
			data-user="{{$profile->user->id}}"
			data-followed="{{ $user_data->hasFollowed($profile->user->id) ? 'true' : 'false' }}">
			Follow {{$user_data->user->username}}
		</a>
	@endif

	@yield('picture_single')

	@if($voters)
		@foreach($voters as $voter)
			{{var_dump($voter->username)}}
		@endforeach
	@endif
@stop