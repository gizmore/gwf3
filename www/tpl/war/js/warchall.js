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
		//console.log(append);
		this.e.append(append);
		return '';
	};
	
	this.shellDecode = function(s)
	{
		var esc = String.fromCharCode(27);
		var out = '';
		var chain = false;
		
		//console.log(s);
		
		// escape sequences can be "chained", ie one escape character and then sequences with [
		for (var i=0; i<s.length; ++i) {
			if ((s.charAt(i) == esc && s.charAt(i+1) == '[') 
				|| (chain && s.charAt(i) == '[')) 
				{
				var seq = '';
				
				i += 2;
				var max=10;
				while (max-- && !s.charAt(i).match(/[HfABCDsuJKmh|p]/)) {
					seq += s.charAt(i);
					++i;
				}
				
				seq += s.charAt(i);
				//console.log('seq: ' + seq);
				
				/* ^[?1034h => VT52 escape code ??, 1 == set cursor to app, 
				 *  0 == reset?; 3 == 132 columns; 4 == smooth scrolling
				 */
				
				switch (seq.charAt(seq.length - 1)) {
					case 'H':		// cursor pos
					case 'f':		// cursor pos
					case 'A':		// cursor up
					case 'B':		// cursor down
					case 'C':		// cursor forward
					case 'D':		// cursor backward
					case 's':		// save cursor pos
					case 'u':		// restore cursor pos
						break;
						
					case 'J':		// 2J == erase display
					case 'K':		// erase line
						break;
					
					case 'm':		// color / graphic mode
						var codes = seq.substring(0, seq.length - 1).split(';');
						var style = '';
						
						if (seq == 'm' || seq == '0m' || seq == '00m')
							out += '</span>';	// all attributes off
						
						for (var j=0; j<codes.length; ++j) {
							switch (parseInt(codes[j])) {
								// text attributes
								case 1: style += 'font-weight:bold;'; break;
								case 4: style += 'text_decoration:underline;'; break;
								case 5: style += 'text_decoration:blink;'; break;
								case 7:		// reverse video on
								case 8:		// concealed on ??
									break;
									
								// foreground colors
								case 30: style += 'color:black;'; break;
								case 31: style += 'color:red;'; break;
								case 32: style += 'color:green;'; break;
								case 33: style += 'color:yellow;'; break;
								case 34: style += 'color:blue;'; break;
								case 35: style += 'color:magenta;'; break;
								case 36: style += 'color:cyan;'; break;
								case 37: style += 'color:white;'; break;
								
								// background colors
								case 40: style += 'background-color:black;'; break;
								case 41: style += 'background-color:red;'; break;
								case 42: style += 'background-color:green;'; break;
								case 43: style += 'background-color:yellow;'; break;
								case 44: style += 'background-color:blue;'; break;
								case 45: style += 'background-color:magenta;'; break;
								case 46: style += 'background-color:cyan;'; break;
								case 47: style += 'background-color:white;'; break;
							}
						}
						
						if (style.length > 0) 
							out += '<span style="' + style + '">';

						break;
						
					case 'h':		// set mode (screen mode), probably never used
					case '|':		// reset mode
					case 'p':		// set keyboard string
						break;
				}
				
				chain = true;
			} else {

				// if weird escape, drop it
				// TODO somehow remove that double-prompt afterwards also (I think this belongs to that weird escape sequence)
				if (s.substring(i, i+4) == (esc+']0;')) {
					i += 3;
				} else {
					chain = false;
					out += s.charAt(i);
				}
			}
		}
		
		return out;
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
