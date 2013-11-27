<?php
require_once 'traveller.php';
class SR_AI_explorer extends SR_AI_traveller
{
	public function ai_goal(SR_RealNPC $npc)
	{
		echo __CLASS__.__FUNCTION__.': '.$npc->getClassName();
		
		$cityname = $this->getCityname();
		$currcity = $npc->getParty(false)->getCity();
		
		if ($currcity === $cityname)
		{
			if (self::canExplore($cityname))
			{
				SR_AIGoal::addGoal($npc, 'explore', new SR_AIGoal('exp'));
			}
		}
	}
	
	public static function canExplore(SR_RealNPC $npc, $cityname)
	{
		return true;
	}
}