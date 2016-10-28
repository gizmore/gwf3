'use strict';
window.TGC = window.TGC || {};

window.TGC.Message = function(gwf) {

	that.ERROR = 0;
	that.MESSAGE = 1;

	this.decode = function(gwf) {
		this.type = gwf.nibbleUntil(':') == '0' ? that.ERROR : that.MESAGE;
		this.length = gwf.nibbleUntil(':');
		this.text = gwf;
	};

	this.decode(gwf);
	
	this.htmlClass = function() {
		return this.type == this.ERROR ? 'tgc-error' : 'tgc-message';
	};
	
	this.toHTML = function() {
		return sprintf('<div class="%s">', this.htmlClass(), this.text);
	};
	
	
};
