<?php
/**
 * Return the first best decision of all the decisions.
 * @author gizmore
 */
final class ShadowAI_best extends SR_AICMD
{
	public static function decideCombat(SR_Player $player, array $args)
	{
		return array_pop(SR_AIDecision::sortDecisions(SR_AIDecision::filterDecisions($args)));
	}
}
?>