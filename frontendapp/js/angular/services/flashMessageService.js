(function() {
    var app = angular.module('app', []);

    app.service('flashMessage', function() {
        this.add = function(data) {

            $('<p style="display:none;" class="flash-message ' + data.type + '">' + data.contents + '</p>').appendTo('#flash-message-container').slideDown(300);

            setTimeout(function() {
                $('.flash-message').slideUp(300, function() {
                    $(this).remove();
                });
            }, 3000);
        };
    });
})();

