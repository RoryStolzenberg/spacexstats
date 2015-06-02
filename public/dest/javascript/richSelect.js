(function($) {
	$.fn.richSelect = function() {
		return this.each(function() {

			var self = $(this);

			var dropdownList;

			// init
			(function() {
				var defaultElem = self.find('li.default');
				// Declare the props
				var defaultProps = {
					id: defaultElem.attr('value'),
					img: defaultElem.find('img').attr('src'),
					title: defaultElem.find('span.title').text(),
					summary: defaultElem.find('span.summary').text()
				}
				dropdownList = self.children('ul');

				self.find('.default img').attr('src',defaultProps.img);
				self.find('.default .title').text(defaultProps.title);
				self.find('.default .summary').text(defaultProps.summary);

				dropdownList.hide();
			}());

			self.children('div.default').on('click', function() {
				dropdownList.slideToggle();
			});

			self.find('li').on('click', function() {
				var newProps = {
					img: $(this).find('img').attr('src'),
					title: $(this).find('span.title').text(),
					summary: $(this).find('span.summary').text()
				}

				self.find('div.default img').attr('src',newProps.img);
				self.find('div.default .title').text(newProps.title);
				self.find('div.default .summary').text(newProps.summary);
				self.data('value', $(this).data('value'));
				dropdownList.slideUp();
			});
		});
	}
}(jQuery));