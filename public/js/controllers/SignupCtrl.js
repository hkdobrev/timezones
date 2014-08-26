'use strict';

angular.module('timezones.controllers')
  .controller('SignupCtrl', [
    '$scope',
    '$auth',
    function($scope, $auth) {
      $scope.signup = function() {
        $auth.signup({
          username: $scope.username,
          password: $scope.password,
        });
      };
    }
  ]);
