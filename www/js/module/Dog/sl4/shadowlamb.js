function Shadowlamb()
{
	this.username = null;
	this.password = null;
	this.server_url = 'ws://irc.giz.org:31337';
	
	this.commands = [];
	
	this.onLogin = function()
	{
		this.username = $('#username').val();
		this.password = $('#password').val();
		
		this.ajaxCall('sl4login.php', {username: this.username, password: this.password}, this.onLoggedIn, this.onLoginFail);
		
		irc.connect();
	};
	
	this.chooseWorld = function(url)
	{
		this.server_url = url;
		$.mobile.changePage('#login_page', 'slide', true, true);
	};
	
	this.send = function()
	{
		var message = $('#chat_input').val();
		if (message !== '')
		{
			irc.send(message);
		}
	};
	
	this.ajaxCall = function(cmd, data, cb_success, cb_error)
	{
//		$.ajax({
//		});
	};
	
	this.exec = function(cmd)
	{
		irc.send(cmd);
	};
	
	this.error = function(title, message)
	{
		$('#error_title').text(title);
		$('#error_message').text(message);
		$.mobile.changePage('#error_dialog', 'pop', true, true);
	};
	
	this.showScreen = function(id)
	{
		$('#screen_tabs ul').hide();
		$('#'+id).show();
	};
	
	this.addCommand = function(cmd)
	{
		
		
//		if ( $('#cmd_'+cmd)  )
//		{
//			return true;
//		}
		
		
	};
	
	this.removeCommand = function(cmd)
	{
		
	};
	
}

if ( (window.location.hash) && (window.location.hash !== '#world_page') )
{
	window.location.href = '/index.php?mo=Dog&me=Shadowclient';
}
else
{
	var sl4 = new Shadowlamb();
}
