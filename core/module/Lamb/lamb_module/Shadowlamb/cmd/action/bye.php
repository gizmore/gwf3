<?php
final class Shadowcmd_bye extends Shadowcmd
{
	private static $BYEBYE = array();
	
	public static function onPartyMeet(SR_Party $a, SR_Party $b)
	{
		$key = self::getByeKey($a, $b);
		self::$BYEBYE[$key] = '';
	}
	
	public static function getByeKey(SR_Party $a, SR_Party $b)
	{
		$ids = array($a->getID(), $b->getID());
		sort($ids);
		return implode(':', $ids);
	}
	
	private static function onHumanBye(SR_Party $p, SR_Party $ep)
	{
		$key = self::getByeKey($p, $ep);
		$bye = self::$BYEBYE[$key];
		if ($bye === '')
		{
			self::$BYEBYE[$key] = $p->getID();
			return false;
		}
		elseif ($bye == $ep->getID())
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		if ($ep === false)
		{
			return false;
		}
		
		if ($ep->isHuman())
		{
			if (!self::onHumanBye($p, $ep))
			{
				return true;
			}
		}
		$p->popAction(true);
		$ep->popAction(true);
		$p->setContactEta(rand(10, 20));
		$ep->setContactEta(rand(10, 20));
		return true;
	}
}
?>
