'use strict';
var TGC = angular.module('tgc');
TGC.controller('LoginCtrl', function($scope, $state, RequestSrvc, PingSrvc) {
	
	$scope.data = {
		username: '',
		password: '',
	};

	$scope.reset = function() {
		$scope.data.username = '';
		$scope.data.password = '';
	};
	
	$scope.login = function() {
		RequestSrvc.login($scope.data.username, $scope.data.password).then($scope.loginSuccess).finally($scope.reset);
	};

	$scope.register = function() {
		RequestSrvc.register($scope.data.username, $scope.data.password).then($scope.loginSuccess).finally($scope.reset);
	};
	
	$scope.loginSuccess = function(data) {
		PingSrvc.ping();
	};
	
	

});