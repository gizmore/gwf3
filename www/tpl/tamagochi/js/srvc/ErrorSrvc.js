'use strict';
var TGC = angular.module('tgc');
TGC.service('ErrorSrvc', function($q, $mdDialog) {
	
	var ErrorSrvc = this;
	
	ErrorSrvc.showError = function(text, title) {
		console.log(title, text);
		return $mdDialog.show(
					$mdDialog.alert()
//					.parent(angular.element(document.querySelector('#popupContainer')))
					.clickOutsideToClose(false)
					.title(title)
					.textContent(text)
					.ariaLabel(title)
					.ok("Aww")
					);
	};
	
	ErrorSrvc.showGWFMessage = function(message) {
		console.log(title, text);
		console.error(text);
		if (message.success()) {
		}
		else {
		}
	};
	
	ErrorSrvc.showNetworkError = function(error) {
		return ErrorSrvc.showError(error, 'Netz doof');
	};

	ErrorSrvc.showServerError = function(error) {
		return ErrorSrvc.showError(error, 'Server doof')
	};

	window.onerror = function(message, filename, lineno, colno, error) {
		console.log(message);
	};

});
