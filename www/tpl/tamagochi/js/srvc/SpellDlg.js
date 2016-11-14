'use strict';
var TGC = angular.module('tgc');
TGC.service('SpellDlg', function($q, $mdDialog, ErrorSrvc, CommandSrvc, PlayerSrvc) {
	
	var SpellDlg = this;
	
	SpellDlg.open = function(player, type) {
		return $q(function(resolve, reject){
			SpellDlg.show(player, type, resolve, reject);
		});
	};

	SpellDlg.show = function(player, type, resolve, reject) {
		function DialogController($scope, $mdDialog, player, type, resolve) {
			$scope.data = {
				player: player,
				type: type,
				runes: window.TGCConfig.runes,
				selected: [],
				selectedIDs: [],
			}
			$scope.closeDialog = function() {
				$mdDialog.hide();
//				resolve();
			};
			$scope.brew = function() {
				CommandSrvc.brew(player, $scope.spelltext()).then($scope.closeDialog);
			};
			$scope.cast = function() {
				CommandSrvc.cast(player, $scope.spelltext()).then($scope.closeDialog);
			};
			$scope.spelltext = function() {
				return $scope.data.selected.join(',');
			};
			$scope.spell = function($event, row, col) {
				var rune = window.TGCConfig.runes[row][col]
				$scope.data.selected = $scope.data.selected.slice(0, row);
				$scope.data.selected.push(rune);
				$scope.data.selectedIDs = $scope.data.selectedIDs.slice(0, row);
				$scope.data.selectedIDs.push(col);
			};
		}
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			templateUrl: '/tpl/tamagochi/js/tpl/spell_dlg.html',
			locals: {
				player: player,
				type: type,
				resolve: resolve,
			},
			controller: DialogController
		});
	};
});
