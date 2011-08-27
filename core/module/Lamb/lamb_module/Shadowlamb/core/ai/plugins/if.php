<?php
/**
 * Takes 3 args: condition, expression, expression.
 * @author gizmore
 */
final class ShadowAI_if extends SR_AICMD
{
	public static function decideCombat(SR_Player $player, array $args)
	{
		if (count($args) !== 3)
		{
			Lamb_Log::logDebug(sprintf('Call to AI: if expects 3 args. %s given!', count($args)));
			return NULL;
		}
		
		if (self::evaluateExpression($args[0]))
		{
			return self::evaluateExpression($args[1]);
		}
		else
		{
			return self::evaluateExpression($args[2]);
		}
	}
}
?>