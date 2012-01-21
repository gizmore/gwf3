<?php
abstract class SR_Usable extends SR_Item
{
	public function displayType() { return 'Usable'; }
	public function getItemDuration() { return 3600*24*360; } # 360 days
	
	/**
	 * @param SR_Player $player
	 * @param array $args
	 * @return SR_Player
	 */
	public function getOffensiveTarget(SR_Player $player, $arg)
	{
		return Shadowfunc::getOffensiveTarget($player, $arg);
	}
	
	/**
	 * @param SR_Player $player
	 * @param array $args
	 * @return SR_Player
	 */
	public function getFriendlyTarget(SR_Player $player, $arg)
	{
		return Shadowfunc::getFriendlyTarget($player, $arg);
	}
	
	public function announceUsage(SR_Player $player, SR_Player $target, $message='', $message2='', $useamt=1)
	{
		if ($player->isFighting())
		{
			$busy = $player->busy($this->getItemUsetime());
			$busymsg = sprintf(' %ds busy.', $busy);
		}
		else
		{
			$busymsg = '';
		}
		$player->getParty()->notice(sprintf('%s used %s on %s.%s%s', $player->getName(), $this->getName(), $target->getName(), $busymsg, $message));
		
		if ($player->isFighting())
		{
			$player->getEnemyParty()->notice(sprintf('%s used %s on %s.%s', $player->getName(), $this->getName(), $target->getName(), $message2));
		}

		if ($useamt > 0)
		{
			return $this->useAmount($player, $useamt);
		}
		
		return true;
	}
	
}

abstract class SR_HealItem extends SR_Usable
{
	public function displayType() { return 'Heal Item'; }
	
}

?>