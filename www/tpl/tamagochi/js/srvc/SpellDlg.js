'use strict';
var TGC = angular.module('tgc');
TGC.service('SpellDlg', function($q, $mdDialog, ErrorSrvc, CommandSrvc, PlayerSrvc) {
	
	var SpellDlg = this;
	
	SpellDlg.open = function($event, player) {
		console.log('SpellDlg.open()', player);
		var defer = $q.defer();
		PlayerSrvc.withStats(player).then(function(player) {
			SpellDlg.show(player, defer, $event);
		});
		return defer.promise;
	};

	PlayerDlg.show = function(player, defer, $event) {
		function DialogController($scope, $mdDialog, player) {
			$scope.player = player;
			$scope.closeDialog = function() {
				$mdDialog.hide();
				defer.resolve();
			};
			$scope.fight = function() {
				CommandSrvc.fight(player).then(function(result) {
					ErrorSrvc.showMessage($scope.slapMessage(result), $scope.slapTitle(result));
				});
				$scope.closeDialog();
			};
			$scope.attack = function() {
				CommandSrvc.attack(player).then(function(result) {
					ErrorSrvc.showMessage($scope.slapMessage(result), $scope.slapTitle(result));
				});
				$scope.closeDialog();
			};
			$scope.brew = function() {
				$scope.closeDialog();
			};
			$scope.cast = function() {
				$scope.closeDialog();
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
