'use strict';


// Declare app level module which depends on filters, and services
angular.module('timezones', [
  'ngRoute',
  'timezones.filters',
  'timezones.services',
  'timezones.directives',
  'timezones.controllers',
  'Satellizer'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/', {templateUrl: 'templates/login.html', controller: 'LoginCtrl'});
  $routeProvider.otherwise({redirectTo: '/'});
}]).
config(['$authProvider', function($authProvider) {
  $authProvider.tokenName = 'access_token';
}]);
