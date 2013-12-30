@extends ('layouts.master')

@section('body')
	<div class="row">
		@if(isset($messages) && !empty($messages))
			{{ var_dump($messages) }}
		@endif
	</div>
@stop