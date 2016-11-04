'use strict';
var TGC = angular.module('tgc');
TGC.controller('ChatSendCtrl', function($rootScope, $scope, CommandSrvc) {

	$scope.data = {
		input: '',
		history: []
	};
	
	$scope.reset = function() {
		$scope.clearInput();
		$scope.data.history.length = 0; // Works in all browsers according to http://stackoverflow.com/questions/1232040/how-do-i-empty-an-array-in-javascript
	};
	
	$scope.clearInput = function() {
		$scope.data.input = '';
	};
	
	$scope.sendMessage = function($event) {
		console.log('ChatSendCtrl.sendMessage()', $scope.data.input);
		CommandSrvc.chat($scope, $scope.data.input).then($scope.messageSent);
	};
	
	$scope.messageSent = function() {
		console.log('ChatSendCtrl.messageSent()');
		$scope.data.history.push($scope.data.input);
		$scope.clearInput();
	};


});
