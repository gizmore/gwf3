
function wcSiteQuickqump(select, mode, level)
{
//	console.log('wcSiteQuickjump', select, mode, level);
	var siteid = select.value;
	var sitename = select.options[select.selectedIndex].text;
//	sitename = encodeURIComponent(encodeURIComponent(sitename));
	sitename = encodeURIComponent(sitename);
	
	if (siteid == 0)
	{
		return;
	}
	else if (mode === 'detail')
	{
		if (level === 2)
		{
			var url = GWF_WEB_ROOT+siteid+'-levels-on-'+sitename+'.html';
		}
		else
		{
			var url = GWF_WEB_ROOT+'site/details/'+siteid+'/'+sitename;	
		}
	}
	else if (mode === 'ranking')
	{
		if (level === 2)
		{
			var url = GWF_WEB_ROOT+siteid+'-players-on-'+sitename+'.html';
		}
		else
		{
			var url = GWF_WEB_ROOT+'site/ranking/for/'+siteid+'/'+sitename;
		}
	}
	else if (mode === 'history')
	{
		var url = GWF_WEB_ROOT+'site/history/'+sitename;
	}
	else if ( (mode === 'boxdetail') || (mode === 'boxdetails') )
	{
		var url = GWF_WEB_ROOT+'site/details/'+siteid+'/'+sitename;	
//		var url = GWF_WEB_ROOT+siteid+'-levels-on-'+sitename+'.html';
	}
	else if (mode === 'boxranking')
	{
		var url = GWF_WEB_ROOT+siteid+'-players-on-'+sitename+'.html';
	}
	else
	{
		return;
	}
	
	window.location = url;
}

var wc_statsites_cleared = true;

function wcStatsClearSites()
{
	wc_statsites_cleared = !wc_statsites_cleared;
	
	var inputs = document.getElementsByTagName("input");
	for (var i = 0; i < inputs.length; i++)
	{
		if (inputs[i].name.indexOf('site[') === 0) {
			inputs[i].checked = wc_statsites_cleared;
		}
	}
	
	wcStatsRefresh();
	
	return false;
}

/* wechall.stats.1.month.2010.05.11.icons,nums.1,4,5.800.600.gizmore.vs.unhandled.jpg */

function wcStatGetOption(id, back)
{
	var e = document.getElementById(id);
	if (e === null) {
		alert('#0815: Can not find element '+id);
		return '';
	}
	return e.checked ? ','+back : '';
}

function wcStatsRefreshURL()
{
	var today = new Date();
	var today2 = sprintf('.%04d.%02d.%02d', today.getFullYear(), today.getMonth()+1, today.getDate());

	// Duration Select
	var duration = ''; // .1.month
	
	var options = '';
	options += wcStatGetOption('wcstatcbx_ico', 'icons');
	options += wcStatGetOption('wcstatcbx_num', 'nums');
	options += wcStatGetOption('wcstatcbx_zoom', 'zoom');
	if (options !== '') { options = options.substr(1); }
	options = "."+options;
	
	// Selected Site
	var selsites = '';
	var inputs = document.getElementsByTagName("input");
	for (var i = 0; i < inputs.length; i++)
	{
		if (inputs[i].name.indexOf('site[') === 0) {
			if (inputs[i].checked) {
				selsites += "," + inputs[i].value;
			}
		}
	}
	if (selsites !== '') { selsites = selsites.substr(1); }
	selsites = '.'+selsites;

//	var res = '.800.600';
	
	var res = wcStatGetResolution();
	
//	alert(res);
	
	var username1 = '.'+wcstatuname;
	var username2 = wcstatvsname;// wcStatGetVersus();

	if (username2 !== '') {
		username2 = '.vs.'+username2;
	}
	
	var href = GWF_WEB_ROOT+'wechall.stats'+duration+today2+options+selsites+res+username1+username2+'.jpg';
	
//	alert(href);
	return href;
	
}

//function wcStatGetVersus()
//{
//	var el = document.getElementById('wcstatvs');
//	if (el === null) {
////		alert('Can not find element wcstatvs.');
//		return '';
//	}
//	var vs = el.value.trim();
//	if (vs === '') {
//		return '';
//	}
//	return '.vs.'+vs;
//}

