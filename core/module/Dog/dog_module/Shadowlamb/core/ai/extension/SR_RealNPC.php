<?php
require_once 'SR_RealNPCBase.php';

/**
 * Movement and sleeping and stuff.
 * @author gizmore
 */
abstract class SR_RealNPC extends SR_RealNPCBase
{
	private $goals;
	private $extensions;
	
	public function getLangISO() { return 'bot'; }
	public function hasFeelings() { return true; }
	public function isHotelFree() { return true; }
	public function isKillProtected() { return false; }
	public function doesRespawn() { return true; }
	
	public function getExtensions()
	{
		return array(
			'common_sense' => array(),
		);
	}
	
	public function ai_init_extensions()
	{
		$this->extensions = SR_AIExtension::generate($this->getExtensions());
	}
	
	public function msg($key, $args=NULL)
	{
		echo "AI MSG: $key ".implode(', ', $args)."\n";
		$this->setChatPartner(Shadowcmd::$CURRENT_PLAYER);
		$this->realnpcfunc('msg_'.$key, $args);
		return true;
	}
	
	public function message($message)
	{
		$this->setChatPartner(Shadowcmd::$CURRENT_PLAYER);
		echo GWF_Debug::backtrace('AIGOT', false);
		echo "AI GOT: $message\n";
		return true;
		
	}

	/**
	 * Gives either the min or a max for an AI function.
	 * If you just wanna call something, discard the return value.
	 * @param function_name $command
	 * @param array $args
	 * @param boolean $max
	 * @return int|null
	 */
	public function realnpcfunc($function_name, $args=array(), $returnmax=true)
	{
		$action = $this->getParty()->getAction();
		$prefix = $this->isFighting() ? 'aic_' : 'ai_';
		$method_name = $prefix.$function_name;
		$min = 10001;
		$max = 0;
	
		if (method_exists($this, $method_name))
		{
			$back = call_user_func_array(array($this, $method_name), $args);
			$min = min($min, $back);
			$max = max($max, $back);
		}
	
		foreach ($this->extensions as $extension)
		{
			if (method_exists($extension, $method_name))
			{
				$back = call_user_func(array($extension, $method_name), $this, $args);
				$min = min($min, $back);
				$max = max($max, $back);
			}
		}
		
		// Return value might be false.
		if ($min > 10000)
		{
			$min = $max = false;
		}
		$back = $returnmax ? $max : $min;
		
		echo ":Orealnpcfunc: {$this->getClassName()}->{$method_name}() = {$back}\n";
		
		return $back;
	}
	
	public function ai_tick()
	{
		if ($this->isIdle())
		{
			$this->realnpcfunc('goal');
			SR_AIGoal::newGoal($this);
		}
	}
	
	public function ai_init()
	{
		echo "ai_init!\n";
		$this->ai_init_extensions();
		SR_AIGoal::resetGoals($this);
		$this->realnpcfunc('before_init');
		$this->realnpcfunc('goals');
		$this->realnpcfunc('after_init');
	}
	
	public function ai_pushed_action($oldaction, $newaction, $target, $eta)
	{
		echo "ai_pushed_action\n";
		var_dump(func_get_args());
		$this->realnpcfunc('before_pushing_action');
		$this->realnpcfunc('completed_'.$oldaction);
		$this->realnpcfunc('beginning_'.$newaction);
		$this->realnpcfunc('after_pushing_action');
	}
	
	public function ai_popped_action($oldaction, $newaction, $target, $eta)
	{
		$this->ai_pushed_action($oldaction, $newaction, $target, $eta);
	}
	
	public function ai_goals()
	{
	}
	
	public function ai_before_init()
	{
	}
	
	public function ai_after_init()
	{
	}
	
	public function on_init_sleep()
	{
		$this->say('Good night!');
	}
	
}
