@extends ('layouts.master')

@section('body')
	<div class="row">
		{{ var_dump($profile) }}

		<a href="{{ URL::to('/register/instagram') }}" class="button">
			Confirm
		</a>
	</div>
@stop