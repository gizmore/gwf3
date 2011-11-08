var GWF_BB_CODE_LANGS = undefined;

//function bbReplace(start, end)
//{
//	alert(start+end);
//	textarea = document.getElementById("bb_message");
//	alert(textarea);
//	return true;
//}

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
