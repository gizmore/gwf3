function IRC()
{
	this.socket = undefined;
	
	this.connect = function()
	{

		this.socket = new WebSocket(sl4.server_url);
		
		this.socket.onopen = function()
		{
			irc.sendRaw(sprintf('XLIN %s %s', sl4.username, sl4.password));
		};
		
		this.socket.onclose = function()
		{
			$.mobile.changePage('#world_page', 'fade', true, true);
		};
		
		this.socket.onmessage = function(event)
		{
			sl4p.process(event.data);
		};
	};
	
	this.send = function(message)
	{
		this.sendRaw('PRIVMSG Dog :' + message);
	};

	this.sendRaw = function(message)
	{
		this.socket.send(message);
	};
}

var irc = new IRC();
