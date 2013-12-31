@extends ('layouts.master')

@section('body')
	<div class="row">
		{{ var_dump($profile) }}

		<a href="{{ URL::to('/register/facebook') }}" class="button">
			Confirm
		</a>
	</div>
@stop