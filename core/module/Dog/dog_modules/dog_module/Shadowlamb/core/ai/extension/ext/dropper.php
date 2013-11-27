<?php
class SR_AI_dropper extends SR_AIExtension
{
	public static function isDropOverweight(SR_RealNPC $npc)
	{
		return $npc->get('weight') / $member->get('max_weight') > 1.2;
	}
	
	public function ai_goal(SR_RealNPC $npc)
	{
		if (self::isDropOverweight($npc))
		{
			foreach (self::getUnwantedItems(5000) as $item)
			{
				$item instanceof SR_Item;
				SR_AIGoal::addGoal($npc, 'cleanup', new SR_AIGoal('drop '.$item->getItemName(), $item->getVar('urgengy')));
				break;
			}
		}
	}
}
