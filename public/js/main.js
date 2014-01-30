App = typeof App == 'undefined' ? {} : App;
App.Events = jQuery({});

jQuery(function($){
	var $selector_form = $('.social-picture-selector');

	$selector_form.on('click', '.picture', function (e) {
		e.preventDefault();

		jQuery('input[name="picture"]').val($(this).attr('src'));
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