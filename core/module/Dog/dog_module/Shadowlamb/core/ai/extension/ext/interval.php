<?php
class SR_AI_interval extends SR_AIExtension
{
	public function getInterval() { return (int)$this->getArg(0, 0); }
	
	public function ai_tick($function, $args=null)
	{
		if (0 < ($interval = $this->getInterval()))
		{
			if ((Shadowrun4::getTime() % $interval) === 0)
			{
				call_user_func_array($this->getArg(1), $this->getArg(2, array()));
			}
		}
	}
}