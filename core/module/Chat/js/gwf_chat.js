/** Public vars :/ */
var gwfchat_timestamp = 0;
var gwfchat_maxmsg_pub = 1;
var gwfchat_maxmsg_priv = 1;
var gwfchat_times_pub = new Array();
var gwfchat_times_priv = new Array();
var gwfchat_online = new Array();
var gwfchat_nickname = '';
var gwfchat_onlinetime = 0;
var gwfchat_t_pub = null;
var gwfchat_t_priv = null;
var gwfchat_lag = 3050;

/** Init */
function gwfchatInitLaggy(max_pub, max_priv, nickname, onlinetime, onlinelist, lagtime)
{
//	alert('You don`t have gecko browser. Get Firefox!')
	gwfchatInitCommon(max_pub, max_priv, nickname, onlinetime, onlinelist);
	gwfchat_lag = lagtime * 1000 + 50;
	setTimeout(sprintf('gwfchatRefreshLaggy();'), gwfchat_lag);
}

function gwfchatInit(max_pub, max_priv, nickname, onlinetime, onlinelist)
{
//	alert('You have boosty Gecko engine! Firefox owns!')
	gwfchatInitCommon(max_pub, max_priv, nickname, onlinetime, onlinelist);
	gwfchatInitOnlineRequest();
}

function gwfchatInitCommon(max_pub, max_priv, nickname, onlinetime, onlinelist)
{
	gwfchat_maxmsg_pub = max_pub;
	gwfchat_maxmsg_priv = max_priv;
	gwfchat_nickname = nickname;
	gwfchat_onlinetime = onlinetime;
	gwfchat_online = onlinelist;
	
	gwfchatDisplayOnlineList();
	
	gwfchatInitFocus();
	
	gwfchatInitButtons();
	
	gwfchat_t_priv = document.getElementById('gwfchat_privmsg');
	if (gwfchat_t_priv === null) {
//		alert("Can not find ID: gwfchat_privmsg!");
//		return;
	}
	gwfchat_t_pub = document.getElementById('gwfchat_pubmsg');
	if (gwfchat_t_pub === null) {
//		alert("Can not find ID: gwfchat_pubmsg!");
//		return;
	}
}

function gwfchatInitFocus()
{
	var e = document.getElementsByName('yournick');
	if (e.length === 0) {
		e = document.getElementsByName('message');
	}
	
	if (e.length === 1) {
		e[0].focus();
	}
}

function gwfchatInitButtons()
{
	var e = document.getElementsByName('post');
	if (e === null) {
		return;
	}
	if (e.length !== 1) {
		return;
	}
	e[0].onclick = function(){ return gwfchatPost(); };
}

function gwfchatInitPub(pubtimes)
{
	gwfchat_times_pub = pubtimes;
}

function gwfchatInitPriv(privtimes)
{
	gwfchat_times_priv = privtimes;
}

/** STREAMING */
function gwfchatInitOnlineRequest()
{
	var ajax = getAjaxObject();
	var url = 'gwf_chat.php';
	ajax.multipart = true;
	ajax.open("GET", url, true);
	ajax.onload = function() { gwfchatOnlineMsg(ajax); };
	ajax.send('');
}

function gwfchatOnlineMsg(ajax)
{
	var response = ajax.responseText;
	
	if (response === '') {
		return;
	}
	
	var lines = response.split("\n");
	for (i in lines)
	{
		gwfchatOnlineMsgB(lines[i]);
	}
}

function gwfchatOnlineMsgB(line)
{
	if (line === '') {
		return;
	}
	
	var cmd = line.substr(0, 1);
	var msg = line.substr(1);
	
	if (cmd === '+') {
		gwfchatOnlineMsgJoin(msg);
	} else if (cmd === '-') {
		gwfchatOnlineMsgPart(msg);
	} else if (cmd === 'C') {
		gwfchatOnlineMsgPublic(msg);
	} else if (cmd === 'P') {
		gwfchatOnlineMsgPrivate(msg);
	}
	
	gwfchat_times_pub = gwfchatRemoveFromTable(gwfchat_t_pub, gwfchat_times_pub, gwfchat_maxmsg_pub);
	gwfchat_times_priv = gwfchatRemoveFromTable(gwfchat_t_priv, gwfchat_times_priv, gwfchat_maxmsg_priv);
}
function gwfchatDisplayOnlineList()
{
	var e = document.getElementById('gwfchat_online');
	if (e === null) {
//		alert("Can not find ID gwfchat_online.");
		return;
	}
	e.innerHTML = '';
	for (i in gwfchat_online)
	{
		if (gwfchat_online[i].substr(0, 2) === 'U#') {
			e.innerHTML += sprintf('<div>%s</div>', gwfchat_online[i]);
		}
		else {
			e.innerHTML += sprintf('<div><a href="#" onclick="return gwfchatSetTarget(\'%s\');" >%s</a></div>', gwfchat_online[i], gwfchat_online[i]);
		}
	}
}
function gwfchatOnlineMsgJoin(nickname)
{
	if (in_array(nickname, gwfchat_online, true)) {
		return;
	}
	gwfchatPubMessage(''+nickname+' joined the channel.');
	gwfchat_online[gwfchat_online.length] = nickname;
	gwfchat_online.sort(gwfchatOnlineSort);
	gwfchatDisplayOnlineList();
}
function gwfchatOnlineSort(a, b)
{
	var ia = a.substr(1, 2) === '#';
	var ib = b.substr(1, 2) === '#';
	if (ia === ib) {
		return a < b ? -1 : 1;
	}
	else if (ia) {
		return 1;
	}
	else if (ib) {
		return -1;
	}
}

