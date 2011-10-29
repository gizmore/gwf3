/* Module_Language */
function changeLanguage(code)
{
	var append = (window.location.href.indexOf("?") == -1) ? "?" : "&";
	if (window.location.href.indexOf("change_language_to=") == -1)
	{
		append += "change_language_to=";
		window.location.href = window.location.href + append + code;
	}
	else
	{
		window.location.href = window.location.href.replace(/change_language_to=[a-z]{3}/, "change_language_to="+code);
	}
}
/* Browser Lang */
var gwf_browser_language = false;
function gwfGetBrowserLanguage()
{
	if (gwf_browser_language === false)
	{
		gwf_browser_language = ajaxSync(GWF_WEB_ROOT+'index.php?mo=Language&me=Get&ajax=true');
	}
	return gwf_browser_language;
/*	if (navigator.appName == 'Netscape')
	{
		var language = navigator.language;
	}
	else
	{
		var language = navigator.browserLanguage;
	}
	return language.substr(0, 2);*/
}
/* Google Trans */
function gwfGoogleTrans(id)
{
	var lang = gwfGetBrowserLanguage();
	
	var e = document.getElementById(id);
	if (e === null) {
		alert('Can not find element with id: '+id);
		return false;
	}
	var text = e.innerHTML;
//	text = text.replace(/<[^>]+>.+<[^>]+>/g, '');
//	text = text.replace(/<[^>]+>/g, '');
//	text = text.replace('/&nbsp;/g', ' ');
//	text = text.replace('/<br */?>/g', "\n");
	google.language.detect(text, function(result) {
		if (!result.error && result.language) {
			google.language.translate(text, result.language, lang,
					function(result) {
						if (result.translation) {
							e.innerHTML = result.translation;
						}
					});
        }
	});
}


/*======*/
/*= Ajax */
/*======*/
function getAjaxObject()
{
	var xmlHttp;
	try { // Firefox, Opera 8.0+, Safari
		xmlHttp = new XMLHttpRequest();
	}
	catch(e) { // Internet Explorer
		try {
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
    		catch (e) {
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	return xmlHttp;
}

function ajaxUpdate(id, url)
{
	var ajax = getAjaxObject();
	ajax.open("GET", url, true);
	ajax.onreadystatechange = function ()
	{
		if (ajax.readyState == 4)
		{
			$('#'+id).html(ajax.responseText);
		}
	};
	ajax.send(null);
	return true;
}

function ajaxUpdateSync(id, url)
{
	var result = ajaxSync(url);
	if (result === false) {
		return false;
	}
	$('#'+id).html(result);
	return true;
}

function ajaxSync(url)
{
	var ajax = getAjaxObject();
	ajax.open('GET', url, false);
	ajax.send(null);
	if(ajax.status === 200)
	{
		return ajax.responseText;
	}
	return false;
}

function ajaxSyncPost(url, data)
{
	var ajax = getAjaxObject();

	ajax.open('POST', url, false);

	//Send the proper header information along with the request
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", data.length);
	ajax.setRequestHeader("Connection", "close");

	
	ajax.send(data);
	if(ajax.status == 200)
	{
		return ajax.responseText;
	}
	return false;
}

/*=====================*/
/*= Selects and Options */
/*=====================*/
function getSelectOptions(selectID)
{
	return document.getElementById(selectID).options;
}

function getSelectedValue(selectID)
{
	return getSelectedValueB(document.getElementById(selectID));
}

function getSelectedValueB(select)
{
	return select.options[select.selectedIndex].value;
}

function setOptionSelected(options, selectedValue)
{
	var len = options.length;
	var sel = 0;
	for (var i = 0; i < len; i++)
	{
		if (options[i].value == selectedValue)
		{
			options[i].selected = true;
			break; 
		}
	}
	return true;
}

function addOption(select, text, value)
{
	var option = document.createElement('option');
	option.text = text;
	option.value = value;
	try {
		select.add(option, null);
	}
	catch(ie) {
		try {
			select.add(option);
		}
		catch(huh) {
			alert("Fatal JS error addOption()");
			return false;
		}
	}
	return true;
}

function clearSelect(select)
{
	var len = select.options.length;
	while (len > 0)
	{
		len--;
		select.remove(len);
	}
}

/* ============ */
/* = GFX Util = */
/* ============ */
function toggleHidden(id)
{
	try {
		var div = document.getElementById(id);
		if (div.style.display == "") {
			div.style.display = "none";
		}
		div.style.display = div.style.display == "none" ? "block" : "none";
		return true;
	}
	catch (ex) {
		return false;
	}
}

function getDivPosY(el)
{
	for (var y=0; el != null; y += el.offsetTop, el = el.offsetParent);
	return y;
}

function getDivPosX(el)
{
	for (var y=0; el != null; y += el.offsetLeft, el = el.offsetParent);
	return y;
}

function getDivWidth(el)
{
	el.style.width = "auto";
	return el.offsetWidth;
}

function getDivHeight(el)
{
	el.style.height = "auto";
	return el.offsetHeight;
}

String.prototype.ltrim = function(chars)
{
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "gD"), "");
};
String.prototype.rtrim = function(chars)
{
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "gD"), "");
};
String.prototype.trim = function(chars)
{
	return str.rtrim(chars).ltrim(chars);
};
String.prototype.startsWith = function(s) { return this.match(new RegExp('^'+s, 'i')) !== null; };
String.prototype.endsWith = function(s) { return this.match(new RegExp(s+'$', 'i')) !== null; };
String.prototype.contains = function(s) { return this.match(new RegExp(s, 'i')) !== null; };
String.prototype.substrUntil = function(s, d)
{
	var i = this.indexOf(s);
	if (i === -1) {
		return d;
	}
	return this.substring(0, i);
};

