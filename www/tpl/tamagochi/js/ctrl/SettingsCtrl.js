'use strict';
var TGC = angular.module('tgc');
TGC.controller('SettingsCtrl', function($scope) {
	
	$scope.data = {
		player: null
	};
	
	$scope.setPlayer = function(player) {
		console.log('PlayerCtrl.setPlayer()', player);
		$scope.data.player = player;
		$scope.$apply();
	};
	
	$scope.$on('tgc-own-player-loaded', function($event, player) {
		$scope.setPlayer(player);
	});
	
});
