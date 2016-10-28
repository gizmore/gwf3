'use strict';
var TGC = angular.module('tgc');
TGC.controller('NewAvatarCtrl', function($scope, $state, RequestSrvc, PingSrvc, ConstSrvc) {
	
	$scope.data = {
	};

	$scope.reset = function() {
	};
	
	
	$scope.create = function() {
		console.log('NewAvatarCtrl.create()');
	};

});