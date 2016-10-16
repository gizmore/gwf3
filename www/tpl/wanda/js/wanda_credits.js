window.CC = window.CC ? window.CC : {};

window.CC.scrollTop = 0;
window.CC.timeout = 2;
window.CC.lineHeight = 32;

window.CC.effectRow = -1;
window.CC.effectY = 600;
window.CC.textRows = [];

window.CC.initElements = function(){
	var crid = window.CC.maindiv = $('<div id="crid"></div>');
	var content = window.CC.scrolldiv = $('<div id="coff"></div>');
	crid.append(content);
	
	var CC = window.CC;
	var txt = window.CC.scrollText;
	for (var y = 0; y < CC.height; y++) {
		var row = $('<div id="crow_"'+y+' class="crow"></div>');
		window.CC.textRows.push(row);
		for (var x = 0; x < CC.width; x++) {
			row.append($('<div id="clet_'+y+'_'+x+'" class="clet">'+txt.charAt(y*CC.width+x)+'</div>'));
		}
		content.append(row);
	}
	$(document.body).append(crid);
	
	var rowc = window.CC.rowcdiv = $('<div id="rowcdiv">-1</div>');
	$(document.body).append(rowc);

	var blitzdiv = window.CC.blitzdiv = $('<div id="blitzdiv"></div>');
	crid.append(blitzdiv);
};

window.CC.loadURI = function(uri) {
	var xhr = new XMLHttpRequest();
	xhr.open('GET', uri, true);
	xhr.responseType = 'arraybuffer';

	xhr.onload = function(e) {
	  if (this.status == 200) {
		    var arrayBuffer = xhr.response;
			XMPlayer.load(arrayBuffer);
			XMPlayer.play();
			window.CC.scrolldiv.css('display', 'block');
			window.CC.scrollTop = window.CC.screenHeight;
			window.CC.scrolldiv.css('top', window.CC.screenHeight+'px');
	  }
	};
	xhr.send();
};

window.CC.initMusic = function() {
	XMPlayer.init();
	window.CC.loadURI("/tpl/wanda/xm/kamel.xm");
};

window.CC.initScreen = function() {
	var w = window.CC.screenWidth = $(document).width();
	var h = window.CC.screenHeight = $(document).height();
	window.CC.effectY = h;
};

window.CC.currentRow = function() {
	return window.CC.textRows[window.CC.effectRow];
};

window.CC.nextRow = function() {
	return window.CC.textRows[window.CC.effectRow + 1];
};

// --- Effects --- //

window.CC.bumpEffect = function(pixels, duration) {
	pixels = pixels || '87';
	duration = duration || 424;
	var row = window.CC.currentRow();
	if (!row) {
		return;
	}
	row.css('left', pixels+'px');
	setTimeout(function(){
		row.animate({'left':'-'+pixels+'px'}, {
			easing: 'swing',
			done: function() {
				row.animate({'left':'0px'}, {
					easing: 'swing',
				});
			},
		});
	}, window.CC.timeout);
	
};

window.CC.blitzEffect = function(opacity, duration) {
	opacity = opacity || '0.999';
	duration = duration || 80;
	setTimeout(function(){
		var be = window.CC.blitzdiv;
		be.css('opacity', opacity);
		be.animate({'opacity': '0.000'}, duration);
	}, window.CC.timeout);
};

window.CC.scroll = function(scrollPixels, duration) {
	duration = duration || 10;
	window.CC.scrollTop -= scrollPixels;
	// Detect current scanline row
	window.CC.scrolldiv.animate({top: window.CC.scrollTop+'px'}, {
		done: function() {
			var nextRow = window.CC.nextRow();
			var rowY = nextRow.offset().top;
			if (rowY <= window.CC.effectY) {
				window.CC.effectRow += 1;
				console.log('EffectRow: '+window.CC.effectRow);
			}
		},
		duration: duration,
		easing: 'linear'
	});
};

// --- XMGFX Events --- //
window.XMGFX.execNewPattern = function(pattern) {
	window.CC.blitzEffect('0.999', 482);
//	window.CC.scroll(window.CC.lineHeight * 64)
};
window.XMGFX.execNewRow = function(pattern, row) {
	window.CC.scroll(window.CC.lineHeight / 4)
};
window.XMGFX.execNewTrigger = function(pattern, row, col, note) {
//	console.log("Triggered row: "+row+" col: "+col+ " Note:"+note);
};
window.XMGFX.execNewRelease = function(pattern, row, col) {
//	console.log("Release for row: "+row+" col: "+col);
};
window.XMGFX.execNewValue = function(pattern, row, col, value) {
	if ((col == 1) && (value == 12)) {
		window.CC.bumpEffect();
	}
	else if ((col == 2) && (value == 4)) {
	}
	else if ((col == 2) && (value == 14)) {
		window.CC.blitzEffect('0.425', 70);
	}
	else if ((col == 3) && (value == 6)) {
	}
	else if ((col == 13) && (value == 14)) {
	}
	else if ((col == 12) && (value == 14)) {
	}
	else {
//		console.log("Value for row: "+row+" col: "+col+" val: "+value);
	}
};

// --- Init --- //

$(function(){
	window.CC.initScreen();
	window.CC.initElements();
	window.CC.initMusic();
});
