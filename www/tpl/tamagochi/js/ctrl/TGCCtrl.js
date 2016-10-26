'use strict';
var TGC = angular.module('tgc');
TGC.controller('TGCCtrl', function($scope, $mdSidenav, PlayerSrvc) {
	
	$scope.data = {
		
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

});
