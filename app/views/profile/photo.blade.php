@extends ('layouts.master')
@include('pictures.single')

@section('body')
	@if($user_data)
		<a 
			href="#" 
			class="follow"
			data-user="{{$user_data->id}}"
			data-followed="{{ $user_data->hasFollowed($user_data->id) ? 'true' : 'false' }}">
			Follow {{$user_data->username}}
		</a>
	@endif

	@yield('picture_single')
@stop