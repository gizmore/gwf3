var TGC = angular.module('tgc', ['ngMaterial', 'ui.router', 'ngMap']);

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
		name: 'game',
		url: '/game',
		controller: 'TGCCtrl',
		templateUrl: '/tpl/tamagochi/js/tpl/game.html',
		pageTitle: 'Tamagochi',
	});
	$urlRouterProvider.otherwise('/home');
});

TGC.run(function(PingSrvc, $state) {
	PingSrvc.ping();
});
