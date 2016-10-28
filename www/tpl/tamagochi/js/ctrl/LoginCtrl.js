'use strict';
var TGC = angular.module('tgc');
TGC.controller('LoginCtrl', function($scope, $state, RequestSrvc, PingSrvc, ConstSrvc) {
	
	$scope.data = {
		username: '',
		password: '',
	};

	$scope.reset = function() {
		$scope.data.username = '';
		$scope.data.password = '';
	};
	
	
	$scope.login = function() {
		console.log('LoginCtrl.login()');
		RequestSrvc.login($scope.data.username, $scope.data.password).then($scope.loginSuccess, $scope.loginFailure)['finally']($scope.reset);
	};

	
	$scope.register = function() {
		RequestSrvc.register($scope.data.username, $scope.data.password).then($scope.registerSuccess, $scope.registerFailure)['finally']($scope.reset);
	};

	
	$scope.loginSuccess = function(data) {
		console.log('LoginCtrl.loginSuccess()', data);		
		setTimeout(PingSrvc.ping, 10);
	};

	
	$scope.loginFailure = function(data) {
		console.log('LoginCtrl.loginFailure()', data);
	};
	
	
	$scope.registerSuccess = function(data) {
		setTimeout(PingSrvc.ping, 10);
	};
	
	
	$scope.registerFailure = function(data) {
		
	};
	

});