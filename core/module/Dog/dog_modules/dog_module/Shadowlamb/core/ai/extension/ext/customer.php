<?php
class SR_AI_customer extends SR_AI_equipper
{
	public function ai_goal(SR_RealNPC $npc)
	{
		echo __CLASS__.__FUNCTION__.': '.$npc->getClassName();
		parent::ai_goal($npc);
	}
}
