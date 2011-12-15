function alLog(script, times, console_selector)
{
	this.speed = 1;
	this.script = script;
	this.times = times;
	this.id = console_selector;
	
	this.linecount = 0;
	this.pos = 0;
	this.e = $(this.id);
	
	if (this.e.length !== 1)
	{
		alert('Somethings horribly wrong.');
		return null;
	}
	
	this.increaseSpeed = function(by)
	{
		this.speed = clamp(this.speed+by, 1, 10000);
	};
	
	this.replay = function()
	{
		this.replayB();
	};
	
	this.replayB = function()
	{
		var time = parseFloat(this.times.substrUntil(" ", "0"));
		var chars = parseInt(this.times.substrFrom(" ", "0"));
		this.times = this.times.substrFrom("\n", '');

		var line = this.script.substrUntil("\n", '');
		this.script = this.script.substrFrom("\n", '');

		var append = '';
		
		for (var i=0; i < chars; i++)
		{
//			console.log(line.charCodeAt(i), line.charAt(i));
			var code = line.charCodeAt(i);
			if (!code)
			{
				append += "\n";
				break;
			}
			else switch (code)
			{
			case 0x07: // TAB
				break;
			case 0x08: // Backspace
				append = this.onAppend(append);
				var old = this.e.html();
				this.e.html(old.substr(0, old.length-1));
				break;
//			case 0x12:
//			case 0x13:
//				this.linecount++;
//				append += "\n";
//				break;
//			case 0x07:
//				var old = this.e.html();
//				this.e.html(old.substr(0, old.length-1));
//				break;
			default:
				append += line.charAt(i);
				break;
			}
		}
//		chars = i + 1;
//		this.script = line.substr(chars);
		
		append = this.onAppend(append);

		if ( (this.times !== '') || (this.script !== '') )
		{
			time = clamp(Math.round(1000*time/this.speed), 5, 1000);
			setTimeout(function(log){log.replayB();}, time, this);
		}
		else
		{
			this.e.append("\nThe script is over. Thank you for using sudosh2-skullified.\n");
		}
	};
	
	this.onAppend = function(append)
	{
		append = this.shellDecode(append.htmlspecialchars());
		console.log(append);
		this.e.append(append);
		return '';
	};
	
	this.shellDecode = function(s)
	{
		console.log(s);
		s = s.replace(']0;', '', 'g'); // START OF LINE / LINE 0
		s = s.replace('[?1034h', '', 'g'); // HEX?
		s = s.replace('~', '', 'g'); // ??
		s = s.replace('[1m', '</font>', 'g');
//		s = s.replace('[0;32m')
		s = s.replace('[1;30m', '<font color="gray">', 'g');
		s = s.replace('[0;32m', '<font color="green">', 'g');
		s = s.replace('[00;32m', '<font color="green">', 'g');
		s = s.replace('[01;31m', '<font color="red">', 'g');
		s = s.replace('[01;34m', '<font color="blue">', 'g');
		s = s.replace('[0;33m', '<font color="brown">', 'g');
		s = s.replace('[00m', '', 'g'); // ?? (start of input?)
		s = s.replace('[0m', '', 'g'); // ?? (tab?)
//		s = s.replace('[0m', '');
//		s = s.replace('[00', '');
//		s = s.replace(';32m',  '</font>');
//		s = s.replace('[0m', '</font>';
		return s;
	};
}

var al_log = null;

function alReplay()
{
	al_log = new alLog(al_script, al_times, '#al_replay');
	al_log.replay();
}

function alSpeedup()
{
	al_log.speedup();
}
