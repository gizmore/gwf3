<?php
final class Shadowcmd_known_knowledge extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->msg('5053', array(Shadowfunc::getKnowledge($player)));
// 		$bot = Shadowrap::instance($player);
// 		$bot->reply(sprintf('Your knowledge: %s.', Shadowfunc::getKnowledge($player)));
// 		return true;
	}
}
?>
