'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerDlg', function($q, $mdDialog, PlayerSrvc) {
	
	var PlayerDlg = this;
	
	PlayerDlg.open = function($event, player) {
		console.log('PlayerDlg.open()', player);
		var defer = $q.defer();
		if (PlayerDlg.player) {
			defer.reject();
		}
		else {
			PlayerSrvc.withStats(player).then(function(player) {
				PlayerDlg.show(player, defer, $event);
			});
			defer.resolve();
		}
		return defer.promise;
	};

	PlayerDlg.show = function(player, defer, $event) {
		function DialogController($scope, $mdDialog, player) {
			$scope.player = player;
			$scope.closeDialog = function() {
				$mdDialog.hide();
				defer.resolve();
			}
		}
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			parent: document.getElementById(''),
			targetEvent: $event,
			templateUrl: '/tpl/tamagochi/js/tpl/player_dialog.html',
			locals: {
				player: player
			},
			controller: DialogController
		});
	};
});
