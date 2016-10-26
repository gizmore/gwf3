var TGC = angular.module('tgc', ['ngMaterial', 'ui.router']);

TGC.config(function($urlRouterProvider, $stateProvider) {
	$stateProvider.state({
		name: 'home',
		url: '/home',
		templateURL: '/tpl/tamagochi/js/tpl/home.html',
	});
	$stateProvider.state({
		name: 'login',
		url: '/login',
		controller: 'LoginCtrl',
		templateUrl: '/tpl/tamagochi/js/tpl/login.html',
	});
	$stateProvider.state({
		name: 'game',
		url: '/game',
		templateURL: '/tpl/tamagochi/js/tpl/game.html',
		parent: null,
	});
	$urlRouterProvider.otherwise('/home');
});

TGC.run(function(PingSrvc, $state) {
	PingSrvc.ping();
});