function wcStatGetResolution()
{
	var e = document.getElementById('wcstatbox');
	if (e === null) {
		alert('Can not find element wcstatbox.');
		return '.800.600';
	}
//	e.style.width="auto";
//	e.style.height="auto";
//	var w = parseInt(e.style.offsetWidth);
//	var h = parseInt(e.style.offsetHeight);
	var w = getDivWidth(e);
	var sh = getScreenHeight();
//	alert(sh);
	var y = getDivPosY(e);
//	alert(y);
	var h = sh - y;
	
//	alert(w);
//	alert(h);
	
	if (w < 320) { w = 320; }
	else if (w > 1024) { w = 1024; }
	if (h < 240) { h = 240; }
	else if (h > 768) { h = 768; }
	
	return sprintf('.%d.%d', w, h);
}

function getScreenHeight()
{
	return screen.height;
}

function wcStatsRefresh()
{
	// Reload Image
	var img = document.getElementById('wc_statgraph');
	if (img == null) {
		alert('Can not get wc_statgraph element.');
		return;
	}
	img.src = wcStatsRefreshURL();
}

function wcStatsCheckSite(checkbox)
{
	wcStatsRefresh();
}

var wcstatuname = 'WeChall';
var wcstatvsname = '';
function wcstatgraphInit(username, username2)
{
	wcstatuname = username;
	wcstatvsname = username2;
	document.writeln(sprintf('<img id="wc_statgraph" src="%s" />', wcStatsRefreshURL()));
}


/* Lang Ranking */
//function wcjsLangRanking()
//{
//	$("td img").click(function(){
//		var src = this.src;
//		var from = src.lastIndexOf('/');
//		var to = src.lastIndexOf('?');
//		if ( (from === -1) || (to === -1) ) {
//			return;
//		}
//		var siteid = src.substring(from+1, to);
//		wcjsShowSiteDetails(this, siteid);
//	});
//}

var wcjs_last_site = undefined;
//function wcjsShowSiteDetails(img, siteid)
//{
//	if (wcjs_last_site === siteid) {
//		wcjsHideJQuery('#wcrl_slide');
//		wcjs_last_site = '';
//		return;
//	}
//	wcjs_last_site = siteid;
//	
//	var username = img.alt;
//	var detail_href = GWF_WEB_ROOT+'index.php?mo=WeChall&me=SiteDetails&ajax=true&sid='+siteid+'&username='+username;
//	var content = ajaxSync(detail_href);
//	var slide = $('#wcrl_slide');
//	slide.html(content);
//	slide.css('top', getDivPosY(img)+30);
////	slide.css('left', getDivPosX(img));
////	$("#wcrl_slide").css('top', getDivPosY(img)-60);
////	$("#wcrl_slide").css('min-width', '80%');
////	$("#wcrl_slide").css('min-height', '80%');
////	$("#wcrl_slide").css('width', 'auto');
////	$("#wcrl_slide").css('height', 'auto');
//	slide.hide();
//	slide.fadeIn('fast');
//}

function wcjsHideJQueryAll()
{
	wcjsHideJQuery('#wcrl_slide');
	wcjsHideJQuery('#wc_profile_slide');
	wcjs_last_profile = '';
	wcjs_last_site = '';
}

function wcjsHideJQuery(id)
{
	var jq = $(id);
	jq.fadeOut('fast');
//	jq.width('0px');
//	jq.height('0px');
	jq.hide();
}

function wcjsProfileJQuery()
{
	$("a[href*='"+GWF_WEB_ROOT+"profile/']").not(".gwf_button").click(function(){
		var href = this.href;
		var from = href.lastIndexOf('/');
		if (from === -1) {
			return false;
		}
		href = href.substring(from+1);
		wcjsShowProfile(this, href);
		return false;
	});
	
//	$(".wc_side_box .wc_side_title").click(function(){
//		wcjsToggleSidebox(this);
//	});

}

function wcjsSitePopupJQuery()
{
	$('a.siteanchor').click(wcjsClickSite);
	$('img.wc_logo').click(wcjsClickSiteLogo);
}

