<?php
/**
 * Returns a probably good decision of all the decisions.
 * @author gizmore
 */
final class ShadowAI_dice extends SR_AICMD
{
	public static function decideCombat(SR_Player $player, array $args)
	{
		$args = SR_AIDecision::filterDecisions($args);
		
		$total = 0;
		$data = array();
		
		foreach ($args as $decision)
		{
			$decision instanceof SR_AIDecision;
			$chance = (int)($decision->getPreference() * 1000);
			$total += $chance;
			$data[] = array($decision, $chance);
		}
		
		$rand = Shadowfunc::randomData($data, $total);
		return $rand === false ? NULL : $rand; 
	}
}
?>