'use strict';
var TGC = angular.module('tgc');
TGC.controller('TGCCtrl', function($rootScope, $scope, $state, $mdSidenav, PlayerSrvc, ConstSrvc, WebsocketSrvc, CommandSrvc, PositionSrvc) {
	
	$scope.data = {
		lastReceived: null,
		lastStamp: null,
		version: ''
	};
	
	$scope.reset = function() {
		
	};

	$scope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams) {
		console.log('TGCCtrl.$on-stateChangeSuccess', toState);
		if (toState.name === 'game') {
			if (fromState.name === 'connect') {
				CommandSrvc.pos($scope, PositionSrvc.CURRENT);
			}
			else {
				$state.go('home');
			}
		}
		else if (toState.name === 'connect') {
			console.log(fromState);
		}
		else if (toState.name === 'game') {
			if (fromState !== 'connect') {
				$state.go('home');
			}
		}
		else if (toState.name === 'login') {
			if (fromState !== 'home') {
				$state.go('home');
			}
		}
	});

	$scope.toggleLeftMenu = function() {
		$mdSidenav('left').toggle();
	};

	$scope.toggleRightMenu = function() {
		$mdSidenav('right').toggle();
	};
	
	
	$scope.logout = function() {
		
	};
	

	$scope.$on('tgc-ws-message', function($event, message) {
//		console.log('TGCCtrl.$on-tgc-ws-message', message.data);
		var messageText = message.data;
		if ($scope.data.lastReceived != messageText) {
			$scope.data.lastReceived = messageText;
			$scope.processMessage(messageText);
		}
	});
	
	$scope.processMessage = function(messageText) {
		console.log('TGCCtrl.processMessage()', messageText);
		var command = messageText.substrUntil(':');
		if (CommandSrvc[command])
		{
			CommandSrvc[command]($scope, messageText.substrFrom(':'));
			$scope.$apply();
		}
	};

});