function wcjsClickSiteLogo()
{
	console.log('wcjsClickSiteLogo');
	
	var img = $(this);
	var siteid = img.attr('src').substrUntil('?').substrFrom('logo/');
	
	if (wcjs_last_site === undefined)
	{
		wcjs_last_site = siteid;
		
		var username = img.attr('alt');
		var href = GWF_WEB_ROOT+"index.php?mo=WeChall&me=SiteDetails&ajax=true&sid="+siteid+'&username='+username;
		var content = ajaxSync(href);
		var slide = $('#wc_profile_slide');
		slide.css('max-width', '50%');
		slide.html(content);
		wcjsPopupPos(slide, this);
		
	}
	
	else if (wcjs_last_site === siteid)
	{
		wcjs_last_site = undefined;
		wcjsHideJQuery('#wc_profile_slide');
	}
	
	else
	{
	}
	
	return false;
}

function wcjsClickSite()
{
	console.log('wcjsClickSite()');
	var a = $(this);
	var sitename = a.attr('href');
	
	if (sitename === undefined)
	{
		return true;
	}
	
	if (wcjs_last_site === sitename)
	{
		wcjs_last_site = undefined;
		wcjsHideJQuery('#wc_profile_slide');
		return false;
	}
	
	wcjs_last_site = sitename;
	
	var href = GWF_WEB_ROOT+"index.php?mo=WeChall&me=SiteDetails&ajax=true&url="+sitename;
	var content = ajaxSync(href);
	var slide = $('#wc_profile_slide');
	slide.css('max-width', '50%');
	slide.html(content);
	wcjsPopupPos(slide, this);

	return false;
}

//function wcjsToggleSidebox(box)
//{
//	alert(box.innerHTML);
//}

var wcjs_last_profile = '';

function wcjsShowProfile(anchor, username)
{
	if (wcjs_last_profile === username) {
		wcjsHideJQuery('#wc_profile_slide');
		wcjs_last_profile = '';
		return;
	}
	wcjs_last_profile = username;
	
	var href = GWF_WEB_ROOT+"index.php?mo=Profile&me=Profile&ajax=true&username="+username;
	var content = ajaxSync(href);
	var slide = $('#wc_profile_slide');
	slide.html(content);
	wcjsPopupPos(slide, anchor)
}

/**
 * Popup an inline box, at the best coordinates for an anchor
 * @param popup
 * @param anchor
 * @return
 */
function wcjsPopupPos(popup, anchor)
{
	// Screen
//	var sw = screen.width;
//	var sh = screen.height;
//	var y0 = $(window).scrollTop();

	// Popup
//	var pw = popup.width();
//	var ph = popup.height();
	// Anchor
	var ax1 = getDivPosX(anchor);
	var ay1 = getDivPosY(anchor);
	var aw = getDivWidth(anchor);
	var ah = getDivHeight(anchor);
	var ax2 = ax1 + aw;
	var ay2 = ay1 + ah;
	
	popup.hide();

//	if (true === wcjsPopupPosDown(popup, ax1, ay1, aw, ah)) {
//	}
//	else if (true === wcjsPopupPosUp(popup, ax1, ay1, aw, ah)) {
//	}
//	else if (true === wcjsPopupPosLeft(popup, ax1, ay1, aw, ah)) {
//	}
//	else if (true === wcjsPopupPosRight(popup, ax1, ay1, aw, ah)) {
//	}
//	else {
		wcjsPopupPosCenter(popup, ax1, ay1, aw, ah);
//	}

	popup.fadeIn('fast');
	
//	// X
//	var px1 = 0;
//	if ( (ax1 - pw) < 0 ) {
//		px1 = ax2;
//	}
//	else {
//		px1 = ax1 - pw;
//	}
//	// Y
//	var py1 = 0;
//	if ( (ay1 - ph) < y0) {
//		py1 = ay2;
//	} else {
//		py1 = ay1 - ph - ah;
//	}
	
}

function wcjsPopupPosDown(popup, ax1, ay1, aw, ah)
{
	return false;
}

function wcjsPopupPosUp(popup, ax1, ay1, aw, ah)
{
	return false;
}

function wcjsPopupPosLeft(popup, ax1, ay1, aw, ah)
{
	return false;
}

function wcjsPopupPosRight(popup, ax1, ay1, aw, ah)
{
	return false;
}

