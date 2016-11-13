'use strict';
var TGC = angular.module('tgc');
TGC.service('SpellDlg', function($q, $mdDialog, ErrorSrvc, CommandSrvc, PlayerSrvc) {
	
	var SpellDlg = this;
	
	SpellDlg.open = function(player, type) {
		console.log('SpellDlg.open()', player);
		var defer = $q.defer();
		SpellDlg.show(player, type, defer);
		return defer.promise;
	};

	SpellDlg.show = function(player, type, defer) {
		function DialogController($scope, $mdDialog, player, type) {
			$scope.data = {
				player: player,
				type: type,
				runes: [],
			}
			$scope.closeDialog = function() {
				$mdDialog.hide();
				defer.resolve();
			};
			$scope.castMessage = function(result) {
				return $scope.data.type;
			};
			$scope.castTitle = function(result) {
				return $scope.data.type;
			};
			$scope.afterCast = function(result) {
				ErrorSrvc.showMessage($scope.castMessage(result), $scope.castTitle(result));
				$scope.closeDialog();
			};
			$scope.brew = function() {
				CommandSrvc.brew(player, $scope.spelltext()).then($scope.afterCast);
			};
			$scope.cast = function() {
				CommandSrvc.cast(player, $scope.spelltext()).then($scope.afterCast);
			};
			$scope.spelltext = function() {
				return $scope.data.runes.join(',');
			};
			$scope.spell = function($event, row, rune) {
				var li = jQuery($event.srcElement);
				console.log('spell()', $event, li);
				$scope.data.runes = $scope.data.runes.slice(0, row);
				$scope.data.runes.push(rune);
			};
		}
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			templateUrl: '/tpl/tamagochi/js/tpl/spell_dlg.html',
			locals: {
				player: player,
				type: type
			},
			controller: DialogController
		});
	};
});
