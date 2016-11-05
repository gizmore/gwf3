'use strict';
var TGC = angular.module('tgc');
TGC.controller('MapCtrl', function($rootScope, $scope, MapUtil, CommandSrvc, PositionSrvc) {

	$scope.data = {
		position: null,
		map: MapUtil.map('TGCMAP')
	};
	
	$scope.reset = function() {
		$scope.data.position = null;
	};
	
	$scope.positionChanged = function($event, position) {
		console.log('MapCtrl.positionChanged()', position);
		$scope.data.position = position;
		var map = MapUtil.map('TGCMAP');
		map.setCenter(MapUtil.positionToLatLng(position));
		CommandSrvc.pos($rootScope, PositionSrvc.CURRENT);
	};
	$scope.$on('tgc-position-changed', $scope.positionChanged);

});

