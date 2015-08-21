angular.module('FlashMessageService', [])
    .service('FlashMessage', function() {
        this.add = function(message) {
            $('#flash-message-container').append('<p class="flash-message">' + message + '</p>');
            setTimeout(function() {
                $('.flash-message').hide('blind', {}, 500);
            }, 5000);
        };
    });
