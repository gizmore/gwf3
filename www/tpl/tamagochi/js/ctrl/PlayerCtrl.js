'use strict';
var TGC = angular.module('tgc');
TGC.controller('PlayerCtrl', function($rootScope, $scope, PlayerSrvc, MapUtil) {
	
	$scope.data = {
			player: null
	};
	
	$scope.setPlayer = function(player) {
		console.log('PlayerCtrl.setPlayer()', player);
		$scope.data.player = player;
	};
	
	$rootScope.$on('tgc-own-player-loaded', function($event, player) {
		$scope.setPlayer(player);
	});
	
});
