//var konz_ns_w = 175;
//var konz_ns_h = 379;

//var vhbgleftwidth = -1;
//var vhbgrightwidth = -1;


function initKonzert()
{
//	jQuery.fn.center = function () {
//	    this.css("position","absolute");
//	    this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
//	    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
//	    return this;
//	};
	
//	initVorhangFades();
	initMugshots();
	initBGCurtain();
}

function konzertContactData()
{
	// Melanie
	$('#email_mg').html('<a href="mai'+'lto:info'+'@'+'melan'+'ie-gobbo.de">info'+'@m'+'elanie-gobbo.de</a>');
	$('#mobile_mg').html('+49 (0)151 - 50 45 68 09');
	$('#phone_mg').html('+49 (0)21 81 - 75 73 00');
	$('#fax_mg').html('+49 (0)21 81 - 75 73 01');
	// Management
	$('#email_va').html('<a href="mailto:elahaferkamp@googlemail.com">elahaferkamp@googlemail.com</a>');
	$('#phone_va').html('mobil: +49(0)179-7041812');
	// Devs
	$('#email_giz').html('gizmore@wechall.net');
	$('#email_jakob').html('ols.jakob@googlemail.com');
	
}

function konzInitPresse()
{
	try
	{
		tn = new Thumbnails();
		tn.instance('#thumbnails', 'img.mugshot', 2);
		tn.setButtons(GWF_WEB_ROOT+'/tpl/konz/img/pfeil_l.png', GWF_WEB_ROOT+'/tpl/konz/img/pfeil_r.png');
		tn.init();
		initMugshots();
	}
	catch (e)
	{
		alert(e);
	}
}

//
//function initVorhangFades()
//{
//}

//function initNotenstaender()
//{
//	var ns = $('#notenst');
//	ns.click(zoomNotenstaender);
//	var sx = konz_ns_w / 4;
//	var sy = konz_ns_h / 4;
//	sx = sprintf('%dpx', sx);
//	sy = sprintf('%dpx', sy);
//	ns.width(sx);
//	ns.height(sy);
//	ns.css('background-size', '100%');
//	
//	$('#notenbu').hide();
//	$('#notenbuc').hide();
//}

//function zoomNotenstaender()
//{
//	var ns = $('#notenst');
//	ns.unbind();
//	ns.animate({
//		'width': konz_ns_w,
//		'height': konz_ns_h,
//		'background-size': '100%'
//	}, 800, function() { $('#notenbu').show(); $('#notenbu').click(zoomNotenbuch); } );
//}

//function zoomNotenbuch()
//{
//	var ns = $('#notenst');
//	ns.animate({
//		'width': konz_ns_w*4,
//		'height': konz_ns_h,
//		'background-size': '100%'
//	}, 800, function() {} );
//	var nb = $('#notenbu');
//	nb.animate({
//		'width': konz_ns_w*4,
//		'height': konz_ns_h,
//		'background-size': '100%'
//	}, 800, function() { initBookPage(); } );
//	
//}

//function initBookPage()
//{
//	var nbc = $('#notenbuc');
//	nbc.show();
//}

/* Mugshots */
//var mugshotSmallHREF = '';
//var mugshotSmallWidth = 0;
//var mugshotSmallHeight = 0;
//var mugshotLargeWidth = 0

function initMugshots()
{
	new Mugshot({'selector':'a.mugshot'});
//	unbindMugshots();
//	bindMugshots();
}

//function bindMugshots()
//{
//	$('a.mugshot').click(function(){ return enlargeMugshot($(this)); });
//}
//
//function unbindMugshots()
//{
//	$('a.mugshot').unbind();
//	$('a.mugshot').click(function(){return false;});
//}

//function enlargeMugshot(a)
//{
//	unbindMugshots();
//	var img = a.find('img');
//	var href = a.attr('href');
//	var alt = img.attr('alt');
//	var title = img.attr('title');
//	var ms = getMugshotLarge();
//	ms.html('<img class="mugshotl" src="'+href+'" title="'+title+'" alt="'+alt+'" />');
//	var msi = ms.find('img');
//	prepareLargeMugshot(img, ms, msi);
////	return false;
//	$("<img/>")
//    .attr("src", href)
//    .load(function() {
//    	mugshotLargeWidth = this.width;
//    	mugshotLargeHeight = this.height;
//    	enlargeMugshotLoaded(img);
//    });
//	return false;
//}

//function getMugshotLarge()
//{
////	document.write('<div id="#mugshot" style="display: hidden;"></div>');
//	var ms = $('#mugshot');
//	return ms;
//}

function distortMugshot(img)
{
	img.attr('src', GWF_WEB_ROOT+'tpl/konz/img/distort.gif');
	img.css('width', mugshotSmallWidth+'px');
	img.css('height', mugshotSmallHeight+'px');
}

function prepareLargeMugshot(img, ms, msi)
{
	var w = img.width();
	var h = img.height();
	mugshotSmallHREF = img.attr('src');
	mugshotSmallWidth = w;
	mugshotSmallHeight = h;
	var pos = img.position();
	var oy = pos.top; // + 155;
	var ox = pos.left + 240;
	
	distortMugshot(img);

	ms.css('top', oy+'px');
	ms.css('left', ox+'px');
	msi.css('width', w+'px');
	msi.css('height', h+'px');
	ms.show();
}

