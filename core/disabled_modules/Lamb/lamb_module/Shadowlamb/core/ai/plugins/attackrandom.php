<?php
final class ShadowAI_attackrandom extends SR_AICMD
{
	public static function decideCombat(SR_Player $player, array $args)
	{
		echo __METHOD__.PHP_EOL;
		$min = isset($args[0]) ? (int)$args[0] : 1.0;
		$max = isset($args[1]) ? (int)$args[1] : 1.0;
		return array('attack', Shadowfunc::diceFloat($min, $max, 2));
	}
}
?>