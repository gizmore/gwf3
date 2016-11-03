'use strict';
var TGC = angular.module('tgc');
TGC.controller('TGCCtrl', function($rootScope, $scope, $mdSidenav, PlayerSrvc, ConstSrvc, WebsocketSrvc, CommandSrvc) {
	
	$scope.data = {
		lastReceived: null,
		lastStamp: null,
		version: ''
	};
	
	$scope.reset = function() {
		
	};

	$scope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams){
//		if (angular.isDefined(toState.data.pageTitle)) {
//			$scope.pageTitle = toState.data.pageTitle + ' | Angualar Material' ;
//		}
	});

	$scope.toggleLeftMenu = function() {
		$mdSidenav('left').toggle();
	};

	$scope.toggleRightMenu = function() {
		$mdSidenav('right').toggle();
	};
	
	
	$scope.logout = function() {
		
	};
	
	$rootScope.$on('tgc-own-player-loaded', function(event, player) {
		if (ConstSrvc.inLogin()) {
			console.log('TGCCtrl$on-tgc-own-player-loaded', player);
			ConstSrvc.inLogin(false);
			WebsocketSrvc.connect().then($scope.connected);
		}
	});
	
	$scope.connected = function() {
		console.log('TGCCtrl.connected()');
		WebsocketSrvc.sendCommand('ping', '1.0.0');
	};

	$rootScope.$on('tgc-ws-message', function($event, message) {
//		console.log('TGCCtrl.$on-tgc-ws-message', message.data);
		var messageText = message.data;
		if ($scope.data.lastReceived != messageText) {
			$scope.data.lastReceived = messageText;
			$scope.processMessage(messageText);
		}
	});
	
	$scope.processMessage = function(messageText) {
		console.log('TGCCtrl.processMessage()', messageText);
		var command = messageText.nibbleUntil(':');
		if (CommandSrvc[command]) {
			CommandSrvc[command]($scope, messageText);
			$scope.$apply();
		}
	};

});
