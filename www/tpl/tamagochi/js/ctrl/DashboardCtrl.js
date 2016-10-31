'use strict';
var TGC = angular.module('tgc');
TGC.controller('DashboardCtrl', function($rootScope, $scope, AvatarSrvc, PlayerSrvc) {
	$scope.reset = function() {
		$scope.data = {
				setColor: false,
				setGender: false,
				createAvatar: false,
				setMode: false,
				setSkill: false,
				setElement: false,
		};
	};

	$scope.setPlayer = function(player) {
		console.log('DashboardCtrl.setPlayer()', player);
		$scope.data = {
				setColor: player.color() == 'black',
				setGender: player.gender() == 'none',
				createAvatar: AvatarSrvc.canCreateAvatar(),
				setMode: AvatarSrvc.hasAvatar(),
				setSkill: AvatarSrvc.hasAvatar(),
				setElement: AvatarSrvc.hasAvatar(),
		};
		
	};

	
	$rootScope.$on('tgc-own-player-loaded', function($event, player) {
		$scope.setPlayer(player);
	});
	
	$scope.reset();
});
