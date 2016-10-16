window.XMGFX = {};
window.XMGFX.ready = document.ready;
window.XMGFX.elements = {};

/**
 * Init.
 */
window.XMGFX.init = function(){
	window.XMGFX.pattern = -1;
};



window.XMGFX.onNewRow = function(row) {
	if (row == 1) {
		window.XMGFX.pattern++;
	}
	window.XMGFX.execNewRow(window.XMGFX.pattern, row);
};
window.XMGFX.onNewTrigger = function(row, col, note) {
	if (note) {
		note = String.fromCharCode(note);
		window.XMGFX.execNewTrigger(window.XMGFX.pattern, row, col, note);
	}
};
window.XMGFX.onNewRelease = function(row, col) {
	window.XMGFX.execNewRelease(window.XMGFX.pattern, row, col);
};

window.XMGFX.onNewValue = function(row, col, value) {
	if (value) {
		window.XMGFX.execNewValue(window.XMGFX.pattern, row, col, value);
	}
};

window.XMGFX.execNewPattern = function(pattern, row) {};
window.XMGFX.execNewRow = function(pattern, row) {};
window.XMGFX.execNewTrigger = function(pattern, row, col, note) {};
window.XMGFX.execNewRelease = function(pattern, row, col) {};
window.XMGFX.execNewValue = function(pattern, row, col, value) {};

// Kickstart
document.ready = function() {
	if (window.XMGFX.ready) {
		window.XMGFX.ready();
	}
	window.XMGFX.init();
};