<?php
final class Shadowcmd_say extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if ('' === ($message = trim(implode(' ', $args))))
		{
			return false;
		}
		
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		$pname = $player->getName();
		
		if ($p->isTalking() && ($ep !== false) )
		{
			$p->ntice('5085', array($pname, $message));
			$ep->ntice('5085', array($pname, $message));
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
			Shadowshout::onLocationGlobalMessage($player, '5085', $args);
		}
		elseif ($p->isFighting())
		{
			$p->ntice('5085', array($pname, $message));
			$ep->ntice('5085', array($pname, $message));
		}
		else
		{
			$p->ntice('5085', array($pname, $message));
		}
		return true;
	}
}
?>
