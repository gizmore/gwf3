window.CC = {};
window.CC.scrollText =
 "...........25............"
+".Well that is a scroller."
+".                       ."
+".       H               ."
+".               E       ."
+".       R               ."
+".               E       ."
+".                       ."
+".                       ."
+".       W       E       ."
+".                       ."
+".         THANK!        ."
+".                       ."
+".      THE PEOPLE!      ."
+".                       ."
+".                       ."
+".   WHO INSPIRED US!    ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".   WHO GAVE US GIFTS   ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".     !BITWARRIORS!     ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".      FAIR LIGHT       ."
+".         TLC           ."
+".   WORLD O.F WONDERS   ."
+".       SKID ROW        ."
+".      BYTEBANDIT       ."
+".         ASD           ."
+".      LUCAS ARTS       ."
+".       BULLFROG        ."
+".        E LITE         ."
+".          Z            ."
+".          Z            ."
+".          Z            ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".     !!!TEACHERS!!!    ."
+".                       ."
+".       HERR MIEHE      ."
+".       FRAU MORAWE     ."
+".       HERR CLEMENS    ."
+".       FRAU GÜNTHER    ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".   art is (c)by Anja   ."
+".   Text by gizmore     ."
+"........................."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".                       ."
+".	                      ."
+".                       .";
window.CC.width = 25;
window.CC.height = 86;
window.CC.scrollTop = 110.0;


window.CC.initElements = function(){
	var crid = $('<div id="crid"></div>');
	var content = window.CC.scrolldiv = $('<div id="coff"></div>');
	crid.append(content);
	
	var CC = window.CC;
	var txt = window.CC.scrollText;
	for (var y = 0; y <= CC.height; y++) {
		var row = $('<div id="crow_"'+y+' class="crow"></div>');
		for (var x = 0; x <= CC.width; x++) {
			row.append($('<div id="clet_'+y+'_'+x+'" class="clet">'+txt.charAt(y*CC.width+x)+'</div>'));
		}
		content.append(row);
	}
	$(document.body).append(crid);
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
	  }
	};
	xhr.send();
};

window.CC.initMusic = function() {
	console.log('CC.initMusic()');
	XMPlayer.init();
	window.CC.loadURI("/tpl/wanda/xm/kamel.xm");
};



window.XMGFX.execNewRow = function(row) {
	window.CC.scrollTop -= 0.5;
	window.CC.scrolldiv.animate({top: window.CC.scrollTop+'%'}, 100);
};
window.XMGFX.execNewTrigger = function(row, col, note) {
	
};
window.XMGFX.execNewRelease = function(row, col) {
};
window.XMGFX.execNewValue = function(row, col, value) {
	
};



$(function(){
	window.CC.initElements();
	window.CC.initMusic();
});
