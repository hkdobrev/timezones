'use strict';

angular.module('timezones.controllers')
  .controller('TimezonesCtrl', [
    '$scope',
    'Timezone',
    function($scope, Timezone) {
      $scope.a = 'd';
      var timezones = Timezone.query(function() {
        console.log(timezones);
      });
    }
  ]);
