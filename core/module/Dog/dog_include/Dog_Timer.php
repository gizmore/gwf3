<?php
/**
 * Timer structure and execution.
 * @author gizmore
 * @version 4.0
 */
final class Dog_Timer
{
	private $func;
	private $time;
	private $delay;
	private $repeat;
	private $args;
	
	private static $TIMERS = array();
	private static $LAST_TIME = NULL;
	private static $MICROS = 50000;
	
	public static function init($millis)
	{
		self::$LAST_TIME = self::$LAST_TIME === NULL ? microtime(true) : self::$LAST_TIME;
		self::$MICROS = $millis * 1000;
	}
	
	public static function flush()
	{
		self::$TIMERS = array();
	}
	
	public static function addTimer($func, $args, $delay, $repeat=true)
	{
		if ($delay < 0.200)
		{
			die(Dog_Log::critical("Timer has delay < 0.200!"));
		}
		self::$TIMERS[] = new self($func, $args, $delay, $repeat);
	}
	
	public static function sleepAndTrigger()
	{
		# Trigger
		self::trigger();
		
		# Sleep
		$elapsed = microtime(true) - self::$LAST_TIME;
		$elapsed *= 1000000;
		if ($elapsed < self::$MICROS)
		{
			usleep(self::$MICROS-$elapsed);
		}
		self::$LAST_TIME = microtime(true);
	}
	
	private static function trigger()
	{
		$now = microtime(true);
		foreach (self::$TIMERS as $i => $timer)
		{
			$timer instanceof Dog_Timer;
			if ($timer->triggers($now))
			{
				$timer->execute();
				
				if (!$timer->repeating($now))
				{
					unset(self::$TIMERS[$i]);
				}
			}
		}
	}
	
	public function __construct($func, $args, $delay, $repeat=true)
	{
		$this->func = $func;
		$this->args = $args;
		$this->time = microtime(true) + $delay;
		$this->delay = $delay;
		$this->repeat = $repeat;
	}
	
	public function triggers($now)
	{
		return $this->time <= $now;
	}
	
	public function repeating($now)
	{
		if (!$this->repeat)
		{
			return false;
		}
		$this->time = $now + $this->delay;
		return true;
	}
	
	public function execute()
	{
		if ( (is_array($this->func)) || ($this->func[0]!=='/') )
		{
			call_user_func($this->func, $this->args);
		}
		else
		{
			$args = $this->args;
			include $this->func;
		}
	}
}
