'use strict';
var TGC = angular.module('tgc');
TGC.controller('LoginCtrl', function($scope, RequestSrvc) {
	
	$scope.data = {
		username: '',
		password: '',
	};

	$scope.reset = function() {
		$scope.data.username = '';
		$scope.data.password = '';
	};
	
	$scope.login = function() {
		$scope.reset();
	};

});