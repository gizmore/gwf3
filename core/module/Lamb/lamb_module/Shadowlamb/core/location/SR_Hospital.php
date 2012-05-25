<?php
abstract class SR_Hospital extends SR_Store
{
	public function getAbstractClassName() { return __CLASS__; }
	
	# Surgery prices
	public function getGenderPrice($gender=NULL) { return 5000; }
	public function getSkillPrice($skill=NULL) { return 6000; }
	public function getAttributePrice($attribute=NULL) { return 4000; }
	public function getKnowledgePrice($knowledge=NULL) { return 2000; }
	public function getSpellPrice($spellname=NULL) { return 3000; }
	public function getRacePrice($race) { return $this->calcRacePrice($race); }
	
	public static $SECTIONS = array('race','skill','gender','attribute','spell','knowledge');
	
	public function getRacePrices()
	{
		return array(
			'fairy' => 200000,
			'elve' => 180000,
			'halfelve' => 150000,
			'vampire' => 200000,
			'darkelve' => 150000,
			'woodelve' => 140000,
			'human' => 100000,
			'gnome' => 90000,
			'dwarf' => 80000,
			'halfork' => 70000,
			'halftroll'=> 60000,
			'ork' => 50000,
			'troll' => 40000,
			'gremlin' => 10000,
		);
	}
	
	public function calcRacePrice($race)
	{
		return false;
		$prices = $this->getRacePrices();
		return isset($prices[$race]) ? $prices[$race] : false;
	}
	
	# Heal prices
	public abstract function getHealPrice();
	public function calcHealPrice(SR_Player $player) { return Shadowfunc::calcBuyPrice($this->getHealPrice(), $player); }
	
	# Location
	public function getFoundPercentage() { return 85.00; }
	public function getCommands(SR_Player $player) { return array('heal','view','viewi','implant','unplant','surgery'); }
	public function getFoundText(SR_Player $player) { return $player->lang('stub_found_hospital'); }
	public function getEnterText(SR_Player $player) { return $player->lang('stub_enter_hospital'); }
	public function getHelpText(SR_Player $player) { return $player->lang('hlp_hospital'); }
	public function getStoreViewCode() { return '5277'; }

	############
	### Heal ###
	############
	public function on_heal(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$price = $this->calcHealPrice($player);
		$p1 = Shadowfunc::displayNuyen($price);
		
		if ($player->hasFullHP())
		{
			return $bot->rply('1138');
// 			$bot->reply(sprintf('The doctor says: "You don`t need my help, chummer."'));
// 			return true;
		}
		
		if (!$player->pay($price))
		{
			$p2 = Shadowfunc::displayNuyen($player->getBase('nuyen'));
			$bot->rply('1139', array($p1, $p2));
// 			$bot->reply(sprintf('The doctor shakes his head: "No, my friend. Healing you will cost %s but you only have %s."', $p1, $p2));
			return false;
		}
		$player->healHP(100000);
		return $bot->rply('5179', array($p1));
// 		$bot->reply(sprintf('The doctor takes your %s and heals you.', $p1));
		return true;
	}

	###############
	### Implant ###
	###############
	public function on_implant(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'implant'));
			return false;
		}
		if (false === ($item = $this->getStoreItem($player, $args[0])))
		{
			$bot->rply('1140');
// 			$bot->reply('We don`t have that item.');
			return false;
		}
		$item instanceof SR_Cyberware;
		
		if ($player->hasCyberware($item->getItemName()))
		{
			$bot->rply('1141', array($item->getItemName()));
// 			$bot->reply(sprintf('You already have %s implanted.', $item->getItemName()));
			return false;
		}
		
		if (false !== ($error = $item->conflictsWith($player)))
		{
			$bot->rply('1142', array($item->getItemName(), $error));
// 			$bot->reply(sprintf('You can not implant %s. It conflicts with %s.', $item->getItemName(), $error));
			return false;
		}
		
		if (false === $item->checkEssence($player))
		{
			return false;
		}
		
		$price = $item->getStorePrice();
		if (false === ($player->pay($price)))
		{
			$bot->rply('1063', array(Shadowfunc::displayNuyen($price), $player->displayNuyen()));
// 			$bot->reply(sprintf('You can not afford %s. You need %s but only have %s.', $item->getItemName(), Shadowfunc::displayNuyen($price), Shadowfunc::displayNuyen($player->getBase('nuyen'))));
			return false;
		}
		
		if (false === $item->insert()) {
			$bot->reply('Database error 5.');
			return false;
		}
		
		$player->addCyberware($item);
		$player->modify();
		
		$bot->rply('5180', array(Shadowfunc::displayNuyen($price), $item->getItemName()));
