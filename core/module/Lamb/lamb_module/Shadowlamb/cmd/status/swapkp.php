<?php
/**
 * Swap the position of two known places. (thx sabretooth)
 * @author gizmore
 */
final class Shadowcmd_swapkp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'swapkp'));
			return false;
		}
		
		if ('' === ($kp = $player->getKnowledge('places')))
		{
			$player->message('You have no known places yet.');
			return false;
		}
		
		if (false === ($placeA = Shadowcmd_goto::getTLCByArg($player, $args[0])))
		{
			$player->message(sprintf('The first place, %s, is unknown.', $args[0]));
			return false;
		}
		
		if (false === ($placeB = Shadowcmd_goto::getTLCByArg($player, $args[1])))
		{
			$player->message(sprintf('The second place, %s, is unknown.', $args[1]));
			return false;
		}
		
		if ($placeA === $placeB)
		{
			$player->message('Swapping nothing, so bailout.');
			return false;
		}
		
		$all = explode(',', $kp);
		
		if (false === ($a = array_search($placeA, $all, true)))
		{
			$player->message('DB Error 1');
			return false;
		}
		
		if (false === ($b = array_search($placeB, $all, true)))
		{
			$player->message('DB Error 2');
			return false;
		}

		$all[$a] = $placeB;
		$all[$b] = $placeA;
		
		if (false === $player->saveBase('known_places', implode(',', $all)))
		{
			$player->message('DB Error 3');
			return false;
		}
		
		return Shadowcmd_known_places::execute($player, array());
	}
}
?>