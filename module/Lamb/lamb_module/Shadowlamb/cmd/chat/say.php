<?php
final class Shadowcmd_say extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$b = chr(2);
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		$msg = sprintf('%s says: "%s"', $b.$player->getName().$b, implode(' ', $args));
		
		if ($p->isTalking() && ($ep !== false) )
		{
			$p->notice($msg);
			$ep->notice($msg);
			$p->setContactEta(60);
			
			$el = $ep->getLeader();
			if ($el->isNPC())
			{
				$ep->setContactEta(60);
				$el->onNPCTalkA($player, (isset($args[0])?$args[0]:'hello'), $args);
			}
		}
		elseif ($p->isAtLocation())
		{
			Shadowshout::onLocationGlobalMessage($player, $msg);
		}
		elseif ($p->isFighting())
		{
			$p->notice($msg);
			$ep->notice($msg);
		}
		else
		{
			$p->notice($msg);
		}
		return true;
	}
}
?>
