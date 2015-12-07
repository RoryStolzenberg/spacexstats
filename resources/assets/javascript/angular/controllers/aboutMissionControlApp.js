(function() {
    var aboutMissionControlApp = angular.module('app', ['credit-cards']);

    aboutMissionControlApp.controller("subscriptionController", ["$scope", "subscriptionService", function($scope, subscriptionService) {
        $scope.subscriptionButtonText = "Pay $9";
        $scope.subscriptionState = {
            isLooking: true,
            isEnteringDetails: false,
            isSubscribing: false,
            hasSubscribed: false,
            failed: false
        };

        $scope.subscription = {
            showSubscribeForm: function() {
                $scope.subscriptionState.isLooking = false;
                $scope.subscriptionState.isEnteringDetails = true;
            },
            subscribe: function($event) {
                $scope.subscriptionState.isEnteringDetails =  $scope.subscriptionState.failed = false;
                $scope.subscriptionState.isSubscribing = true;
                $scope.subscriptionButtonText = "You're awesome";

                var form = $('form[name="subscribeForm"]');
                Stripe.card.createToken(form, $scope.subscription.stripeResponseHandler);
            },
            stripeResponseHandler: function(stripeStatus, stripeResponse) {

                if (stripeResponse.error) {
                    $scope.subscriptionState.isSubscribing = false;
                    $scope.subscriptionState.isEnteringDetails = $scope.subscriptionState.failed = true;
                } else {
                    // Fetch the token from Stripe's response.
                    var token = stripeResponse.id;

                    // Subscribe
                    subscriptionService.subscribe(token).then(function() {
                        // Success!
                        $scope.subscriptionState.isSubscribing = false;
                        $scope.subscriptionState.hasSubscribed = true;
                    });
                }

                $scope.$apply();
            }
        };
    }]);

    aboutMissionControlApp.controller('aboutController', ["$scope", function($scope) {

    }]);

    aboutMissionControlApp.service("subscriptionService", ["$http", function($http) {
        this.subscribe = function(token) {
            return $http.post('/missioncontrol/payments/subscribe', { creditCardToken: token });
        };
    }]);

    aboutMissionControlApp.service("aboutMissionControlService", ["$http", function($http) {
    }]);
})();
