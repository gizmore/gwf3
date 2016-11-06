'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerDlg', function($q, PlayerSrvc) {
	
	var PlayerDlg = this;
	
	PlayerDlg.open = function(player) {
		var d = $q.defer();
		if (PlayerDlg.player) {
			d.reject();
		}
		else {
			PlayerSrvc.withStats(player).then(function(player) {
				PlayerDlg.show(player, defer);
			});
			d.resolve();
		}
		return d.promise;
	};

	PlayerDlg.show = function(defer) {
		function DialogController($scope, $mdDialog, player) {
			$scope.player = player;
			$scope.closeDialog = function() {
				$mdDialog.hide();
				defer.resolve();
			}
		}
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			parent: parentEl,
			targetEvent: $event,
			templateUrl: '/tpl/tamagochi/js/tpl/player_dialog.html',
			locals: {
				player: $scope.items
			},
			controller: DialogController
		});
	};
});
