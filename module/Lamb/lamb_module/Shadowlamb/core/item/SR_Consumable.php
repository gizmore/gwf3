<?php
abstract class SR_Consumable extends SR_Usable
{
	public abstract function onConsume(SR_Player $player);
	
	public function onItemUse(SR_Player $player, array $args)
	{
		$busy = $player->isFighting() ? $this->getItemUseTime() : 0;
		
		# Consume it
		$this->onConsume($player);
		$this->increase('sr4it_amount', -1);
		if ($this->getAmount() === 0) {
			$this->deleteItem($player);
		}
		
		if ($busy > 0) {
			$busy = $player->busy($busy);
		}
		
		# Announce Usage
		$player->getParty()->message($player, $this->getConsumeMessage($busy));
	}
	
	public function getConsumeMessage($busy)
	{
		$busy = $busy > 0 ? sprintf(' %s busy.', GWF_Time::humanDurationEN($busy)) : '';
		return sprintf('consumed an item: %s.%s', $this->getItemName(), $busy);
	}
}
?>