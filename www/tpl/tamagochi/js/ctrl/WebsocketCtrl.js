'use strict';
var TGC = angular.module('tgc');
TGC.controller('DebugCtrl', function($rootScope, $scope, PlayerSrvc, PositionSrvc) {
	
	$scope.data = {
		fixPosition: true,
		fixLatitude: 52.141568,
		fixLongitude: 10.111213
	};
	
	$scope.onFixCoordinates = function(position) {
		console.log('DebugCtrl.onFixCoordinates()', $scope.data, position);
		if ($scope.data.fixPosition) {
			PositionSrvc.setLatLng($scope.data.fixLatitude, $scope.data.fixLongitude);
		}
		else {
			$scope.data.fixLatitude = position.coords.latitude;
			$scope.data.fixLongitude = position.coords.longitude;
		}
	};

	
	$rootScope.$on('tgc-position-changed', function($event, position) {
		$scope.onFixCoordinates(position);
	});
	
	$scope.onChange = function($event) {
		console.log('DebugCtrl.onChange()');
	};
	
});
