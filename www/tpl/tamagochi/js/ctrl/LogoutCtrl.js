'use strict';
var TGC = angular.module('tgc');
TGC.controller('LogoutCtrl', function($scope, PlayerSrvc) {
	
	$scope.logout = function() {
		console.log('LogoutCtrl.logout()');
		PlayerSrvc.logout().then($scope.loggedOut);
	};
	
	$scope.loggedOut = function() {
		console.log('LogoutCtrl.loggedOut()');
		window.location.href = '/welcome';
	};
	

});