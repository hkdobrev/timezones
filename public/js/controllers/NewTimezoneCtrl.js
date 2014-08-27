'use strict';

angular.module('timezones.controllers')
  .controller('NewTimezoneCtrl', [
    '$scope',
    'Timezone',
    '$location',
    function($scope, Timezone, $location) {
      $scope.submit = function () {
        Timezone.save($scope.timezone, function() {
          $location.url('/');
        });
      };
    }
  ]);
