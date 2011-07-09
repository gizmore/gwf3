<?php
final class Shadowcmd_known_knowledge extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply(sprintf('Your knowledge: %s.', Shadowfunc::getKnowledge($player)));
		return true;
	}
}
?>