function gwfchatOnlineMsgPart(nickname)
{
	gwfchatPubMessage(''+nickname+' left the channel.');

	var newArray = new Array();
	var j = 0;
	for (i in gwfchat_online)
	{
		if (gwfchat_online[i] !== nickname)
		{
			newArray[j++] = gwfchat_online[i];
		}
	}
	gwfchat_online = newArray;
	gwfchatDisplayOnlineList();
}
function gwfchatOnlineMsgPublic(message)
{
	gwfchatRefreshPubB(gwfchat_t_pub, message);
}
function gwfchatOnlineMsgPrivate(message)
{
	gwfchatRefreshPrivB(gwfchat_t_priv, message);
}
/** END OF STREAMING */

/** POSTING */	
function gwfchatPost()
{
	var message = gwfchatGetPostMessage();
	var target = gwfchatGetPostTarget();
	var nickname = gwfchatGetPostNickname();
	
	var ajax = getAjaxObject();
//	var url = 'index.php?mo=Chat&me=Ajax&ajax=true&nickname='+escape(nickname)+'&postto='+escape(target)+'&message='+escape(message);
	var url = 'index.php?mo=Chat&me=Ajax&ajax=true&nickname='+encodeURIComponent(nickname)+'&postto='+encodeURIComponent(target)+'&message='+encodeURIComponent(message);
	var response = ajaxSync(url);
	gwfchatOnPostedB(response);
	return false;
}

function gwfchatOnPostedB(response)
{
	if (response !== '1') {
		alert(response);
	}
	else {
		var e = gwfchatGetEleByName('yournick');
		if (e !== null) {
			e.disabled = true;
		}
		if (gwfchat_nickname === '') {
			gwfchat_nickname = 'G#'+gwfchatGetInputValue('yournick');
			e.value = gwfchat_nickname;
		}
		
		e = gwfchatGetEleByName('message');
		if (e !== null) {
			e.value = '';
		}
		else {
			alert('NO message input field in form');
		}
	}
}
/** END OF POSTING */

/** Convinient */
function gwfchatGetInputValue(ename)
{
	var e = gwfchatGetEleByName(ename);
	if (e === null) {
		return 'ERR '+ename+'!';
	}
	return e.value;
}

function gwfchatGetEleByName(ename)
{
	var e = document.getElementsByName(ename);
	if ((e === null) || (e.length !== 1)) {
		return null;
	}
	return e[0];
}

function gwfchatGetPostMessage()
{
	return gwfchatGetInputValue('message');
}

function gwfchatGetPostTarget()
{
	return gwfchatGetInputValue('target');
}

function gwfchatGetPostNickname()
{
	if (gwfchat_nickname === '') {
		return gwfchatGetInputValue('yournick');
	}
	return gwfchat_nickname;
}

function gwfchatSetTarget(target)
{
	var e = document.getElementsByName('target');
	
	var len = e.length;
	for (var i = 0; i < len; i++)
	{
		e[i].value = target;
	}
}
/** END OF CONVINIENT */

/** Messages */
function gwfchatPubMessage(message)
{
	var time = Math.abs(new Date().getTime() / 1000);
	var msglen = message.length;
	message = time+":FROM:TO:"+msglen+":"+message;
	gwfchatRefreshPubB(gwfchat_t_pub, message);
}

function gwfchatRefreshPrivB(table, message)
{
	var cols = gwfchatExplodeMsg(message);
	if (cols === false) {
		alert('CRAP ERROR 1');
		return;
	}
	if (cols.length !== 5) {
		alert('CRAP ERROR 2');
		return;
	}

	var timestamp = cols[0];
	var from = cols[1];
	var to = cols[2];
	var msglen = cols[3];
	var msg = cols[4];
//	for (var j = 4; j < cols.length; j++)
//	{
//		msg += "::" + cols[j];
//	}

	var timelen = gwfchat_times_priv.length;
	gwfchat_times_priv[timelen++] = timestamp;
	gwfchatAppendToTable(table, from, to, msg);
}

function gwfchatExplodeMsg(message)
{
	var back = new Array();
	
	var j = 0;
	var cur = 0;
	for (var i = 0; i < 4; i++)
	{
		var pos = message.indexOf(':', cur);
		if (pos === -1) {
			return false;
		}
		back[j++] = message.substring(cur, pos);
//		alert(back[j-1]);
		cur = pos+1;
	}
	
	if (back[3] <= 0) {
		alert('CRAP ERROR 3');
	}
	
	back[j] = message.substr(cur, back[3]);
//	alert(back[j]);
	return back;
}

