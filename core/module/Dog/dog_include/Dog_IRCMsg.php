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
}
?>
