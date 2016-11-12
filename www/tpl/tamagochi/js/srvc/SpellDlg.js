'use strict';
var TGC = angular.module('tgc');
TGC.service('SpellDlg', function($q, $mdDialog, ErrorSrvc, CommandSrvc, PlayerSrvc) {
	
	var SpellDlg = this;
	
	SpellDlg.open = function(player) {
		console.log('SpellDlg.open()', player);
		var defer = $q.defer();
		SpellDlg.show(player, defer);
		return defer.promise;
	};

	SpellDlg.show = function(player, defer) {
		function DialogController($scope, $mdDialog, player) {
			$scope.player = player;
			$scope.closeDialog = function() {
				$mdDialog.hide();
				defer.resolve();
			};
			$scope.afterCast = function(result) {
				ErrorSrvc.showMessage($scope.slapMessage(result), $scope.slapTitle(result));
				$scope.closeDialog();
			};
			$scope.brew = function() {
				CommandSrvc.brew(player, spelltxt).then($scope.afterCast);
			};
			$scope.cast = function() {
				CommandSrvc.cast(player, spelltxt).then($scope.afterCast);
			};
			
		}
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			parent: document.getElementById('TGCMAP'),
			targetEvent: $event,
			templateUrl: '/tpl/tamagochi/js/tpl/player_dialog.html',
			locals: {
				player: player
			},
			controller: DialogController
		});
	};
});