function wcjsPopupPosCenter(popup, ax1, ay1, aw, ah)
{
	var sw = $(window).width();
	var sh = $(window).height();
	var y0 = $(window).scrollTop();

	var px1 = (sw-popup.width()) / 2;
	var py1 = (sh-popup.height()) / 2;

	if (px1 < 0) {
		px1 = 0;
	}
	
	py1 += y0;
	if (py1 < 0) {
		py1 = 0;
	}
	
	popup.css('left', px1);
	popup.css('top', py1);

	return false;
}

/* Username auto completition */
var WC_USER_COMPLETITION = new Array();
function wcjsStatsJQuery()
{
	$('#wc_stat_user1').autocomplete({ source: wcjsAutocompleteUser });
	$('#wc_stat_user2').autocomplete({ source: wcjsAutocompleteUser });
//	$('#wc_stat_user1').change(function(){ wcjsChangeStatUser(1); });
//	$('#wc_stat_user2').change(function(){ wcjsChangeStatUser(2); });
	$('#wc_stat_user1').keypress(function(event){ wcjsStatUserKey(1, event); });
	$('#wc_stat_user2').keypress(function(event){ wcjsStatUserKey(2, event); });
	
}

//function wcjsStatUserKey(num, event)
//{
//	if (event.keyCode == 13) {
//		wcjsChangeStatUser(num);
//	}
//}

function wcjsChangeStatUser(num)
{
	if (num === 1)
	{
		wcstatuname = $('#wc_stat_user1').val();
		window.location.href = GWF_WEB_ROOT+"stats/"+wcstatuname;
	}
	else if (num === 2)
	{
		wcstatvsname = $('#wc_stat_user2').val();
	}
	wcStatsRefresh();
}

function wcjsAutocompleteUser(termObject, callback)
{
	var term = termObject.term;
	var suggest = new Array();
	var letter = term.substring(0, 1).toLowerCase();
	if (letter < 'a' || letter > 'z') {
		return;
	}
	if (WC_USER_COMPLETITION[letter] === undefined)
	{
		var json = ajaxSync(GWF_WEB_ROOT+'index.php?mo=WeChall&ajax=true&me=Ajax&letter='+letter);
		WC_USER_COMPLETITION[letter] = eval(json);
	}
	var j = 0;
	for (var i in WC_USER_COMPLETITION[letter])
	{
		var s = WC_USER_COMPLETITION[letter][i];
		if (s.startsWith(term))
		{
			suggest[j++] = s;
		}
	}
	callback(suggest);
}

/* Unread3 engine */
function wcjsInit()
{
	setInterval(wcjsNotify, 90000);
	wcjsProfileJQuery();
	wcjsSitePopupJQuery();
}

function wcjsNotify()
{
	$.ajax({
		url: GWF_WEB_ROOT+'index.php?mo=WeChall&me=UnreadCounter&ajax=true',
		success: function(data)
		{
			if (data.charAt(0) === '0')
			{
//				alert(data);
				return;
			}
			wcjsNotifyB(eval('('+data+');'));
		}
	});
}

function wcjsNotifyB(data)
{
	wcjsNotifyC('#wc_menu a[href*=news]', data['news']);
	wcjsNotifyC('#wc_menu a[href*=forum]', data['forum']);
	wcjsNotifyC('#wc_menu a[href*=pm]', data['pm']);
	wcjsNotifyC('#wc_menu a[href*=links]', data['links']);
	
	wcjsNotifyD(data);
}

function wcjsNotifyC(selector, amt)
{
	var anchor = $(selector);
	if (anchor.length !== 1)
	{
		return;
	}
	
	var text = anchor.text();
	text = text.substrUntil('[', text);
	
	if (amt > 0)
	{
		text += '['+amt+']';
	}
	
	anchor.text(text);
}

function wcjsNotifyD(data)
{
	var total = 0;
	for (var key in data)
	{
		total += data[key];
	}
	
	var text = document.title;
	var re = /^\[\d+\]/;
	if (text.match(re))
	{
		text = text.substrFrom(']');
	}
	
	if (total > 0)
	{
		text = '['+total+']'+text;
	}
	
	document.title = text;
}
