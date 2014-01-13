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
App.Votes = {
	init: function () {
		var self = this;

		this.$button = jQuery('.vote');
		this.handleEvents();
	},

	handleEvents: function () {
		var self = this;
		console.log(self.$button);

		self.$button.on('click', jQuery.proxy(self.addVote, self));
	},

	addVote: function (e) {
		e.preventDefault();

		var $btn = jQuery(e.currentTarget),
			send_vote = this.sendVote({
				'picture_id': $btn.data('picture')
			});

		send_vote.done(function (data) {
			if(data.status == true){
				console.log(data.message);
			}else{
				console.log(data);
			}
		});
	},

	sendVote: function (data) {
		return jQuery.ajax({
			url: BASE + '/pictures/vote/add',
			type: 'POST',
			dataType: 'json',
			data: data
		});
	}
};

App.Votes.init();
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