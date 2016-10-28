'use strict';
var TGC = angular.module('tgc');
TGC.controller('DashboardCtrl', function($scope, AvatarSrvc, PlayerSrvc) {
	$scope.reset = function() {
	};
	
	$scope.setPlayer = function(player) {
		console.log('DashboardCtrl.setPlayer', player);
		if (player) {
			$scope.reallySetPlayer(player);
			return true;
		} else {
			return false;
		}
	};

	$scope.reallySetPlayer = function(player) {
		console.log('DashboardCtrl.reallySetPlayer', player);
		$scope.data = {
				setColor: player.color() == 'black',
				setGender: player.gender() == 'none',
				createAvatar: AvatarSrvc.canCreateAvatar(),
				setMode: AvatarSrvc.hasAvatar(),
				setSkill: AvatarSrvc.hasAvatar(),
				setElement: AvatarSrvc.hasAvatar(),
			};
		
	};

	$scope.reset();
});
