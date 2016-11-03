'use strict';
var TGC = angular.module('tgc');
TGC.service('CommandSrvc', function($rootScope) {
	
	var CommandSrvc = this;
	
	CommandSrvc.PONG = function($scope, payload) {
		console.log('CommandSrvc.PONG()', payload);
		$scope.data.version = payload;
	};

});
