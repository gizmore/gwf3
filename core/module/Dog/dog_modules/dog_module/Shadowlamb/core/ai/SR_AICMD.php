<?php
/**
 * New AI. Thx somerandomnick!
 * Example of complex rules:
 * $ai = flee(true,true)+1;healfriends(true)*5;attackrandom(true)*2
 * @author gizmore
 */
class SR_AICMD
{
	const DEFAULT_COMBAT_AI = 'attackrandom;healself';
	
	public static function decideGame(SR_Player $player, array $args) { return NULL; }
	public static function decideCombat(SR_Player $player, array $args) { return NULL; }
	
	public static function combatTimer(SR_Player $player)
	{
		$ai = $player->getVar('sr4pl_combat_ai');
		if ($ai === NULL)
		{
			if ($player->isHuman())
			{
				return;
			}
			else
			{
				$ai = self::DEFAULT_COMBAT_AI;
			}
		}
		
//		$data = array();
//		$total = 0;
		$decisions = array();
		
		$ai = explode(';', $ai);
		foreach ($ai as $func)
		{
			$func = trim($func);
			if (preg_match('/([a-z_]+)(\([^\)]+\))?([-+*\\/]\\d+)?/i', $func, $matches))
			{
				$funcname = $matches[1];
				$classname = 'ShadowAI_'.$funcname;
				if (class_exists($classname))
				{
					$args = isset($matches[1]) ? explode(',', $matches[1]) : NULL;
					$multi = isset($matches[2]) ? $matches[2] : '*1';
					$decision = call_user_func(array($classname, 'decideCombat'), $player, $args);
					if ($decision !== NULL)
					{
						$command = $decision[0];
						$prefer = $decision[1];
						$prefer = eval("$prefer$multi;");
//						$chance = (int)($prefer*100);
//						$total += $chance;
//						$data[] = array($command, $chance);
						$decisions[$command] = $prefer;
					}
				}
				else
				{
					Dog_Log::debug(sprintf('%s has an invalid AI method: %s.', $player->getName(), $funcname));
				}
			}
			else
			{
				Dog_Log::debug(sprintf('PREG MATCH FAILED: %s.', $func));
			}
		}
		
		# Best
		if (count($decisions) > 0)
		{
			arsort($decisions);
			$command = key($decisions);
			$player->combatPush($command);
		}
		
		# Rand
//		if (false !== ($command = Shadowfunc::randomData($data, $total)))
//		{
//			$player->combatPush($command);
//		}
	}
}
?>