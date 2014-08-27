'use strict';


// Declare app level module which depends on filters, and services
angular.module('timezones')
  .config([
    '$routeProvider',
    function($routeProvider) {
      $routeProvider.when('/', {templateUrl: 'templates/home.html'});
      $routeProvider.when('/signup', {templateUrl: 'templates/signup.html', controller: 'SignupCtrl'});
      $routeProvider.when('/create', {templateUrl: 'templates/timezone-form.html', controller: 'NewTimezoneCtrl'});
      $routeProvider.otherwise({redirectTo: '/'});
    }
  ]);
