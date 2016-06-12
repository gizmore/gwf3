<?php
class SR_AI_hunger extends SR_AIFeelingExtension
{
	public static function getFood(SR_RealNPC $npc)
	{
                return $npc->getInventory()->getItemByClass('SR_Food');
	}
	
	public static function getHungerUrgency(SR_RealNPC $npc)
	{
		return self::getFeelingUrgency($npc, 'food');
	}
	
	public function ai_goal(SR_RealNPC $npc)
	{
		if (SR_Feelings::isHungry($npc))
		{
			if (false !== ($food = self::getFood($npc)))
			{
				$npc->ai_use($food);
			}
		}
	}

}
