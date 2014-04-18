function SL4Handlers()
{
	this.handlers = {
		5042: function(message)
		{
			var cmds = message.split(',');
			for (i in cmds)
			{
				sl4.addCommand(cmds[i]);
			}
		},
	    9000: function(message)
	    {
	    	console.log('HOE!');
	    },
	    0000: function(message)
	    {
	    	console.log('HA!');
	    }
	};
	
	this.handle = function(code, message)
	{
		if (this.handlers[code] === undefined)
		{
			return false;
		}
		else
		{
			this.handlers[code](message);
			return true;
		}
	};
}
var sl4h = new SL4Handlers();


function SL4Process()
{
	this.process = function(message)
	{
		if (message === 'XLIN1')
		{
			return this.doStartup();
		}
		else if (message.startsWith('XLIN'))
		{
			return false;
		}
		
		var code = message.substrUntil(':');
		
		code = parseInt(code);
		
		if (code > 0)
		{
			this.processCode(code, message.substrFrom(':'));
		}
		else
		{
			console.log(message);
		}
		
		$('#chat').prepend(sprintf('<li>%s</li>', this.outputMessage(message))).listview('refresh').trigger('create');
	};
	
	this.processCode = function(code, message)
	{
		sl4h.handle(code, message);
	};
	
	this.outputMessage = function(message)
	{
		return message;
		
	};
	
	this.doStartup = function()
	{
		$.mobile.changePage('#main_page', 'fade', true, true);
		irc.send('#inventory');
		irc.send('#commands');
	}
}

var sl4p = new SL4Process();