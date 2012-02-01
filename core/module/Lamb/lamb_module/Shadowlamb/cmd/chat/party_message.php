<?php
final class Shadowcmd_party_message extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		return $player->getParty()->ntice('5084', array($player->getName(), implode(' ', $args)));
// 		$b = chr(2);
// 		$bot = Shadowrap::instance($player);
// 		$message = sprintf('%s pm: "%s"', $b.$player->getName().$b, implode(' ', $args));
// 		$player->getParty()->notice($message);
// 		return true;
	}
}
?>
