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

/* Ajax */
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

/* Selects and Options */
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

/* Hide container */
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

/**
*  Javascript sprintf
*  http://www.webtoolkit.info/
**/
var sprintfWrapper = {

    init : function () {

        if (typeof arguments == "undefined") { return null; }
        if (arguments.length < 1) { return null; }
        if (typeof arguments[0] != "string") { return null; }
        if (typeof RegExp == "undefined") { return null; }

        var string = arguments[0];
        var exp = new RegExp(/(%([%]|(\-)?(\+|\x20)?(0)?(\d+)?(\.(\d)?)?([bcdfosxX])))/g);
        var matches = new Array();
        var strings = new Array();
        var convCount = 0;
        var stringPosStart = 0;
        var stringPosEnd = 0;
        var matchPosEnd = 0;
        var newString = '';
        var match = null;

        while (match = exp.exec(string)) {
            if (match[9]) { convCount += 1; }

            stringPosStart = matchPosEnd;
            stringPosEnd = exp.lastIndex - match[0].length;
            strings[strings.length] = string.substring(stringPosStart, stringPosEnd);

            matchPosEnd = exp.lastIndex;
            matches[matches.length] = {
                match: match[0],
                left: match[3] ? true : false,
                sign: match[4] || '',
                pad: match[5] || ' ',
                min: match[6] || 0,
                precision: match[8],
                code: match[9] || '%',
                negative: parseInt(arguments[convCount]) < 0 ? true : false,
                argument: String(arguments[convCount])
            };
        }
        strings[strings.length] = string.substring(matchPosEnd);

        if (matches.length == 0) { return string; }
        if ((arguments.length - 1) < convCount) { return null; }

        var code = null;
        var match = null;
        var i = null;

        for (i=0; i<matches.length; i++) {

            if (matches[i].code == '%') { substitution = '%' }
            else if (matches[i].code == 'b') {
                matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(2));
                substitution = sprintfWrapper.convert(matches[i], true);
            }
            else if (matches[i].code == 'c') {
                matches[i].argument = String(String.fromCharCode(parseInt(Math.abs(parseInt(matches[i].argument)))));
                substitution = sprintfWrapper.convert(matches[i], true);
            }
            else if (matches[i].code == 'd') {
                matches[i].argument = String(Math.abs(parseInt(matches[i].argument)));
                substitution = sprintfWrapper.convert(matches[i]);
            }
            else if (matches[i].code == 'f') {
                matches[i].argument = String(Math.abs(parseFloat(matches[i].argument)).toFixed(matches[i].precision ? matches[i].precision : 6));
                substitution = sprintfWrapper.convert(matches[i]);
            }
            else if (matches[i].code == 'o') {
                matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(8));
                substitution = sprintfWrapper.convert(matches[i]);
            }
            else if (matches[i].code == 's') {
                matches[i].argument = matches[i].argument.substring(0, matches[i].precision ? matches[i].precision : matches[i].argument.length)
                substitution = sprintfWrapper.convert(matches[i], true);
            }
            else if (matches[i].code == 'x') {
                matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(16));
                substitution = sprintfWrapper.convert(matches[i]);
            }
            else if (matches[i].code == 'X') {
                matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(16));
                substitution = sprintfWrapper.convert(matches[i]).toUpperCase();
            }
            else {
                substitution = matches[i].match;
            }

            newString += strings[i];
            newString += substitution;

        }
        newString += strings[i];

        return newString;

    },

    convert : function(match, nosign){
        if (nosign) {
            match.sign = '';
        } else {
            match.sign = match.negative ? '-' : match.sign;
        }
        var l = match.min - match.argument.length + 1 - match.sign.length;
        var pad = new Array(l < 0 ? 0 : l).join(match.pad);
        if (!match.left) {
            if (match.pad == "0" || nosign) {
                return match.sign + pad + match.argument;
            } else {
                return pad + match.sign + match.argument;
            }
        } else {
            if (match.pad == "0" || nosign) {
                return match.sign + match.argument + pad.replace(/0/g, ' ');
            } else {
                return match.sign + match.argument + pad;
            }
        }
    }
}
var sprintf = sprintfWrapper.init;


function setInnerHTML(id, html)
{
	$('#'+id).html(html);
	return true;
}

/** PHP to JS --- Stolen ! */
function in_array (needle, haystack, argStrict)
{
	var key = '';
	var strict = !!argStrict;
	
	if (strict) {
		for (key in haystack) {
			if (haystack[key] === needle) {
				return true;
			}
		}
	} else {
		for (key in haystack) {
			if (haystack[key] == needle) {
				return true;
			}
		}
	}
	return false;
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

/* GDO Error / MSG */
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

/** BB **/
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

var GWF_BB_CODE_LANGS = undefined;
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
		var result = ajaxSync(GWF_WEB_ROOT+'index.php?mo=Admin&me=CodeLangs&ajax=true&key='+key);
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



/** trim **/
function trim(str, chars)
{
	return ltrim(rtrim(str, chars), chars);
}

function ltrim(str, chars)
{
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
function rtrim(str, chars)
{
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
/** end of trim **/


/** Position **/
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

/** String Prototype Bindings **/
String.prototype.startsWith = function(s) { return this.match(new RegExp('^'+s, 'i')) !== null; }
String.prototype.endsWith = function(s) { return this.match(new RegExp(s+'$', 'i')) !== null; }
String.prototype.contains = function(s) { return this.match(new RegExp(s, 'i')) !== null; }
String.prototype.substrUntil = function(s, d)
{
	var i = this.indexOf(s);
	if (i === -1) {
		return d;
	}
	return this.substring(0, i);
}
