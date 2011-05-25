<?php
abstract class SR_Usable extends SR_Item
{
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
		if ($player->isFighting()) {
			$busy = $player->busy($this->getItemUsetime());
			$busymsg = sprintf(' %ds busy.', $busy);
		} else {
			$busymsg = '';
		}
		$player->getParty()->message($player, sprintf(' used %s on %s.%s%s', $this->getName(), $target->getName(), $busymsg, $message));
		$target->getParty()->message($player, sprintf(' used %s on %s.%s', $this->getName(), $target->getName(), $message2));

		if ($useamt > 0) {
			$this->useAmount($player, $useamt);
		}
	}
	
}

abstract class SR_HealItem extends SR_Usable
{
	public function displayType() { return 'Heal Item'; }
	
}

?>