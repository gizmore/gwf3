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
function ajaxUpdate(id, url)
{
	$.ajax(url, {
		success: function(data)
		{
			$('#'+id).html(data);
		}
	});
}

function ajaxUpdateSync(id, url)
{
	var result = ajaxSync(url);
	if (result === false)
	{
		return false;
	}
	$('#'+id).html(result);
	return true;
}

function ajaxSync(url)
{
	var back = false;
	$.ajax(url, {
		async: false,
		success: function(data)
		{
			back = data;
		}
	});
	return back;
}

function ajaxSyncPost(url, data)
{
	var request = $.ajax({
		url: url,
		type: 'POST',
		async: false,
		data: data,
		dataType: 'html'
	});
	var back = false;
	request.done(function(result) { back = result; });
	return back;
}

/*=====================*/
/*= Selects and Options */
/*=====================*/
function getSelectOptions(selectID) { return document.getElementById(selectID).options; }
function getSelectedValue(selectID) { return getSelectedValueB(document.getElementById(selectID)); }
function getSelectedValueB(select) { return select.options[select.selectedIndex].value; }
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

function gwfMassToggler(toggler, selector)
{
	$(selector).each(function(){ this.checked = toggler.checked; });
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

/* String util */
String.prototype.ltrim = function(chars) { chars = chars || "\\s"; return this.replace(new RegExp("^[" + chars + "]+", "g"), ""); };
String.prototype.rtrim = function(chars) { chars = chars || "\\s"; return this.replace(new RegExp("[" + chars + "]+$", "g"), ""); };
String.prototype.trim = function(chars) { return this.rtrim(chars).ltrim(chars); };
String.prototype.startsWith = function(s) { return this.match(new RegExp('^'+s, 'i')) !== null; };
String.prototype.endsWith = function(s) { return this.match(new RegExp(s+'$', 'i')) !== null; };
String.prototype.contains = function(s) { return this.match(new RegExp(s, 'i')) !== null; };
String.prototype.substrFrom = function(s, d) { var i = this.indexOf(s); return i === -1 ? d : this.substr(i+s.length); };
String.prototype.substrUntil = function(s, d) { var i = this.indexOf(s); return i === -1 ? d : this.substring(0, i); };
String.prototype.nibbleUntil = function(s) { var r = this.substrUntil(s); if (r !== undefined) this.replace(this.substrFrom(s)); return r; };

/**
 * escape the three most dangerous html chars.
 * @author gizmore
 * @returns {String}
 */
String.prototype.htmlspecialchars = function()
{
	var back = '';
	var len = this.length, c=0, i;
	var rep = {34:'&#34;',60:'&#60;',62:'&#62;'};
	for (i = 0; i < len; i++)
	{
		c = this.charCodeAt(i);
		back += rep[c] === undefined ? this.charAt(i) : rep[c];
	}
	return back;
};



/*-========-*/
/* Ajax GDO */
/*-========-*/
function gwfIsSuccess(response)
{
	return response === false ? false : gwfNextToken(response, 0) > 0;
}

function gwfDisplayMessage(response)
{
	if (response === false)
	{
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
	if (index === -1)
	{
		alert('GWF Response Error 2');
		return '';
	}
	return response.substring(i, index);
}


/**
 * Select first editable input.
 * @param selector
 */
function focusInput(selector)
{
	alert('focusInput is broken!!!');
//	var jq = $(selector);
//	if (!jq.length)
//	{
//		jq = $('input[type=text]').sort('top', 'ASC');
//	}
//	jq[0].focus();
}

/**
 * GWF_Common::clamp() javascript port. 
 * @param num
 * @param min
 * @param max
 * @returns {Number}
 */
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

/** Implementation of "bind" for crappy browsers */
if (!Function.prototype.bind)
{
	Function.prototype.bind = function (oThis)
	{
		if (typeof this !== "function")
		{
			throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
		}

		var aArgs = Array.prototype.slice.call(arguments, 1), 
			fToBind = this, 
			fNOP = function () {},
			fBound = function () {
				return fToBind.apply(this instanceof fNOP && oThis ? this : oThis, aArgs.concat(Array.prototype.slice.call(arguments)));
			};
		fNOP.prototype = this.prototype;
		fBound.prototype = new fNOP();

		return fBound;
	};
}

$.fn.onEnterKey = function(closure)
{
	$(this).keypress(function(event) {
		var code = event.keyCode ? event.keyCode : event.which;
		if (code === 13)
		{
			closure();
			return false;
		}
	});
};
