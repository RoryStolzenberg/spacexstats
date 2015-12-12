(function() {
    var app = angular.module('app', []);

    app.service('flashMessage', function() {
        this.addOK = function(message) {

            computeStayTime(message);

            $('<p style="display:none;" class="flash-message success">' + message + '</p>').appendTo('#flash-message-container').slideDown(300);

            setTimeout(function() {
                $('.flash-message').slideUp(300, function() {
                    $(this).remove();
                });
            }, computeStayTime());
        };

        this.addError = function(message) {

            computeStayTime(message);

            $('<p style="display:none;" class="flash-message failure">' + message + '</p>').appendTo('#flash-message-container').slideDown(300);

            setTimeout(function() {
                $('.flash-message').slideUp(300, function() {
                    $(this).remove();
                });
            }, computeStayTime());
        };

        var computeStayTime = function(message) {
            // Avg characters per word: 5.1
            // Avg reading speed of 200 wpm:
            //var totalChara
            return 3000;
        };
    });
})();