function in_array(needle, haystack, argStrict)
{
	if (!!argStrict) {
		for (var key in haystack) {
			if (haystack[key] === needle) {
				return true;
			}
		}
	} else for (var key in haystack) {
		if (haystack[key] == needle) {
			return true;
		}
	}
	return false;
}

/*-========-*/
/* Ajax GDO */
/*-========-*/
function gwfIsSuccess(response)
{
	if (response === false)
	{
		return false;
	}
	return gwfNextToken(response, 0) > 0;
}
function gwfDisplayMessage(response)
{
	if (response === false) {
		alert('GWF Response Error 1');
		return;
	}
	var len = response.length;
	var i = 0;
	var message = '';
	while (i < len)
	{
		var code = gwfNextToken(response, i);
		i += code.length + 1;
		
		var dlen = gwfNextToken(response, i);
		i += dlen.length + 1;
		
		message += "\n" + response.substr(i, dlen);
		i += dlen + 1;
	}
	alert(message.substr(1));
}
function gwfNextToken(response, i)
{
	var index = response.indexOf(":", i);
	if (index === -1) {
		alert('GWF Response Error 2');
		return '';
	}
	return response.substring(i, index);
}

/*-====-*/
/*- BB -*/
/*-====-*/
var GWF_BB_CODE_LANGS = undefined;

function bbReplace(start, end) {

	alert(start+end);

	textarea = document.getElementById("bb_message");

	alert(textarea);

	return true;

}

function bbInsert(key, start, end)
{
	var myField = document.getElementById(key);
	if (myField === null) {
		alert("Can not find Element with ID 'gwf_msg_in'. :(");
	}

	// IE support TODO: Broken
	if (document.selection) {
		
		myField.focus();
		//in effect we are creating a text range with zero
		//length at the cursor location and replacing it
		//with myValue
		var sel = document.selection.createRange();
		sel.text = start+sel.text+end;
		
	}

	//Mozilla/Firefox/Netscape 7+ support
	else if ( myField && (myField.selectionStart || myField.selectionStart == '0') ) {

		//Here we get the start and end points of the
		//selection. Then we create substrings up to the
		//start of the selection and from the end point
		//of the selection to the end of the field value.
		//Then we concatenate the first substring, myValue,
		//and the second substring to get the new value.
	
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var newString = myField.value.substring(0, startPos);
		newString += start;
		newString += myField.value.substring(startPos, endPos);
		newString += end;
		newString += myField.value.substring(endPos, myField.value.length);
		
		myField.value = newString;
		
	}
	else {
		myField.value += myValue;
	} 

	return true;
}

function bbInsertCode(key)
{
	if (false === bbInsertCodeInit(key)) {
		return bbInsert(key, '[code]', '[/code]');
	}
	return false;
}

function bbInsertCodeInit(key)
{
	var div = $('#bb_code_'+key);
//	var div = document.getElementById('bb_code_'+key);
	if (div === null) {
		return false;
	}
	
	if (GWF_BB_CODE_LANGS === undefined)
	{
		var result = ajaxSync(GWF_WEB_ROOT+'index.php?mo=Language&me=CodeLangs&ajax=true&key='+key);
		div.html(result);
		GWF_BB_CODE_LANGS = true;
	}
	else {
		if (div.is(':visible')) {
			div.hide();
		}
		else {
			div.show();
		}
	}
	
	return true;
}

function bbInsertCodeNow(key)
{
	var div = document.getElementById('bb_code_'+key);
	var title = document.getElementById('bb_code_title_'+key);
	var lang = document.getElementById('bb_code_lang_sel_'+key);
	if (title === null || lang === null || div === null) {
		bbInsert('[code]', '[/code]');
		return false;
	}
	var langHTML = lang.selectedIndex == 0 ? '' : ' lang='+getSelectedValue('bb_code_lang_sel_'+key);
	var titleHTML = title.value === '' ? '' : ' title='+title.value;
	bbInsert(key, '[code'+langHTML+titleHTML+']', '[/code]');
	div.style.display = 'none';
	div.html('');
	GWF_BB_CODE_LANGS = undefined;
	return false;
}

function bbInsertURL(key)
{
	if (false === bbInsertURLInit(key)) {
		return bbInsert(key, '[url=http://google.com]', '[/code]');
	}
	return false;
	
}

function bbInsertURLInit(key)
{
	$('#bb_url_'+key).show();
	return false;
}


function focusInput(selector)
{
	var jq = $(selector);
	if (!jq.length)
	{
		jq = $('input[type=text]').sort('top', 'ASC');
	}
	jq[0].focus();
}

function clamp(num, min, max)
{
	if ( (min !== null) && (num < min) )
	{
		return min;
	}

	if ( (max !== null) && (num > max) )
	{
		return max;
	}
	
	return num;
}