function enlargeMugshotLoaded(img)
{
	var ms = $('#mugshot');
	var msi = ms.find('img');

	// Window
	var ww = $(window).width(); // - 24;
	var wh = $(window).height(); // - 24;
	var sx = $(window).scrollLeft();
	var sy = $(window).scrollTop();
	
	// Origin
	var pos = img.position();
	var oy = pos.top;// + 155;
	var ox = pos.left + 240;
	var ow = img.width();
	var oh = img.height();
	
	// Destination
	var dw = mugshotLargeWidth;
	var dh = mugshotLargeHeight;
	
	// Aspect Ratio
	var ax = dw / ww;
	var ay = dh / wh;
	
	var awh = dw / dh;
	var ahw = dh / dw;
	
	// Destination image width too large. Scale to screen width.
	if (dw > ww)
	{
		var rw = dw - ww;
		dw -= rw;
		var rh = rw * ahw;
		dh -= rh;
	}
	
	// Destinaion image too high. Offset and keep.
	if (dh > wh)
	{
		sy += (dh-wh)/2; // TODO: (currently just y offset and keep full image size)
	}
	
	var dx = (ww - dw) / 2 + sx;
	var dy = (wh - dh) / 2 + sy;
	
//	return false;
	
	ms.animate({
		'left': dx+'px',
		'top': dy+'px'
	}, 700, function() {} );
	msi.animate({
		'width': dw+'px',
		'height': dh+'px'
	}, 700, function() { msi.click(function() { return unMugShot(ms, msi, ox, oy, ow, oh, img); }); } );
	
	return false;
}

function unMugShot(ms, msi, ox, oy, ow, oh, img)
{
	msi.unbind();
	// Zoom back
	ms.animate({
		'left': ox+'px',
		'top': oy+'px'
	}, 300, function() {} );
	msi.animate({
		'width': ow+'px',
		'height': oh+'px'
	}, 300, function() { ms.hide(); bindMugshots(); mugshotRestore(img); } );
}

function mugshotRestore(img)
{
	img.attr('src', mugshotSmallHREF);
	img.attr('width', mugshotSmallWidth);
	img.attr('height', mugshotSmallHeight);
}




// --- --- //

/**
 * Open/Close curtains
 */

function initBGCurtain()
{
	$('a').not('.mugshot').click(function() { return konzertMenuRedirect(this); } );
	
	var left = $('#vhbg_left');
	var right = $('#vhbg_right');
	left.width('50%');
	right.width('50%');
	$('#content').css('opacity', '0.0');
	left.animate({
		'width': '200px'
	}, 1200, function() {} );
	right.animate({
		'width': '200px'
	}, 1200, function() { konzertContentFade('1.0'); } );
//	vhbgleftwidth = left.width();
//	vhbgrightwidth = right.width();
//	$('#buehne_left').click(konzertToggleCurtain);
}

function konzertContentFade(val)
{
	$('#content').animate({
		'opacity': val
	}, 500, function(){});
}

function konzertMenuRedirect(a)
{
	konzertContentFade('0.0');
	setTimeout(function() { konzertMenuRedirectB(a); }, 600);
	return false;
}

function konzertMenuRedirectB(a)
{
	var left = $('#vhbg_left');
	var right = $('#vhbg_right');
	left.animate({
		'width': '50%'
	}, 600, function() {} );
	right.animate({
		'width': '50%'
	}, 600, function() {} );
	
	setTimeout(function() {  document.location.href = a.href; }, 700);
	
	return false;
}

//var bgvh_mode = 0; 
//
//function konzertToggleCurtain()
//{
//	if (bgvh_mode === 0)
//	{
//		bgvh_mode = 2;
//		konzertOpenCurtain();
//	}
//	else if(bgvh_mode === 1)
//	{
//		bgvh_mode = 2;
//		konzertCloseCurtain();
//	}
//}
//
//function konzertOpenCurtain()
//{
//	var left = $('#vhbg_left');
//	var right = $('#vhbg_right');
//	left.animate({
//		'width': '200px'
//	}, 1000, function() {} );
//	right.animate({
//		'width': '200px'
//	}, 1000, function() { bgvh_mode = 1; } );
//}
//
//function konzertCloseCurtain()
//{
//	var left = $('#vhbg_left');
//	var right = $('#vhbg_right');
//	left.animate({
////		'width': vhbgleftwidth+'px'
//		'width': '50%'
//	}, 1000, function() {} );
//	right.animate({
//		'width': vhbgrightwidth+'px'
//	}, 1000, function() { bgvh_mode = 0; } );
//}

//====================================\\
//13thParallel.org Beziér Curve Code \\
//by Dan Pupius (www.pupius.net)   \\
//====================================\\
//coord = function (x, y)
//{
//	if(!x) var x=0;
//	if(!y) var y=0;
//	return {x: x, y: y};
//};
//
//function B1(t) { return t*t*t; }
//function B2(t) { return 3*t*t*(1-t); }
//function B3(t) { return 3*t*(1-t)*(1-t); }
//function B4(t) { return (1-t)*(1-t)*(1-t); }
//
//function getBezier(percent, C1, C2, C3, C4)
//{
//	var pos = new coord();
//	pos.x = C1.x*B1(percent) + C2.x*B2(percent) + C3.x*B3(percent) + C4.x*B4(percent);
//	pos.y = C1.y*B1(percent) + C2.y*B2(percent) + C3.y*B3(percent) + C4.y*B4(percent);
//	return pos;
//}

//var ts;
//var tn;
