function initKonzert()
{
//	jQuery.fn.center = function () {
//	    this.css("position","absolute");
//	    this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
//	    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
//	    return this;
//	};
	initMugshots();
	initBGCurtain();
}

function initMugshots()
{
	ms = new Mugshot();
	ms.init({'scale_func': function(data) { 
		var x = 240;
		var w = $(window).width() - (x*2);
		var y = $(window).height() * 0.10;
		var h = $(window).height() * 0.75;
		return ms.boxsize(data, x, y, w, h);
	}});
}

var SLIDE_MS = 8000;
var slide;
function initAboutSlideshow()
{
	slide = new Slideshow();
	slide.init();
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/140.jpg', GWF_WEB_ROOT+'tpl/konz/bild/140_large.jpg', 300, 200, SLIDE_MS);
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/49.jpg', GWF_WEB_ROOT+'tpl/konz/bild/49_large.jpg', 300, 200, SLIDE_MS);
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/29.jpg', GWF_WEB_ROOT+'tpl/konz/bild/29_large.jpg', 300, 200, SLIDE_MS);
	slide.next();
}

function initBiographySlideshow()
{
	slide = new Slideshow();
	slide.init();
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/68.jpg', GWF_WEB_ROOT+'tpl/konz/bild/68_large.jpg', 200, 300, SLIDE_MS);
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/87.jpg', GWF_WEB_ROOT+'tpl/konz/bild/87_large.jpg', 200, 300, SLIDE_MS);
//	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/128.jpg', GWF_WEB_ROOT+'tpl/konz/bild/128_large.jpg', 200, 300, SLIDE_MS);
//	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/126.jpg', GWF_WEB_ROOT+'tpl/konz/bild/126_large.jpg', 200, 300, SLIDE_MS);
	slide.next();
}

function initRepertoireSlideshow()
{
	slide = new Slideshow();
	slide.init();
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/52.jpg', GWF_WEB_ROOT+'tpl/konz/bild/52_large.jpg', 200, 300, SLIDE_MS);
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/84.jpg', GWF_WEB_ROOT+'tpl/konz/bild/84_large.jpg', 200, 300, SLIDE_MS);
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/93.jpg', GWF_WEB_ROOT+'tpl/konz/bild/93_large.jpg', 200, 300, SLIDE_MS);
	slide.addImage(GWF_WEB_ROOT+'tpl/konz/bild/96.jpg', GWF_WEB_ROOT+'tpl/konz/bild/96_large.jpg', 200, 300, SLIDE_MS);
	slide.next();
}


function Slideshow()
{
	var slideCurr = -1;
	var slideTimer = null;
	var images = new Array();
	
	this.addImage = function(href_s, href_x, w, h, ms)
	{
		images.push(new Array(href_s, href_x, w, h, ms));
	};
	
	this.current = function()
	{
//		$('img.mugshot_right').animate({'opaque': 0.0}, function(){
//			this.animate({'': 1.0}, function(){ this.currentB(); });
//		});
		
		
		var data = images[slideCurr];
		$('a.mugshot_left').attr('href', data[1]);
		
		$img = $('img.mugshot_img');
		$img.attr('src', data[0]).attr('width', data[2]).attr('height', data[3]);
		$img.animate({'opacity': 1.0}, 1000);
		
		this.stopTimer();
		slideTimer = setTimeout(function(){ slide.next(); }, data[4]);
	};

	this.next = function()
	{
		slideCurr++;
		if (slideCurr >= images.length)
		{
			slideCurr = 0;
		}
		$('img.mugshot_img').css('opacity', 1.0).animate({'opacity': 0.0}, 1000, function(){ slide.current(); });
	};
	
	this.init = function()
	{
		$('a.mugshot_left').click(function(){ slide.stopTimer(); });
		$('#mugshot').click(function(){ slide.current(); });
	};
	
	this.stopTimer = function()
	{
		if (slideTimer !== null)
		{
			clearTimeout(slideTimer);
			slideTimer = null;
		}
	};
}


function initGhostwriter()
{
	var p = $('.ghost');
	p.ghostwriter('init', {
		'color_left': '#feffff',
		'color_right': '#fbfb26',
		'opaq_left': 1.00,
		'opaq_right': 0.70,
		'group': 3,
		'ngroups': 12,
		'delay': 1500,
		'interval': 85,
		'callback': function(){}
	});
	p.ghostwriter('type');
}

function initGhostwriterIntro()
{
	var p = $('.ghost_intro');
	p.ghostwriter('init', {
		'style_processed': 'font-size: 32px; color: #fff;',
		'color_left': '#feffff',
		'color_right': '#fbfb26',
		'size_left': 32,
		'size_right': 10,
		'opaq_left': 1.00,
		'opaq_right': 0.60,
		'group': 1,
		'ngroups': 28,
		'delay': 1500,
		'interval': 85,
		'callback': function(){}
	});
	p.ghostwriter('type');
}

function konzertContactData()
{
	// Melanie
	$('#email_mg').html('<a href="mai'+'lto:info'+'@'+'melan'+'ie-gobbo.de">info'+'@m'+'elanie-gobbo.de</a>');
	$('#mobile_mg').html('+49 (0)151 - 50 45 68 09');
	$('#phone_mg').html('+49 (0)21 81 - 75 73 00');
	$('#fax_mg').html('+49 (0)21 81 - 75 73 01');
	// Management
	$('#email_va').html('<a href="mailto:elahaferkamp'+'@googlemail.com">elahaferkamp@'+'googlemail.com</a>');
	$('#phone_va').html('mobil: +49(0)179-7041812');
	// Devs
	$('#email_giz').html('gizmore@'+'wechall.net');
	$('#email_jakob').html('ols.jakob'+'@googlemail.com');
}

function konzInitPresse()
{
	try
	{
		tn = new Thumbnails();
		tn.instance('#thumbnails', 'img.mugshot', 2);
		tn.setButtons(GWF_WEB_ROOT+'tpl/konz/img/pfeil_l.png', GWF_WEB_ROOT+'tpl/konz/img/pfeil_r.png');
		tn.init();
		initMugshots();
	}
	catch (e)
	{
		alert(e);
	}
}

/*---------------------.
 * Open/close curtains -
 *--------------------*/
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
	}, 800, function() {} );
	right.animate({
		'width': '200px'
	}, 800, function() { konzertContentFade('1.0'); } );
}

function konzertContentFade(val)
{
	$('#content').animate({
		'opacity': val
	}, 500, function(){});
}

function konzertMenuRedirect(a)
{
	$('#mugshot').hide();
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
	}, 400, function() {} );
	right.animate({
		'width': '50%'
	}, 400, function() {} );
	setTimeout(function() {  document.location.href = a.href; }, 500);
	return false;
}

function konzertInitTermine()
{
	var i = 1;
	$('.col_tickets').each(function(index, element){
		var e = $(this);
		var content = e.html();
		if (content !== '')
		{
			var new_con = '<a onclick="return konzertToggleShow('+i+');" href="#">Tickets</a><div id="konz_tickets_'+i+'">'+content+'</div>';
			e.html(new_con);
			konzertToggleShow(i);
		}
		i++;
	});
}

function konzertToggleShow(index)
{
	var e = $('#konz_tickets_'+index);
	if (e.is(":visible"))
	{
		e.fadeOut(700);
	}
	else
	{
		e.fadeIn(700);
	}
	return false;
}
