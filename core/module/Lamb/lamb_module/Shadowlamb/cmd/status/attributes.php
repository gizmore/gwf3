<?php
final class Shadowcmd_attributes extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply(Shadowrun4::lang('5004', array(Shadowfunc::getAttributes($player))));
// 		$bot->reply(sprintf('Your attributes: %s.', Shadowfunc::getAttributes($player)));
		return true;
	}
}
?>