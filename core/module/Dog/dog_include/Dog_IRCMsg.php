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
	private $raw, $direction, $from, $event, $args;

	public function getRaw() { return $this->raw; }
	public function getDirection() { return $this->direction; }
	public function getFromFull() { return $this->from; }
	public function getFrom() { return Common::substrUntil($this->getFromFull(), '!'); }
	public function getEvent() { return $this->event; }
	public function getArgs() { return $this->args; }
	public function getArgc() { return count($this->args); }
	public function getArg($n) { return $this->args[$n]; }
	
	public function shouldLog()
	{
		return strpos($this->raw, '.login') === false && strpos($this->raw, '.register') === false;
	}
	
	public function __construct($message, $from=null)
	{
		$this->raw = $message;

		if ($from !== null) {
			$this->direction = Direction::OUT;
			$message = ':' . $from . ' ' . $message;
		} else {
			$this->direction = Direction::IN;
		}

		$by_space = preg_split('/[ ]+/', $message);
		
		$this->from = $message[0] === ':' ? ltrim(array_shift($by_space), ':') : '';
		$this->event = preg_replace('/[^a-z_0-9]/i', '', array_shift($by_space));
		$this->args = array();
		
		$len = count($by_space);
		while ($len)
		{
			$arg = array_shift($by_space);
			if (strlen($arg) === 0)
			{
				# trailing spaces?
			}
			elseif ($arg[0] === ':')
			{
				# implode everything after colon
				$this->args[] = trim(substr($arg, 1).' '.implode(' ', $by_space));
				return;
			}
			else
			{
				# Normal arg
				$this->args[] = $arg;
			}
			$len--;
		}
	}
}
?>
