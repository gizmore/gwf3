'use strict';
var TGC = angular.module('tgc');
TGC.controller('DebugCtrl', function($rootScope, $scope, PlayerSrvc, PositionSrvc) {
	
	$scope.data = {
		fixPosition: false,
		fixLatitude: 52.141568,
		fixLongitude: 10.111213,
		lock: null
	};
	
	$rootScope.$on('tgc-position-changed', function($event, position) {
		if ($scope.data.fixPosition) {
			PositionSrvc.setLatLng($scope.data.fixLatitude, $scope.data.fixLongitude);
		}
	});

	$scope.changeDebugPosition = function($event) {
		if ($scope.data.fixPosition) {
			if ($scope.data.lock === null) {
				$scope.data.lock = setTimeout($scope.onChangeDebugPosition, 500);
			}
		}
		else {
			$scope.data.lock = null;
		}
	};
	
	$scope.onChangeDebugPosition = function() {
		console.log('DebugCtrl.onChangeDebugPosition()');
		$scope.data.lock = null;
	};
	
});
