@extends ('layouts.master')

@section('body')
	<div class="row">
		You're not connected with {{ $provider }}.
		<a href="{{$provider->connect_link}}" class="button">Connect Now</a>
	</div>
@stop