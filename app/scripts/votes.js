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