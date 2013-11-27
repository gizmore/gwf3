<?php
final class Shadowcmd_known_words extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return self::rply($player, '5055', array(Shadowfunc::getKnownWords($player)));
// 		return Shadowrap::instance($player)->reply(sprintf('Known Words: %s.', Shadowfunc::getKnownWords($player)));
	}
}
?>
