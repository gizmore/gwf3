var TGC = angular.module('tgc', ['ngMaterial', 'ui.router']);

TGC.config(function($urlRouterProvider, $stateProvider) {
	$stateProvider.state({
		name: 'home',
		url: '/home',
		templateUrl: '/tpl/tamagochi/js/tpl/home.html',
	});
	$stateProvider.state({
		name: 'login',
		url: '/login',
		templateUrl: '/tpl/tamagochi/js/tpl/login.html',
	});
	$stateProvider.state({
		name: 'game',
		url: '/game',
		templateUrl: '/tpl/tamagochi/js/tpl/game.html',
		parent: null,
	});
	$urlRouterProvider.otherwise('/home');
});

TGC.run(function(RequestSrvc, $state) {
	console.log("running");
	RequestSrvc.ping().then(function(data){
		if (!data.user) {
			$state.go("login");
		} 
		else {
			$state.go("game");
		}
		console.log(data);
	});
});



