<?php
enum Direction {
	case IN;
	case OUT;
}

/**
 * IRC Message parsed from socket input, or constructed from message to send.
 * @author gizmore, tehron
 * @version 4.1
 */
final class Dog_IRCMsg
{
	private $raw, $direction, $prefix, $command, $args;

	public function getRaw() { return $this->raw; }
	public function getDirection() { return $this->direction; }
	public function getPrefix() { return $this->prefix; }
	public function getFrom() { return Common::substrUntil($this->getPrefix(), '!'); }
	public function getCommand() { return $this->command; }
	public function getArgs() { return $this->args; }
	public function getArgc() { return count($this->args); }
	public function getArg($n) { return $this->args[$n]; }
	
	public function shouldLog()
	{
		return strpos($this->raw, '.login') === false && strpos($this->raw, '.register') === false;
	}
	
	public function __construct($message, $prefix=null)
	{
		$this->raw = $message;

		if ($prefix !== null) {
			$this->direction = Direction::OUT;
			$message = ':' . $prefix . ' ' . $message;
		} else {
			$this->direction = Direction::IN;
		}

		# https://stackoverflow.com/a/930706
		$this->prefix = '';
		$trailing = array();
		
		if (strlen($message) === 0) {
			throw new Exception('Bad Message: empty line.');
		}

		if ($message[0] === ':') {
			list($this->prefix, $message) = explode(' ', substr($message, 1), 2);
		}
		
		if (strstr($message, ' :') !== false) {
			list($message, $trailing) = explode(' :', $message, 2);
			$this->args = preg_split("/\s+/", $message);
			array_push($this->args, $trailing);
		} else {
			$this->args = preg_split("/\s+/", $message);
		}

		$this->command = array_shift($this->args);
	}
	
	private static function isChannel($target) {
		return strlen($target) > 0 && in_array($target[0], str_split('#&+!'));
	}
	
	private static function stripirc($s) {
		$s = preg_replace('/\x0f|\x02|\x1d|\x1f\x16/', '', $s);
		$s = preg_replace('/\x03(?:(?:\d{2})(?:,(?:\d{2}))?)?/', '', $s);
		return $s;
	}
	
	private static function getConsoleColor($ircColor) {
		switch (intval($ircColor)) {
			case  0: return 37;
			case  1: return 30;
			case  3: return 32;
			case  4: case 5: return 31;
			case  8: return 33;
			case 11: return 36;
			case 12: return 34;
			case 13: return 35;
			default: return null;
		}
	}
	
	private static function parseColors($chars, &$idx, &$colors) {
		$matches = array();
		$s = '';
		for ($i = 1; $i < 6; ++$i) {
			if ($idx + $i >= count($chars)) {
				break;
			}
			$s .= $chars[$idx + $i];
		}
		if (preg_match('/(\d{1,2})(?:,(\d{1,2}))?/', $s, $matches) !== 1) {
			$colors = '';
			return;
		}
		
		$fg = Dog_IRCMsg::getConsoleColor($matches[1]);
		$bg = null;
		if (count($matches) == 3) {
			$bg = Dog_IRCMsg::getConsoleColor($matches[2]);
			
			if ($fg !== null && $bg !== null) {
				$bg += 10;
				$colors = "$fg;$bg";
			}
		} else {
			if ($fg !== null) {
				$colors = "$fg";
			}
		}
		
		$idx += strlen($matches[0]);
	}
	
	private static function irc2ansi($s) {
		$chars = mb_str_split($s);
		$arr = array();

		$bold = 1;
		$italic = 2;
		$underlined = 4;
		$reversed = 8;
		$color = 16;
		$mode = 0;
		$colors = '';
		
		for ($i = 0; $i < count($chars); ++$i) {
			if (in_array($chars[$i], array("\x0f", "\x02", "\x1d", "\x1f", "\x16", "\x03"))) {
				switch ($chars[$i]) {
					case "\x0f": $mode = 0; break;
					case "\x02": $mode ^= $bold; break;
					case "\x1d": $mode ^= $italic; break;
					case "\x1f": $mode ^= $underlined; break;
					case "\x16": $mode ^= $reversed; break;
					case "\x03": $mode ^= $color; break;
				}
				
				if ($chars[$i] === "\x03" && $mode & $color) {
					Dog_IRCMsg::parseColors($chars, $i, $colors);
				}

				$mode_arr = array('0');
				foreach (array($bold => '1', $italic => '3', $underlined => '4', $reversed => '7', $color => $colors) as $k => $v) {
					if ($mode & $k && $v !== '') {						
						array_push($mode_arr, $v);
					}
				}
				$v = "\x1b[" . implode(';', $mode_arr) . 'm';
				array_push($arr, $v);
			} else {
				array_push($arr, $chars[$i]);
			}
		}
		
		# be sure to reset on line end
		array_push($arr, "\x1b[0m");
		
		$s = implode($arr);
		return $s;
	}
	
	private static function dimmed($s) {
		return "\x1b[2m{$s}\x1b[0m";
	}
	
	public function toConsoleString($fancy) {		
		if (in_array(strtolower($this->getCommand()), array('privmsg', 'notice')) && $this->getArgc() > 1) {
			$from = $this->getFrom();
			$target = $this->getArg(0);
			$msg = $this->getArg(1);
			
			if (!Dog_IRCMsg::isChannel($target) && $this->getDirection() == Direction::IN) {
				$target = $from;
			}
			
			$matches = array();
			if (preg_match('/\x01ACTION (.*)?\x01/i', $msg, $matches) === 1) {
				$msg = $matches[1];
			}
			
			if ($fancy) {
				$msg = Dog_IRCMsg::irc2ansi($msg);
			} else {
				$msg = Dog_IRCMsg::stripirc($msg);
			}

			$str = $matches ? "*$from $msg" : "$from: $msg";
			if ($fancy) {
				if (strtolower($this->getCommand()) === 'notice') {
					$str = Dog_IRCMsg::dimmed($str);
				}
			}
				
			return "$target: $str";
		}
		
		$d = $this->getDirection() === Direction::IN ? '<<' : '>>';
		return "$d {$this->getRaw()}";
	}
}
?>
