var sl4PID = 0;
var sl4WORDS = undefined;
var sl4ITEM_FRIEND = undefined;
var sl4ITEM_FOE = undefined;

function sl4Init(pid)
{
	sl4PID = pid;
	$('#sl4_inventory div').click(function(){sl4ClickItem(this.innerHTML);});
	$('#sl4_equipment div').click(function(){sl4ClickItem(this.innerHTML);});
	$('#sl4_cyberware div').click(function(){sl4ClickItem(this.innerHTML);});
	$('#sl4_party div').click(function(){sl4ClickPlayer(this.innerHTML);});
	$('#sl4_cmdbar div').click(function(){sl4ClickCommand(this.innerHTML);});
	setTimeout(sl4PeekMessages, 1000);
}

function sl4ClickItem(item)
{
	item = item.substrUntil('(', item);
	var content = ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=item&item='+item);
	var item = $('#sl4_item');
	item.html(content);
}

function sl4ClickCommand(cmd)
{
	switch (cmd)
	{
	case 'exp':
	case 'sleep':
	case 'bye':
	case 'exit':
	case 'view':
	case 'look':
		return sl4SendCommand(cmd);

	case 'g': return sl4ClickGoto();
	
	default:
		if (cmd.startsWith('t') || cmd==='say') {
			return sl4ClickTalk(cmd);
		}
		alert(cmd); 
	}
	return false;
}

function sl4ClickTalk(cmd)
{
	$('#sl4_talkbox').html(sl4GetKWBar(cmd)+'<div><form onsubmit="return sl4TalkB(\''+cmd+'\');"><input type="text" id="sl4_talktext" name="sl4_talktext" /><input type="submit" name="sl4_talkbtn");" /></form></div>');
}

function sl4GetKWBar(cmd)
{
	if (sl4WORDS === undefined) {
		sl4RefreshWords();
	}
	var back = '<div id="sl4_knownwords">';
	
	var len = sl4WORDS.length;
	for (var i = 0; i < len; i++)
	{
		var word = sl4WORDS[i];
		back += '<span onclick="return sl4SendCommand(\''+cmd+' '+word+'\');">'+word+'</span>';
	}
	
	back += '<span onclick="$(\'#sl4_talkbox\').html(\'\');">[x]</span>';
	
	back += '</div>';
	return back;
}

function sl4TalkB(cmd)
{
	sl4SendCommand(cmd+' '+$('#sl4_talktext').val());
	$('#sl4_talkbox').html('');
	return false;
}

function sl4ClickGoto()
{
	
}

function sl4UseItem(name, friend, enemy, consume)
{
	if (consume) {
		return sl4SendCommand('use '+name);
	}
	if (friend) {
		sl4ITEM_FRIEND = name;
	}
	if (enemy) {
		sl4ITEM_FOE = name;
	}
	
	if (friend && enemy) {
		alert('Please click a party member or an enemy now.');
	}
	else if (friend) {
		alert('Please click a party member now.');
	}
	else if (enemy) {
		alert('Please click an enemy now.');
	}
}

function sl4ClickLocation(location)
{
	return sl4SendCommand('g '+location);
}

function sl4ClickFriend(id)
{
	if (sl4ITEM_FRIEND !== undefined) {
		var item = sl4ITEM_FRIEND;
		sl4ITEM_FRIEND = undefined;
		return sl4SendCommand('use '+item+' '+id);
	}
}

function sl4ClickEnemy(id)
{
	if (sl4ITEM_FOE !== undefined) {
		var item = sl4ITEM_FOE;
		sl4ITEM_FOE = undefined;
		return sl4SendCommand('use '+item+' '+id);
	}
	else {
		return sl4SendCommand('attack '+id);
	}
}

function sl4SwitchAccount(pid)
{
	window.location = GWF_WEB_ROOT+'index.php?mo=Lamb&me=Client&pid='+pid;
}

function sl4ClearMessages()
{
	$("#sl4_messages").html("Messages cleared.\n");
	return false;
}

function sl4SendCommand(command)
{
	sl4OutputMessage(command);
	var result = ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=send&send='+encodeURIComponent(command));
}

function sl4PeekMessages()
{
	var result = ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&ajax=true&me=Ajax&cmd=peek');
	var data = eval('('+result+');');
	var len = data.length;
	for (var i = 0; i < len; i++)
	{
		sl4OutputMessage(sl4FilterMessage(data[i].lif_message, data[i].lif_options));
		sl4Refresh(data[i].lif_options);
	}
	setTimeout(sl4PeekMessages, 1000);
}

function sl4FilterMessage(message, options)
{
	if (options&0x2000) { return sl4FilterItems(message); }
	if (options&0x4000) { return sl4FilterPlayers(message); }
	return message;
}

function sl4FilterItems(message)
{
	var pattern = new RegExp('\\d+-([^\\(]+)', 'gi');
	return message.replace(pattern, '<a onclick="return sl4ClickStoreItem(\'$1\');">$1</a>');
}

function sl4ClickStoreItem(itemname)
{
	$('#sl4_sitem').html(ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&ajax=true&me=Ajax&cmd=sitem&item='+encodeURIComponent(itemname)));
	return false;
}

function sl4FilterPlayers(message)
{
	return message;
}

function sl4OutputMessage(message)
{
	var box = $("#sl4_messages");
	box.html(box.html()+message+"\n");
}

function sl4Refresh(options)
{
	if (options&0x20) { sl4RefreshInventory(); }
	if (options&0x40) { sl4RefreshCommands(); }
	if (options&0x80) { sl4RefreshStats(); }
	if (options&0x100) { sl4RefreshEquipment(); }
	if (options&0x200) { sl4RefreshParty(); }
	if (options&0x400) { sl4RefreshLocations(); }
	if (options&0x800) { sl4RefreshCyberware(); }
	if (options&0x1000) { sl4RefreshWords(); }
}

function sl4RefreshInventory()
{
	$('#sl4_inventory').html(ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=i'));
	$('#sl4_inventory div').click(function(){sl4ClickItem(this.innerHTML);});
}

function sl4RefreshCommands()
{
	$('#sl4_cmdbar').html(ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=c'));
}

function sl4RefreshStats()
{
	$('#sl4_stats').html(ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=s'));
}

function sl4RefreshEquipment()
{
	$('#sl4_equipment').html(ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=q'));
	$('#sl4_equipment div').click(function(){sl4ClickItem(this.innerHTML);});
}

function sl4RefreshParty()
{
	$('#sl4_party').html(ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=p'));
	$('#sl4_party div').click(function(){sl4ClickPlayer(this.innerHTML);});
}

function sl4RefreshLocations()
{
	$('#sl4_locations').html(ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=kp'));
}

function sl4RefreshCyberware()
{
	$('#sl4_cyberware').html(ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=cy'));
	$('#sl4_cyberware div').click(function(){sl4ClickItem(this.innerHTML);});
}

function sl4RefreshWords()
{
	var result = ajaxSync(GWF_WEB_ROOT+'index.php?mo=Lamb&me=Ajax&ajax=true&cmd=kw');
	sl4WORDS = eval('('+result+');');
}