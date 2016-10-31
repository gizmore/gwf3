'use strict';
var TGC = angular.module('tgc');
TGC.controller('MapCtrl', function($rootScope, $scope, NgMap) {

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
		NgMap.getMap().then(function(map) {
			console.log(map.getCenter());
			console.log('markers', map.markers);
			console.log('shapes', map.shapes);
		});
	};

	$scope.$on('tgc-position-changed', $scope.positionChanged);

});

