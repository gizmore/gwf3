<?php
final class Shadowcmd_info extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$bot = Shadowrap::instance($player);
		
		if ($p->isInsideLocation())
		{
			$l = $p->getLocationClass();
			$bot->reply($l->getEnterText($player));
		}
		elseif ($p->isOutsideLocation())
		{
			$l = $p->getLocationClass();
			$bot->reply($l->getFoundText($player));
		}
	}
}
?>
