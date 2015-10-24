(function() {
    var app = angular.module('app', []);

    app.service('flashMessage', function() {
        this.addOK = function(message) {

            $('<p style="display:none;" class="flash-message success">' + message + '</p>').appendTo('#flash-message-container').slideDown(300);

            setTimeout(function() {
                $('.flash-message').slideUp(300, function() {
                    $(this).remove();
                });
            }, 3000);
        };

        this.addError = function(message) {
            $('<p style="display:none;" class="flash-message failure">' + message + '</p>').appendTo('#flash-message-container').slideDown(300);

            setTimeout(function() {
                $('.flash-message').slideUp(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    });
})();

