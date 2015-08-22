angular.module('flashMessageService', [])
    .service('flashMessage', function() {
        this.add = function(data) {
            $('#flash-message-container').append('<p class="flash-message ' + data.type + '">' + data.contents + '</p>');
            setTimeout(function() {
                $('.flash-message').slideUp(500, function() {
                   $(this).remove();
                });
            }, 3000);
        };
    });
