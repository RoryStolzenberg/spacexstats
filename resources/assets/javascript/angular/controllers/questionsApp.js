(function() {
    var questionsApp = angular.module('app', []);

    questionsApp.controller("questionsController", ["$scope", "questionService", function($scope, questionService) {

        $scope.clearPinnedQuestion = function() {
            history.replaceState('', document.title, window.location.pathname);
            $scope.pinnedQuestion = null;
        };

        $scope.pinQuestion = function(question) {
            history.replaceState('', document.title, '#' + question.slug);
            $scope.pinnedQuestion = question;
        };

        (function() {
            questionService.get().then(function(questions) {
                $scope.questions = questions;

                // Set the pinned question if one is present
                if (window.location.hash) {
                    $scope.pinnedQuestion = $scope.questions.filter(function(q) {
                        return window.location.hash.substring(1) == q.slug;
                    })[0];
                } else {
                    $scope.pinnedQuestion = null;
                }

            });
        })();
    }]);

    questionsApp.service("questionService", ["$http", "Question", function($http, Question) {
        this.get = function() {
            return $http.get('/faq/get').then(function(response) {
                return response.data.map(function(question) {
                    return new Question(question);
                });
            });
        };
    }]);

    questionsApp.factory("Question", function() {
        return function(question) {
            var self = question;

            self.slug = question.question.toLowerCase()
                .replace(/[^\w ]+/g,'')
                .replace(/ +/g,'-');

            return self;
        };
    });

})();