var editUserViewModel = function(username) {
	var self = this;
	self.username = username;

	self.updateProfile = function(formData) {
		$.ajax('/users/'+self.username+'/edit', 
			{
				dataType: 'json',
				type: 'POST',
				data: formData,
				success: function(response) {
					console.log(response);
				}
			}
		);
	}

	self.updateDetails = function(formElement) {
		self.updateProfile({ 
			summary: $(formElement).find('#summary').val(),
			twitter_account: $(formElement).find('#twitter_account').val(),
			reddit_account: $(formElement).find('#reddit_account').val(),
		});
	}

	self.updateFavorites = function(formElement) {
		self.updateProfile({ 
			favorite_mission: $(formElement).find('#favorite_mission').attr('value'),
			favorite_quote: $(formElement).find('#favorite_quote').val(),
		});
	}
}