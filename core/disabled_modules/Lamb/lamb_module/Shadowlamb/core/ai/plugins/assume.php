<?php
/**
 * Set a var in the players view.
 * @author gizmore
 */
final class ShadowAI_assume extends SR_AICMD
{
	public static function decideCombat(SR_Player $player, array $args)
	{
		# NULL?
		if (count($args) !== 2)
		{
			return NULL;
		}
		
		$view = $player->getAIView();
		$key = $args[0];
//		$view[]
		
	}
}
?>