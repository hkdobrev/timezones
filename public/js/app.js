'use strict';


// Declare app level module which depends on filters, and services
angular.module('timezones', [
  'ngResource',
  'ngRoute',
  'timezones.controllers',
  'Satellizer'
]);

angular.module('timezones.controllers', ['timezones.resources']);
angular.module('timezones.resources', ['ngResource']);
