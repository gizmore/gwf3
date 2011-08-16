<?php
final class Shadowcmd_shout extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0) {
			Shadowrap::instance($player)->reply(Shadowhelp::getHelp($player, 'shout'));
			return false;
		}
		
		$wait = SR_NoShout::isNoShout($player->getID());
		if ($wait > 0)
		{
			$player->message(sprintf('Please wait %s before you shout again.', GWF_Time::humanDuration($wait)));
			return false;
		}
		
		Shadowshout::shout($player, implode(' ', $args));
		return true;
	}
}
?>
