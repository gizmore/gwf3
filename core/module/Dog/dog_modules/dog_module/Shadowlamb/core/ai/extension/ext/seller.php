<?php
class SR_AI_seller extends SR_AIExtension
{
	public function ai_goal(SR_RealNPC $npc)
	{
		echo __CLASS__.__FUNCTION__.': '.$npc->getClassName();
		
		if ($npc->ai_can('sell'))
		{
			foreach ($npc->getInventorySorted() as $i => $items)
			{
				if ($npc->realnpcfunc('needs_item', array($item)) < 5000)
				{
					
				}
			}
		}
	}
}
