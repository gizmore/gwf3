window.XMGFX = {};
window.XMGFX.ready = document.ready;
window.XMGFX.elements = {};

/**
 * Init.
 */
window.XMGFX.init = function(){

};

window.XMGFX.addElement = function(id) {
	if (window.XMGFX.elements[id]) {
		return window.XMGFX.elements[id];
	}
	var xmgfxe = XMGFXE(id);
	if (xmgfxe) {
		window.XMGFX.elements[id] = xmf;
	}
	return xmgfxe;
};

window.XMGFX.getElement = function(id) {
	if (window.XMGFX.elements[id]) {
		return window.XMGFX.elements[id];
	}
	return undefined;
};

window.XMGFX.removeElement = function(id) {
	if (window.XMGFX.elements[id]) {
		var element = window.XMGFX.elements[id];
		delete window.XMGFX.elements[id];
		return element;
	}
	return undefined;
};



window.XMGFX.onNewRow = function(row) {
//	console.log("New row: "+row);
	window.XMGFX.execNewRow(row);
};
window.XMGFX.onNewTrigger = function(row, col, note) {
	if (note) {
		note = String.fromCharCode(note);
		window.XMGFX.execNewTrigger(row, col, note);
	}
		
//	console.log("New trigger: "+row+" "+col+" "+note);
};
window.XMGFX.onNewRelease = function(row, col) {
//	console.log("New Release: "+row+" "+col);
	window.XMGFX.execNewRelease(row, col);
};

window.XMGFX.onNewValue = function(row, col, value) {
//	console.log("New Value: "+row+" "+col+" "+value);
	if (value) {
		window.XMGFX.execNewValue(row, col, value);
	}
};

window.XMGFX.execNewRow = function(row) {};
window.XMGFX.execNewTrigger = function(row, col, note) {};
window.XMGFX.execNewRelease = function(row, col) {};
window.XMGFX.execNewValue = function(row, col, value) {};

// Kickstart
document.ready = function() {
	if (window.XMGFX.ready) {
		window.XMGFX.ready();
	}
	window.XMGFX.init();
};