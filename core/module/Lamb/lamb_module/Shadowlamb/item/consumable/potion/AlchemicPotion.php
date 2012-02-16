<?php
final class Item_AlchemicPotion extends SR_Usable
{
	public function displayType() { return 'Potion'; }
	public function getItemWeight() { return 650; }
	public function getItemPrice() { return 31.95; }
	public function getItemDescription() { return 'A magic potion that will cast a magic spell.'; }
	
	public function isItemStackable() { return false; }
	 
	public static function alchemicFactory(SR_Player $player, $spellname, $level)
	{
		$ma = $player->get('magic');
		$in = $player->get('intelligence');
		$wi = $player->get('wisdom');
		$alc = $player->get('alchemy');
		
		# 10 - 80 percent randomness
		$randomness = (100 - ($wi + $alc*2 + $in + $ma)); 
		$randomness = Common::clamp($randomness, 10, 80);
		$randomness = Shadowfunc::diceFloat(10, $randomness) * 0.01;
		
		# Dice!
		$minlevel = round($level - ($level*$randomness), 1);
		$maxlevel = $level;
		$level = Shadowfunc::diceFloat($minlevel, $maxlevel, 1);
		
		
		$potion = SR_Item::createByName('AlchemicPotion');
		$potion->addModifiers(array(
			$spellname=>$level,
			'magic' => $player->getBase('magic'),
			'intelligence' => $player->getBase('intelligence'),
			'wisdom' => $player->getBase('wisdom'),
		));
		return $potion;
	}

	public function onItemUse(SR_Player $player, array $args)
	{
		if (false === $this->onUsePotion($player, $args))
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
		echo "Using potion".implode(',', $args).PHP_EOL;
		
		$mods = $this->getItemModifiersB();
		$spellname = key($mods);
		$level = array_shift($mods);
		if (false === ($spell = SR_Spell::getSpell($spellname)))
		{
			$player->message('Unknown spell');
			return false;
		}
		$spell->setCaster($player);
		$spell->setMode(SR_Spell::MODE_POTION);
		
		if (count($args) === 0)
		{
			$args[] = '';
		}
		
		if ( ($spell->isOffensive()) && (!$player->isFighting()) )
		{
			$player->message('This potion works in combat only.');
			return false;
		}
		
		if (false !== ($target = $spell->getTarget($player, $args, false)))
		{
			if ( (false === $spell->isOffensive()) && ($target->getID() != $player->getID()) )
			{
				$player->message('You cannot inject potions into other peoples mouth\'.');
				return false;
			}
		}
		
		
		echo "Using potion 2222 ".implode(',', $args).PHP_EOL;
		
		# Dummy player
		$mods['magic'] = false === isset($mods['magic']) ? $player->getBase('magic') : $mods['magic'];
		$mods['intelligence'] = false === isset($mods['intelligence']) ? $player->getBase('intelligence') : $mods['intelligence'];
		$mods['wisdom'] = false === isset($mods['wisdom']) ? $player->getBase('wisdom') : $mods['wisdom'];
		
		$dummy = new SR_Player(SR_Player::getPlayerData(0));
		$dummy->setVar('sr4pl_magic', $mods['magic']);
		$dummy->setVar('sr4pl_intelligence', $mods['intelligence']);
		$dummy->setVar('sr4pl_wisdom', $mods['wisdom']);
		$dummy->setSpellData(array($spellname=>$level));
		$dummy->modify();
		$spell->setCaster($dummy);
		
// 		$hits = $spell->dice($dummy, $target, $level);
// 		$spell->setMode(SR_Spell::MODE_SPELL);
		return $spell->onCast($player, $args, $level);
// 		return $spell->cast($player, $target, $level, $hits, $dummy);
	}
}
?>