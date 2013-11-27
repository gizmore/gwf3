<?php
class SR_AI_traveller extends SR_AIExtension
{
	public function getCity()
	{
		$arg = $this->getArg(0, 'Redmond');
		if (false === ($city = Shadowrun4::getCity($arg)))
		{
			return Shadowrun4::getCity('Redmond');
		}
		return $city;
	}
	
	public function getCityname()
	{
		return $this->getCity()->getName();
	}
	
	public function ai_goal(SR_RealNPC $npc)
	{
		echo __CLASS__.__FUNCTION__.': '.$npc->getClassName();
	}
}