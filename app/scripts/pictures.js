App.Pictures = {
	init: function () {
		this.$button = jQuery('#load_more');
		this.$container = jQuery('#pictures');

		this.handle_events();
	},

	handle_events: function () {
		this.$button.on('click', jQuery.proxy(this.load, this));
	},

	load: function (e, data) {
		e.preventDefault();

		var total = this.$button.data('total'),
			from = this.$button.data('from'),
			req = jQuery.ajax({
				url: '/latest/'+total+'/'+from,
				type: 'GET',
				dataType: 'json',
				cache: false
			});
		
		req.done(function (pictures) {
			console.log('test');
			if(pictures.length <= 0) return;

			//insert the images in the container
			this.$container.append(pictures);
			//change the count of the image to get
			this.$button.data('from', from*2);
		});
	}
};

App.Pictures.init();