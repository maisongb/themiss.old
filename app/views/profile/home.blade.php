@extends ('layouts.master')
@include('pictures.list')

@section('body')
	@if($user_data)
		<a 
			href="#" 
			class="follow"
			data-user="{{$profile->id}}"
			data-followed="{{ $user_data->hasFollowed($profile->id) ? 'true' : 'false' }}">
			Follow {{$profile->username}}
		</a>
	@endif

	@yield('pictures_list')
@stop