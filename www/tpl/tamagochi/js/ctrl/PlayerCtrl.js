'use strict';
var TGC = angular.module('tgc');
TGC.controller('PlayerCtrl', function($scope, PlayerSrvc) {
	
	$scope.data = {
			player: null
	};
	
	$scope.setPlayer = function(player) {
		console.log('PlayerCtrl.setPlayer()', player);
		$scope.data.player = player;
	};
	
	$scope.$on('tgc-own-player-loaded', function($event, player) {
		$scope.setPlayer(player);
	});
	
});
