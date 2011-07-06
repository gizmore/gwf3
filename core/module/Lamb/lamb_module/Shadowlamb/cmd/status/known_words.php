<?php
final class Shadowcmd_known_words extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return Shadowrap::instance($player)->reply(sprintf('Known Words: %s.', Shadowfunc::getKnownWords($player)));
	}
}
?>
