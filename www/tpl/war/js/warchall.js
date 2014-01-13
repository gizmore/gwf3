function alLog(script, times, console_selector) {
	this.speed = 1;
	this.script = script;
	this.times = times;
	this.id = console_selector;
	
	this.pos = 0;		// save cursor pos to show cursor
	this.e = $(this.id);
	
	if (this.e.length !== 1) {
		alert('Somethings horribly wrong.');
		return null;
	}
	
	this.increaseSpeed = function(by) {
		this.speed = clamp(this.speed+by, 1, 10000);
	};
	
	this.changeSpeed = function(to) {
		this.speed = clamp(to, 1, 10000);
	};
	
	this.replay = function() {
		this.replayB();
	};
	
	this.replayB = function() {
		var time = parseFloat(this.times.substrUntil(" ", "0"));
		var chars = parseInt(this.times.substrFrom(" ", "0"));
		this.times = this.times.substrFrom("\n", '');

		var line = this.script.substrUntil("\n", '');
		this.script = this.script.substrFrom("\n", '');

		var append = '';
		
		for (var i=0; i < chars; ++i) {
			var code = line.charCodeAt(i);
			
			if (!code) {
				append += "\n";
				break;
			} else {
				switch (code) {
					case 0x07: // TAB
						break;
					case 0x08: // Backspace
						append = this.onAppend(append);
						var old = this.e.html();
						this.e.html(old.substr(0, old.length-1));
						break;
					default:
						append += line.charAt(i);
						break;
				}
			}
		}
//		chars = i + 1;
//		this.script = line.substr(chars);
		
		this.onAppend(append);

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
	
	this.onAppend = function(append) {
		append = this.shellDecode(append.htmlspecialchars());
		//console.log(append);
		this.e.append(append);
		
		if ($('#autoscroll').attr('checked') != undefined) {
			this.e.scrollTop(this.e.prop('scrollHeight') + 1);
		}
		return '';
	};
	
	this.shellDecode = function(s) {
		var esc = String.fromCharCode(27);
		var state = 'normal';
		var values = new Array();
		var val = '';
		var out = '';
		
		for (var i=0; i<s.length; ++i) {
			var c = s.charAt(i);
			
			//console.log('state: ' + state);
			
			switch (state) {
				case 'normal':
					if (c == esc) {
						state = 'escape';
						val = '';
					} else
						out += c;
					break;
					
				case 'escape':
					switch (c) {
						case '[':
							state = 'ansi';
							break;
						
						case ']':
							state = 'weird_escape';
							break;
						
						case '(':
						case ')':	//would change character sets, ignore next char
							state = 'charset';
							break;
						
						
						case '&':	// '>' == change keypad mode, but is htmlencoded
							state = 'keypad_mode';
							break;
							
						
						default:	// ignore all unknown sequences
							state = 'normal';
							break;
							
					}
					break;
					
				case 'charset':
					state = 'normal';
					break;
				
				case 'keypad_mode':
					// eat whole htmlentity
					if (c == ';')
						state = 'normal';
					break;
				
				case 'screenmode':
					if (c.charCodeAt(0) >= 48 && c.charCodeAt(0) <= 57) {
						// we have a digit
						val += c;
					} else {
						
						switch (c) {
							case 'h':
								for (var j=0; j<val.length; ++j) {
									switch (val.charAt(j)) {
										case '1': // set cursor key to app
										case '3': // set um of columns to 132
										case '4': // set smooth scrolling
										case '5': // set reverse video
										case '6': // set origin to relative
										case '7': // set auto-wrapmode
										case '8': // set auto-rpeat mode
										case '9': // set auto-interlacing mode
									}
								}
								val = '';
								state = 'normal';
								break;
							
							case 'l':
								// ensure new line after screen mode reset
								out += "\n";
								val = '';
								state = 'normal';
								break;
						}
					}
					break;
					
				case 'lettermode':
					if (c.charCodeAt(0) >= 48 && c.charCodeAt(0) <= 57) {
						// ignore ...
					} else {
						--i;
						state = 'normal';
					}
					break;
				
				case 'weird_escape':
					// eat all chars until next escape ?
					if (c == esc)
						state = 'escape';
					break;
				
				case 'ansi':
					if (c.charCodeAt(0) >= 48 && c.charCodeAt(0) <= 57) {
						// we have a digit
						val += c;
						state = 'ansi_value';
					} else {
						switch (c) {
							case 'm':
								out += '</span>';
								state = 'normal';	
								break;
							
							case '?':
								state = 'screenmode';
								break;
							
							case '#':
								state = 'lettermode';
								break;
							
							case 's':	// save cursor pos
							case 'u': 	// restore cursor pos
							case 'K': 	// erase line
							
							default:
								state = 'normal';
						}
						
						
					}
					
					break;
					
				case 'ansi_value':
					if (c.charCodeAt(0) >= 48 && c.charCodeAt(0) <= 57) {
						val += c;
					} else {
						values.push(val);
						val = '';
						
						if (c != ';') {
							--i;
							state = 'ansi_with_value';
						}
					}
					break;
					
				case 'ansi_with_value':
					// we are at the last (command) char and have values
					switch (c) {
						case '@':
							// strip [1@#
							++i;
							break;
						
						case 'H': // move cursor to x,y
							// vim workaround, vim moves cursor to next line with [<line>,1H
							if (values.length > 1 && values[1] == '1')	
								out += "\n";
							break;
						
						case 'm':	// set graphics mode
							var style = '';
						
							while (values.length) {
								var mode = parseInt(values.shift());
								
								switch (mode) {
									case 0: out += '</span>'; break;	// all attributes off
									
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
					}
					
					state = 'normal';
					break;
			}
		}
		
		return out;
	}
	
}

var al_log = null;

function alReplay() {
	al_log = new alLog(al_script, al_times, '#al_replay');
	al_log.replay();
}

