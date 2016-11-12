'use strict';
var TGC = angular.module('tgc');
TGC.service('PlayerDlg', function($q, $mdDialog, ErrorSrvc, CommandSrvc, PlayerSrvc) {
	
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
			};
			$scope.slapTitle = function(data) {
				switch (data.type) {
				case 'fighter': return "Fight";
				case 'ninja': return "Attack";
				case 'priest': return "Potion";
				case 'wizard': return "Spell";
				}
			};
			$scope.slapMessage = function(data) {
				return sprintf('%s %s %s with %s %s', data.attacker, data.adverb, data.verb, data.defender, data.adjective, data.noun);
			}
			$scope.fight = function() {
				CommandSrvc.fight(player).then(function(result) {
					console.log(result);
					$scope.closeDialog();
					if (result.data && result.startsWith('ERR')) {
						ErrorSrvc.showUserError(result);
					}
					else {
						var data = JSON.parse(result);
						ErrorSrvc.showMessage($scope.slapMessage(data), $scope.slapTitle(data));
					}
				});
			};
			$scope.attack = function() {
				CommandSrvc.attack(player).then(function(result) {
					$scope.closeDialog();
					if (result.data && result.data.startsWith('ERR')) {
						ErrorSrvc.showUserError(result.data);
					}
					else {
						ErrorSrvc.showMessage($scope.slapMessage(result), $scope.slapTitle(result));
					}
				});
			};
			$scope.brew = function() {
			};
			$scope.cast = function() {
			};
			
		}
		var parentEl = angular.element(document.body);
		$mdDialog.show({
//			parent: document.getElementById('TGCMAP'),
			targetEvent: $event,
			templateUrl: '/tpl/tamagochi/js/tpl/player_dialog.html',
			locals: {
				player: player
			},
			controller: DialogController
		});
	};
});
