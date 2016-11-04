'use strict';
var TGC = angular.module('tgc');
TGC.controller('ConnectCtrl', function($rootScope, $scope, PingSrvc, ConstSrvc, ErrorSrvc, CommandSrvc, WebsocketSrvc) {

	$rootScope.$on('tgc-own-player-loaded', function(event, player) {
		if (ConstSrvc.inLogin()) {
			console.log('ConnectCtrl.$on-tgc-own-player-loaded', player);
			ConstSrvc.inLogin(false);
			$scope.connect();
		}
	});
	
	$scope.connect = function() {
		console.log('ConnectCtrl.connect()');
		WebsocketSrvc.connect().then($scope.connected, $scope.connectFailure);
	};
	
	$scope.connectFailure = function(event) {
		console.log('ConnectCtrl.connectFailure()', event);
		ErrorSrvc.showError('Connection could not be established.', 'Connection').then($scope.reconnect);
	};

	$scope.reconnect = function() {
		console.log('ConnectCtrl.reconnect()');
		PingSrvc.ping();
	};

	$scope.connected = function() {
		console.log('ConnectCtrl.connected()');
		CommandSrvc.ping($scope, '1.0.0').then($scope.pingSent);
	};


	$scope.pingSent = function() {
		console.log('ConnectCtrl.pingSent()');
	};
	
});
