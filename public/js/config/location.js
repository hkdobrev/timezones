'use strict';


angular.module('timezones')
  .config(['$locationProvider', function($locationProvider) {
    $locationProvider.html5Mode(true);
  }]);
