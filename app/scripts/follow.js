App.Follow = {
	init: function () {
		var self = this;

		this.button = jQuery('.follow');
		this.handleEvents();
	},

	handleEvents: function () {
		var self = this;

		self.button.on('click', function (e) {
			e.preventDefault();

			if($(this).data('followed') == 0){
				self.follow($(this));
			}else{
				self.unfollow($(this));
			}
		});
	},

	follow: function ($el) {
		var send_follow = this.sendFollow('follow', {
			'user_id' : $el.data('user')
		});

		send_follow.done(function (data) {
			if(data.status == true){
				console.log(data.message);
				$el.data('followed', '1');
			}else{
				console.log(data);
			}
		});
	},

	unfollow: function ($el) {
		var send_follow = this.sendFollow('unfollow', {
			'user_id' : $el.data('user')
		});

		send_follow.done(function (data) {
			if(data.status == true){
				console.log(data.message);
				$el.data('followed', '0');
			}else{
				console.log(data);
			}
		});
	},

	sendFollow: function (action, data) {
		var url = BASE + '/profile/' + action;

		return jQuery.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: data
		});
	}
};

App.Follow.init();