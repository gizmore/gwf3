'use strict';
var TGC = angular.module('tgc');
TGC.service('RequestSrvc', function($http) {
	
	var RequestSrvc = this;
	
	RequestSrvc.send = function(method, data) {
		return $http({
			method: 'POST',
			url: method,
			data: data,
			withCredentials: true,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			transformRequest: function(obj) {
				var str = [];
				for(var p in obj) 
					str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
				return str.join("&");
			},
		});
	};
	
	RequestSrvc.login = function(username, password) {
		return RequestSrvc.send('/index.php?mo=Login&me=Form&ajax=1', {username: username, password: password, login: 1})
	};
	
	RequestSrvc.register = function(username, password) {
		return RequestSrvc.send('register', {username: username, password: password, register: 1, ajax: 1})
	};

});
