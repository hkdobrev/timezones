'use strict';

/* Controllers */

angular.module('timezones.controllers', [])
  .controller('LoginCtrl', [
    '$scope',
    '$auth',
    '$rootScope',
    function($scope, $auth, $rootScope) {
      $scope.submit = function() {
        $auth.login({
          username: $scope.username,
          password: $scope.password,
          scope: 'timezones'
        });
      };
    }
  ])
  .controller('MainCtrl', [
    '$scope',
    '$auth',
    function($scope, $auth) {
      $scope.logout = function() {
        $auth.logout();
      };
    }
  ])
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
