/**
 * 
 */
var TGC = angular.module('tgc', ['ngMaterial', 'ui.router']);

TGC.config(function($urlRouterProvider, $stateProvider) {
	
	$stateProvider.state({
		name: 'home',
		url: '/home',
		controller: 'HomeCtrl',
		templateUrl: '/tpl/tamagochi/js/tpl/home.html',
		pageTitle: 'Loading'
	});
	
	$stateProvider.state({
		name: 'login',
		url: '/login',
		controller: 'LoginCtrl',
		templateUrl: '/tpl/tamagochi/js/tpl/login.html',
		pageTitle: 'Authenticate'
	});
	
	$stateProvider.state({
		name: 'connect',
		url: '/connect',
		controller: 'ConnectCtrl',
		templateUrl: '/tpl/tamagochi/js/tpl/connect.html',
		pageTitle: 'Connecting'
	});
	
	$stateProvider.state({
		name: 'game',
		url: '/game',
		controller: 'TGCCtrl',
		templateUrl: '/tpl/tamagochi/js/tpl/game.html',
		pageTitle: 'Tamagochi',
	});
	
	$urlRouterProvider.otherwise('/home');
});


TGC.run(function($state, PositionSrvc, PingSrvc) {
//	$state.go('home').then(function(){
		PositionSrvc.bootstrap().then(PingSrvc.ping);
//	});
});
