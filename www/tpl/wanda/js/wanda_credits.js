window.CC = window.CC ? window.CC : {};
window.CC.lineHeight = 32;
window.CC.scrollTop = 110.0;


window.CC.initElements = function(){
	var crid = $('<div id="crid"></div>');
	var content = window.CC.scrolldiv = $('<div id="coff"></div>');
	crid.append(content);
	
	var CC = window.CC;
	var txt = window.CC.scrollText;
	for (var y = 0; y < CC.height; y++) {
		var row = $('<div id="crow_"'+y+' class="crow"></div>');
		for (var x = 0; x < CC.width; x++) {
			row.append($('<div id="clet_'+y+'_'+x+'" class="clet">'+txt.charAt(y*CC.width+x)+'</div>'));
		}
		content.append(row);
	}
	$(document.body).append(crid);
	
	var rowc = window.CC.rowcdiv = $('<div id="rowcdiv">-1</div>');
	$(document.body).append(rowc);
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
	console.log("InitScreen width: "+w+" height: "+h);
};



window.XMGFX.execNewRow = function(row) {
	window.CC.scrollTop -= window.CC.lineHeight / 4;
	window.CC.scrolldiv.animate({top: window.CC.scrollTop+'px'}, 20);
};
window.XMGFX.execNewTrigger = function(row, col, note) {
	
};
window.XMGFX.execNewRelease = function(row, col) {
};
window.XMGFX.execNewValue = function(row, col, value) {
	console.log(value);
};



$(function(){
	console.log("INIT");
	console.log(window.CC.scrollText);
	
	window.CC.initScreen();
	window.CC.initElements();
	window.CC.initMusic();
});
