<?php
/**
 * Take a decision and a multiplicator. Multiply the preference of the decision and return it.
 * @author gizmore
 */
final class ShadowAI_mul extends SR_AICMD
{
	public static function decideCombat(SR_Player $player, array $args)
	{
		# NULL?
		if (count($args) === 0)
		{
			return NULL;
		}
		
		# ARG missing!
		if (count($args) === 1)
		{
			Dog_Log::debug(sprintf('Missing parameter for AI: mul.'));
			return $args[0];
		}

		# Is it a decision?
		$decision = $args[0];
		if (!($decision instanceof SR_AIDecision))
		{
			return $args[0] * $args[1];
		}
		
		# Multiply all the decisions!
		$decision instanceof SR_AIDecision;
		$decision->setPreference($decision->getPreference() * $args[1]);
		return $decision;
	}
}
?>