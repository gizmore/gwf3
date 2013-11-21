<?php
class SR_AI_giveback extends SR_AIExtension
{
	/**
	 * 5118 You received %s from %s.
	 * @param SR_RealNPC $npc
	 * @param array $args
	 */
	public function ai_msg_5118(SR_RealNPC $npc, array $args)
	{
		$item = self::getInvItem($npc, $args[0]);
		$player = self::getHuman();
		SR_AIGoal::addGoal($npc, 'giveback', $goal);
		
		
		$
		
		$npc->ai_give($player, $item);
		$npc->ai_say_message('No thanks.');
	}
	
	public function ai_check_goal(SR_RealNPC $npc)
	{
		SR_AIGoal::removeGoal($npc, $key);
	}
}
