'use strict';
var TGC = angular.module('tgc');
TGC.service('ErrorSrvc', function($mdDialog) {
	
	var ErrorSrvc = this;
	
	ErrorSrvc.showError = function(text, title) {
		console.log(title, text);
		console.error(text);
		$mdDialog.show(
				$mdDialog.alert()
//				.parent(angular.element(document.querySelector('#popupContainer')))
				.clickOutsideToClose(false)
				.title(title)
				.textContent(text)
				.ariaLabel(title)
				.ok("Aww")
//				.targetEvent(ev)
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
		ErrorSrvc.showError(error, 'Netz doof');
	};

	ErrorSrvc.showServerError = function(error) {
		ErrorSrvc.showError(error, 'Server doof')
	};
	

});
