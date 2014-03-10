@extends ('layouts.master')

@section('body')
	<div class="row" id="pictures">
		@include('pictures.list')
	</div>

	<a 
		href="#" 
		class="button" 
		id="load_more"
		data-from="5"
		data-total="5">
		Load More
	</a>
@stop