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
config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode(true);
}]).
config(['$authProvider', function($authProvider) {
  $authProvider.tokenName = 'access_token';
  $authProvider.signupRedirect = '/';
}]);
