<?php
final class Shadowcmd_bye extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		if ($ep->isHuman())
		{
			return false;
		}
		$p->popAction(true);
		$ep->popAction(true);
		$p->setContactEta(rand(10, 20));
		$ep->setContactEta(rand(10, 20));
		return true;
	}
}
?>