function gwfchatRefreshPubB(table, message)
{
	var cols = gwfchatExplodeMsg(message);
	if (cols === false) {
		alert('CRAP ERROR 1');
		return;
	}
	if (cols.length !== 5) {
		alert('CRAP ERROR 2');
		return;
	}

	var timestamp = cols[0];
	var from = cols[1];
	var to = cols[2];
	var msglen = cols[3];
	var msg = cols[4];
//	for (var j = 0; j < cols.length; j++)
//	{
//		msg += ":" + cols[j];
//	}

	var timelen = gwfchat_times_pub.length;
	gwfchat_times_pub[timelen++] = timestamp;
	
	gwfchatAppendToTable(table, from, to, msg);
}

function gwfchatRemoveFromTable(table, chat_times, minlen)
{
	var oldLen = chat_times.length;
	if (oldLen <= minlen) {
		return chat_times;
	}
	
	var cut = Math.floor(new Date().getTime() / 1000) - gwfchat_onlinetime;
	var cutStart = 0;
	for (var i = 0; i < oldLen; i++)
	{
		if (chat_times[i] < cut) {
			cutStart = i;
		}
		else {
			break;
		}
	}
	
	if ((oldLen - cutStart) < minlen) {
		cutStart = oldLen - minlen;
	}
	
	var newTimes = new Array();
	var l = 0;
	for (var k = cutStart; k < oldLen; k++)
	{
		newTimes[l++] = chat_times[k];
	}
	
	var tBody = table.tBodies[0];
//	var rows = tBody.rows;
	for (var j = 0; j < cutStart; j++)
	{
//		rows.removeChild(rows[j]);
		tBody.deleteRow(0);
	}
	
	return newTimes;
}

function gwfchatAppendToTable(table, from, to, msg)
{
	var tBody = table.tBodies[0];
	var rows = tBody.rows;
	var nRows = rows.length;
	
	
	if (tBody === null) {
		alert('Table has no body!');
		return false;
		tBody = table;
	}
	
	var newRow = document.createElement('tr');
	
	var dateCell = document.createElement('td');
	dateCell.innerHTML = 'NEW!';
	newRow.appendChild(dateCell);
	
	var fromCell = document.createElement('td');
	fromCell.innerHTML = gfwchatNameLink(from);
	newRow.appendChild(fromCell);
	
	var toCell = document.createElement('td');
	toCell.innerHTML = gfwchatNameLink(to);
	newRow.appendChild(toCell);
	
	var msgCell = document.createElement('td');
	msgCell.innerHTML = msg;
	newRow.appendChild(msgCell);
	
	tBody.appendChild(newRow);
	
//	var newRow = tBody.insertRow(nRows);
	
//	var newRow = table.insertRow(nRows);
//	var cell = 0;
//	
//	var dateCell = newRow.insertCell(cell++);
//	dateCell.innerHTML = 'New!';
//	
//	var fromCell = newRow.insertCell(cell++);
//	fromCell.innerHTML = gfwchatNameLink(from);
//	
//	var toCell = newRow.insertCell(cell++);
//	toCell.innerHTML = gfwchatNameLink(to);
//	
//	var msgCell = newRow.insertCell(cell++);
//	msgCell.innerHTML = msg;
}

function gfwchatNameLink(nick)
{
	if (nick.substr(0, 2) === 'U#') {
		return nick;
	}
	else {
		return sprintf('<a href="#" onclick="return gwfchatSetTarget(\'%s\');">%s</a>', nick, nick);
	}
}
/** END OF Messages */


/** UNUSED 
function shoutboxUpdateB(response)
{
	var res = response.split('::');
	shoutboxLastID = res[0];
	var shoutbox = document.getElementById('shoutboxtable');
	var rows = shoutbox.rows;
	var nRows = rows.length;
	var tbody = shoutbox.tBodies[0];
	
	var newRow = tbody.insertRow(nRows-2);
	newRow.className = 'shout_'+res[3];
	
	var dateCell = newRow.insertCell(0);
	dateCell.align = 'right';
	dateCell.innerHTML = res[1]+'<br/>'+res[2];

	var msgCell = newRow.insertCell(1);
	msgCell.innerHTML = res[4];
	
	shoutboxUpdate(false, false);
}
*/


/** Laggy **/
function gwfchatRefreshLaggy()
{
	var ajax = getAjaxObject();
	var url = 'index.php?mo=Chat&me=Ajax&ajax=true&browser=laggy';
	ajax.open("GET", url, true);
	ajax.onreadystatechange = function ()
	{
		if (ajax.readyState == 4)
		{
			gwfchatOnlineMsg(ajax);
			setTimeout(sprintf('gwfchatRefreshLaggy();'), gwfchat_lag);
		}
	};
	ajax.send(null);
	return true;

}

/** END OF Laggy **/
