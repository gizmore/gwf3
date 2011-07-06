<?php
require_once 'givekp.php';
final class Shadowcmd_givekw extends Shadowcmd_givekp
{
	public static function execute(SR_Player $player, array $args)
	{
		if ($player->isFighting())
		{
			$player->message('This does not work in combat');
			return false;
		}
		
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'givekw'));
			return false;
		}
		
		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0])))
		{
			$player->message(sprintf('%s is not here or the name is ambigous.', $args[0]));
			return false;
		}

		return self::giveKnow($player, $target, 'words', $args[1]);
	}
}
?>
