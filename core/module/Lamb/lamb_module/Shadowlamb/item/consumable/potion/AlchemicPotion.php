<?php
final class Item_AlchemicPotion extends SR_Usable
{
	public function displayType() { return 'Potion'; }
	public function getItemWeight() { return 650; }
	public function getItemPrice() { return 31.95; }
	
	public static function alchemicFactory($spellname, $level)
	{
		$potion = SR_Item::createByName('AlchemicPotion');
		$potion->addModifiers(array($spellname=>$level));
		return $potion;
	}

	public function onItemUse(SR_Player $player, array $args)
	{
		if (!$this->onUsePotion($player, $args))
		{
			return false;
		}
		
		# Consume it
		if (!$this->useAmount($player, 1))
		{
			echo "DB ERROR\n";
		}
		
		$player->giveItems(array(SR_Item::createByName('EmptyBottle')));
		
		$busy = $player->isFighting() ? $this->getItemUseTime() : 0;
		if ($busy > 0)
		{
			$busy = $player->busy($busy);
		}
		
		return true;
	}
	
	public function onUsePotion(SR_Player $player, array $args)
	{
		$mods = $this->getItemModifiersB();
		$spellname = key($mods);
		$level = array_shift($mods);
		if (false === ($spell = SR_Spell::getSpell($spellname)))
		{
			$player->message('Unknown spell');
			return false;
		}
		
		if (count($args) === 0)
		{
			$args[] = '';
		}
		
		if ( ($spell->isOffensive()) && (!$player->isFighting()) )
		{
			$player->message('This potion works in combat only.');
			return false;
		}
		
		$spell->setMode(SR_Spell::MODE_POTION);
		if (false === ($target = $spell->getTarget($player, $args)))
		{
			$player->message('Unknown target.');
			return false;
		}
		
		if ( (!$spell->isOffensive()) && ($target->getID() !== $player->getID()) )
		{
			$player->message('You cannot inject potions into other peoples mouth\'.');
			return false;
		}
		
		$hits = $spell->dice($player, $target, $level);
		return $spell->cast($player, $target, $level, $hits);
	}
}
?>