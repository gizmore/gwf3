<?php
final class Shadowcmd_dropkp extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) !== 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'dropkp'));
			return false;
		}
		
		if (false === ($k = $player->getKnowledgeByArg('places', $args[0])))
		{
			$player->msg('1023');
// 			$player->message('You don\'t have this knowledge.');
			return false;
		}
		
		if (false === $player->removeKnowledge('places', $k))
		{
			$player->message('Database error.');
			return false;
		}
		
// 		$player->msg($key);
// 		$player->message('You removed a known place: '.$k);
		return true;
	}
}
?>