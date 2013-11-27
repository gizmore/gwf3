<?php
abstract class SR_Consumable extends SR_Usable
{
	public abstract function onConsume(SR_Player $player);
	
	public abstract function getWater();
	public abstract function getCalories();
	public abstract function getLitres();
	
	public function onItemUse(SR_Player $player, array $args)
	{
		$busy = $player->isFighting() ? $this->getItemUseTime() : 0;
		
//		if ($this->isBroken())
//		{
//			$player->message(sprintf('Your %s is broken and cannot get consumed.', $this->getItemName()));
//			return false;
//		}

		# Consume it
		if ($this->useAmount($player, 1, false))
		{
			$this->onConsume($player);
			SR_Feelings::consume($player, $this);
			$player->modify();
		}
		
		
		if ($busy > 0)
		{
			$busy = $player->busy($busy);
		}
		
		# Announce Usage
		$pname = $player->getName();
		$p = $player->getParty();
		$p->ntice('5201', array($pname, $this->getName(), $busy));
		
		if ($p->isFighting())
		{
			$ep = $p->getEnemyParty();
			$ep->ntice('5201', array($pname, $this->getName(), $busy));
		}
		
		# Announce Usage
// 		$message = $this->getConsumeMessage($busy);
// 		$p = $player->getParty();
// 		$p->message($player, $message);
// 		if ($p->isFighting()) {
// 			$player->getEnemyParty()->message($player, $message);
// 		}
	}
	
// 	public function getConsumeMessage($busy)
// 	{
// 		$busy = $busy > 0 ? sprintf(' %s busy.', GWF_Time::humanDuration($busy)) : '';
// 		return sprintf('consumed an item: %s.%s', $this->getItemName(), $busy);
// 	}
}

abstract class SR_Food extends SR_Consumable
{
	public function getItemDuration() { return 3600*24*7; } # 1 week.
	public function displayType() { return 'Food'; }
	public function getLitres() { return round($this->getItemWeight() * 2.40); }
}

abstract class SR_Drink extends SR_Consumable
{
	public function getItemDuration() { return 3600*24*64; } # 64 days.
	public function displayType() { return 'Drink'; }
	public function getWater() { return $this->getLitres(); }
	public function getCalories() { return $this->getLitres() / 20; }
}

abstract class SR_Potion extends SR_Drink
{
	public function displayType() { return 'Potion'; }
	
	public function getLitres() { return 300; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		parent::onItemUse($player, $args);
		$empty_bottle = SR_Item::createByName('EmptyBottle');
		$player->giveItems(array($empty_bottle));
	}
}
?>
