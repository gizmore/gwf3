'use strict';
var TGC = angular.module('tgc');
TGC.controller('MapCtrl', function($rootScope, $scope, NgMap, MapUtil) {

	$scope.googleMapsUrl = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBrEK28--B1PaUlvpHXB-4MzQlUjNPBez0";

	$scope.data = {
		position: null
	};
	
	$scope.reset = function() {
		$scope.data.position = null;
	};
	
	
	
	$scope.positionChanged = function($event, position) {
		console.log('MapCtrl.positionChanged()', position);
		$scope.data.position = position;
		NgMap.getMap('TGCMAP').then(function(map) {
			console.log(map);
			console.log(map.getCenter());
			map.setCenter(MapUtil.positionToLatLng(position));
		});
	};
	$scope.$on('tgc-position-changed', $scope.positionChanged);

});

