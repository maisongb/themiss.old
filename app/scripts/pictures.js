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

		var total = parseInt(this.$button.data('total')),
			from = parseInt(this.$button.data('from'));

		if(total > 0 && from > 0){
			var req = jQuery.ajax({
					url: '/latest/'+total+'/'+from,
					type: 'GET',
					dataType: 'html'
				});
			
			//if we get a response from the server
			req.done(jQuery.proxy(this.recieved, this));

			//if something went wrong on the server
			req.fail(function (data) {
				console.log(data);
			});
		}
	},

	recieved: function ($pictures) {
		if($pictures.length <= 0){
			this.$button.remove();
			return;
		}

		//insert the images in the container
		this.$container.append($pictures);
		//change the count of the image to get
		this.$button.data('from', parseInt(this.$button.data('from'))*2);
	}
};

App.Pictures.init();