// 		$bot->reply(sprintf('You paid %s and got %s implanted.', Shadowfunc::displayNuyen($price), $item->getItemName()));
		return true;
	}

	###############
	### Unplant ###
	###############
	public function on_unplant(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'unplant'));
			return false;
		}
		$id = $args[0];
		if (is_numeric($id))
		{
			$item = $player->getCyberwareByID($id);
		}
		else
		{
			$item = $player->getCyberwareByName($id);
		}
		
		if ($item === false)
		{
			$bot->rply('1029');
// 			$bot->reply('You don`t have this cyberware implanted.');
			return false;
		}
		$item instanceof SR_Cyberware;
		
		$price = Shadowfunc::calcBuyPrice($item->getItemPrice() * 0.10, $player);
		$p1 = Shadowfunc::displayNuyen($price);
		if (false === $player->pay($price))
		{
			$bot->rply('1144', array($p1, $player->displayNuyen()));
// 			$bot->reply(sprintf('The doctor shakes his head: "My friend, removing this from your body will cost %s, but you only have %s."', $p1, $player->displayNuyen()));
			return false;
		}
		$player->removeCyberware($item);
		$player->modify();
		
		$bot->rply('5181', array($p1, $item->getItemName()));
// 		$bot->reply(sprintf('You pay %s and got your %s removed.', $p1, $item->getItemName()));
		return true;
	}
	
	###############
	### Surgery ###
	###############
	public function on_surgery(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			return $this->displaySurgeryPrices($player);
		}
		
		if (count($args) !== 1)
		{
			return $this->displaySurgeryHelp($player);
		}
		
		# Section overview
		$section = $args[0];
		if (true === Common::isNumeric($section))
		{
			if (false === ($section = $this->getSectionFromNumber($section)))
			{
				return $this->displaySurgeryHelp($player);
			}
		}
		if (true === in_array($section, self::$SECTIONS))
		{
			return $this->displaySurgeryPrices($player, $section);
		}
		
		# Suregery downgrade
		return $this->onSurgeryB($player, $section);
	}
	
	private function onSurgeryB(SR_Player $player, $field)
	{
		echo "Got $field\n";
		$field = Shadowfunc::unshortcutVariable($player, $field); # rü => armor
		echo "Got $field\n";
		$field = Shadowfunc::untranslateVariable($player, $field); # rüstung => armor
		echo "Got $field\n";
		
		if ($field === 'essence')
		{
			$player->msg('1176', array($field)); # You cannot do surgery on your %s.
			return false;
		}
		
		if (true === in_array($field, SR_Player::$ATTRIBUTE))
		{
			$price = $this->getAttributePrice($field);
			$section = 'attribute';
		}
		elseif (true === in_array($field, SR_Player::$SKILL))
		{
			$price = $this->getSkillPrice($field);
			$section = 'skill';
		}
		elseif (Shadowfunc::isSpell($field))
		{
			if ($player->getSpellBaseLevel($field) === -1)
			{
				$player->msg('1048'); # You don't have this spell.
				return false;
			}
			
			$price = $this->getSpellPrice($field);
			$section = 'spell';
		}
		elseif (true === in_array($field, SR_Player::$KNOWLEDGE))
		{
			$price = $this->getKnowledgePrice($field);
			$section = 'knowledge';
		}
		elseif ( ($field === 'male') || ($field === 'female') )
		{
			$price = $this->getGenderPrice($field);
			$section = 'gender';
		}
		elseif (true === in_array($field, array_keys(SR_Player::$RACE)))
		{
			$price = $this->getRacePrice($field);
			$section = 'race';
		}
		else
		{
			$player->msg('1176', array($field)); # You cannot do surgery on your %s.
			return false;
		}
		
		if ($price === false)
		{
			$player->msg('1176', array($field)); # You cannot do surgery on your %s.
			return false;
		}
		
		$dprice = Shadowfunc::displayNuyen($price);
		if ($price > $player->getNuyen())
		{
			$player->msg('1063', array($dprice, $player->displayNuyen()));
			return false;
		}
		
		if (false === ($cost = Shadowcmd_lvlup::getKarmaCostFactor($field)))
		{
// 			$player->message('Database error 1!');
// 			return false;
		}
		
		$karma_back = 0;
		
		switch ($section)
		{
			case 'skill':
			case 'knowledge':
			case 'attribute':
				
				if ($cost === false)
				{
					$player->message('Database error 2.2!');
					return false;
				}
				
				# Get the minimum base
				if (0 > ($racebase = $player->getRaceBaseVar($field, -1)))
				{
					$racebase = 0;
// 					$player->message('Database error 2!');
// 					return false;
				}
				
				# Get current base
				if (false === ($current = $player->getBase($field)))
				{
					$player->message('Database error 3!');
					return false;
				}
				
				# Reached min?
				if ($current <= $racebase)
				{
					$player->msg('1177', array($field, $racebase));
					return false;
				}
				
				$karma_back = $cost * $current;
				
				if (false === $player->increaseField($field, -1))
				{
					$player->message('Database error 5!');
					return false;
				}
				
				$current--;
				
				break;
				
			case 'spell':
				
				if ($cost === false)
				{
					$player->message('Database error 2.2!');
					return false;
				}
				
				# Get current base
				if (-1 === ($current = $player->getSpellBaseLevel($field)))
				{
					$player->message('Database error 3!');
					return false;
				}
				
				# Reached min?
				if ($current <= 0)
				{
					$player->msg('1177', array($field, $racebase));
					return false;
				}
				
				$karma_back = $cost * $current;
				
				if (false === $player->levelupSpell($field, -1))
				{
					$player->message('Database error 7-1!');
					return false;
				}
				
				$current--;
				
				break;
			
			case 'gender':
				if (false === $player->saveBase($section, $field))
				{
					$player->message('Database error 6.1!');
				}
				
				$current = $field;
				
				break;
				
			case 'race':
				$player->message('Database Error 0.8.15');
				return false;
				
			default:
				$player->msg('1176', array($field));
				return false;
		}
		
		if (false === $player->pay($price))
		{
			$player->message('Database error 0.1!');
			return false;
		}
		
		if (false === $player->increaseField('karma', $karma_back))
		{
			$player->message('Database error 0.2!');
			return false;
		}
		
// 		if (false === $player->alterField($field, $by))
// 		{
// 			$player->message('Database error 0.1!');
// 			return false;
// 		}
		
		$player->modify();
		
		$essence_lost = 0;
		
		return $player->msg('5263', array($dprice, $field, $current, $essence_lost, $karma_back)); # You paid %s and got your %s changed to %s. You lost %s essence while getting %s karma back.
	}
	
	private function getSectionFromNumber($index)
	{
		$index = (int)$index;
		if ( ($index < 1) || ($index > count(self::$SECTIONS)) )
		{
			return false;
		}
		return self::$SECTIONS[$index-1];
	}
	
	private function displaySurgeryHelp(SR_Player $player)
	{
		return Shadowrap::instance($player)->reply(Shadowhelp::getHelp($player, 'surgery'));
	}
	
	private function displayAllSurgeryPrices(SR_Player $player)
	{
		$out = '';
		$format = $player->lang('fmt_rawitems');
		$i = 1;
		foreach (self::$SECTIONS as $section)
		{
			$out .= sprintf($format, $i++, $section);
		}
		return $player->msg('5262', array(substr($out, 2)));
	}
	
	private function displaySurgeryPrices(SR_Player $player, $section=NULL)
	{
		if ($section === NULL)
		{
			return $this->displayAllSurgeryPrices($player);
		}
		
		$prices = array();
		
		switch ($section)
		{
			case 'race':
				foreach (SR_Player::$RACE as $race => $data)
				{
					if (false !== ($price = $this->getRacePrice($race)))
					{
						$prices[$race] = $price;
					}
				}
				break;
				
			case 'skill':
				foreach (SR_Player::$SKILL as $skill)
				{
					if (false !== ($price = $this->getSkillPrice($skill)))
					{
						$prices[$skill] = $price;
					}
				}
				break;
				
			case 'gender':
				foreach (array('male', 'female') as $gender)
				{
					if (false !== ($price = $this->getGenderPrice($gender)))
					{
						$prices[$gender] = $gender;
					}
				}
				break;
				
			case 'attribute':
				foreach (SR_Player::$ATTRIBUTE as $attribute)
				{
					if (false !== ($price = $this->getAttributePrice($attribute)))
					{
						$prices[$attribute] = $price;
					}
				}
				break;
				
			case 'spell':
				foreach (SR_Spell::getSpells() as $spell)
				{
					$spell instanceof SR_Spell;
					$spellname = $spell->getName();
					if (false !== ($price = $this->getSpellPrice($spellname)))
					{
						$prices[$spellname] = $price;
					}
				}
				break;
				
			case 'knowledge':
				foreach (SR_Player::$KNOWLEDGE as $knowledge)
				{
					if (false !== ($price = $this->getKnowledgePrice($knowledge)))
					{
						$prices[$knowledge] = $price;
					}
				}
				break;
				
			default:
				return $this->displayAllSurgeryPrices($player);
		}
		
		return $this->displaySurgeryPricesB($player, $section, $prices);
	}
	
	private function displaySurgeryPricesB(SR_Player $player, $section, array $prices)
	{
		$out = '';
		$format = $player->lang('fmt_rawitems');
		$i = 1;
		foreach ($prices as $field => $price)
		{
			$out .= sprintf($format, $field, Shadowfunc::displayNuyen($price));
		}
		
		if ($out === '')
		{
			$out = ', '.$player->lang('none');
		}
		
		return $player->msg('5262', array(substr($out, 2)));
	}
}
?>
