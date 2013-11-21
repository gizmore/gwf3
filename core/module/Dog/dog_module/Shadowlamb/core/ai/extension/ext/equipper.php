<?php
class SR_AI_equipper extends SR_AIExtension
{
	public function ai_goal(SR_RealNPC $npc)
	{
		echo __CLASS__.__FUNCTION__.': '.$npc->getClassName();
	}
}
