App = typeof App == 'undefined' ? {} : App;
App.Events = jQuery({});

jQuery(function($){
	var $selector_form = $('.social-picture-selector');

	$selector_form.on('click', '.picture', function (e) {
		e.preventDefault();

		var input = jQuery('<input />', {
				'name': 'picture[]',
				'value': $(this).attr('src'),
				'type': 'hidden'
			});

		$selector_form.append(input);
	});
});