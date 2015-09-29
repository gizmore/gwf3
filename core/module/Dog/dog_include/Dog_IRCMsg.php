<?php
/**
 * IRC Message parsed from socket input.
 * @author gizmore
 * @version 4.0
 */
final class Dog_IRCMsg
{
	private $raw, $from, $event, $args;

	public function getRaw() { return $this->raw; }
	public function getFrom() { return $this->from; }
	public function getEvent() { return $this->event; }
	public function getArgs() { return $this->args; }
	public function getArgc() { return count($this->args); }
	public function getArg($n) { return $this->args[$n]; }
	
	public function shouldLog()
	{
		return strpos($this->raw, '.login') === false && strpos($this->raw, '.register') === false;
	}
	
	public function Dog_IRCMsg($message)
	{
		$this->raw = $message;
		
		$by_space = preg_split('/[ ]+/', $this->raw);
		
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
