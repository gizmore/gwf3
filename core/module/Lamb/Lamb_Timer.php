<?php
/**
 * Lamb timer under the WPL :)
 * @author gizmore
 * @version 3.0
 * @since 3.0
 */
final class Lamb_Timer
{
	private $callback;
	private $seconds;
	private $server;
	private $args;
	private $repeat;
	private $time_exec;
	
	const DELAY_INSTANT = 0;
	const DELAY_DISABLE = -1;
	
	const REPEAT_NO = 0;
	const REPEAT_INF = -1;
	
	public function __construct($callback, $seconds=1.0, $server=NULL, $args=NULL, $repeat=self::REPEAT_INF, $delay=self::DELAY_DISABLE)
	{
		$this->callback = $callback;
		$this->seconds = $seconds;
		$this->server = $server;
		$this->args = $args;
		$this->repeat = $repeat;
		$this->time_exec = ($delay < 0 ? $seconds : $delay) + microtime(true);
	}
	
	/**
	 * Execute the timer and do all the magic and stuff and checks. Return True if the timer should be removed. False if all is fine.
	 * @return true|false testreturndocstest
	 */
	public function execute($time)
	{
		# Wait
		if ($this->time_exec > $time)
		{
			return false;
		}
		
		# Exec
		if (false === $this->onExecute($time))
		{
			Lamb_Log::logError(sprintf('Timer returned false: %s.', GWF_Hook::callbackToName($this->callback)));
		}
		
		# Delete?
		return $this->repeat < 0 ? false : (--$this->repeat) <= 0;
	}
	
	/**
	 * Really execute the timer now :)
	 * @param float $time
	 * @return true|false|mixed
	 */
	private function onExecute($time)
	{
//		Lamb_Log::logDebug(sprintf('Executing timer "%s" ...', GWF_Hook::callbackToName($this->callback)));
		
		# Repeat
		$this->time_exec = $time + $this->seconds;
		
		# Exec
		return call_user_func($this->callback, $this->server, $this->args);
	}
}
?>
