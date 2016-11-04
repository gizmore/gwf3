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
		var command = messageText.substrUntil(':');
		if (CommandSrvc[command]) {
			CommandSrvc[command]($scope, messageText.substrFrom(':'));
			$scope.$apply();
		}
	};

});
