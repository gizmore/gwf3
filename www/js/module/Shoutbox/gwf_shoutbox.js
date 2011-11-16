function gwfShout()
{
	var e = document.getElementById('gwf_shoutmsg');
	if (e === null) {
		alert('Can not find element with ID \'gwf_shoutmsg\'');
		return false;
	}
	
	var c = document.getElementById('captcha');
	if (c !== null) {
		c = '&captcha='+encodeURIComponent(c.value);
	} else {
		c = '';
	}
	
	var url = GWF_WEB_ROOT+'index.php?mo=Shoutbox&me=Shout&ajax=true';
	var data = 'message='+encodeURIComponent(e.value)+c;
	var response = ajaxSyncPost(url, data);
	
	if (gwfIsSuccess(response)) {
		gwfShoutRefresh();
	}
	else {
		gwfDisplayMessage(response);
	}
	
	return false;
}

function gwfShoutTimer()
{
}

function gwfShoutRefresh()
{
	var e = document.getElementById('gwf_shoutbox');
	if (e === null) {
		alert('Can not find element with ID \'gwf_shoutbox\'');
		return false;
	}
	
	var url = GWF_WEB_ROOT+"index.php?mo=Shoutbox&me=Ajax&ajax=true";
	var response = ajaxSync(url);
	
	e.innerHTML = response;
}
