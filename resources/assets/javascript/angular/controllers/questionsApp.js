(function() {
    var questionsApp = angular.module('app', []);

    questionsApp.controller("questionsController", ["$scope", "questionService", function($scope, questionService) {

        $scope.pinnedQuestion = null;

        $scope.clearPinnedQuestion = function() {

        };

        $scope.pinQuestion = function(question) {

        };

        (function() {
            questionService.get().then(function(questions) {
                $scope.questions = questions;
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