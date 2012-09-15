<?php
abstract class SR_Spell
{
	const MAX_ESSENCE = 9;
	
	################
	### Abstract ###
	################
	public function displayType() { return 'Magic Spell'; }
	public function displayClass() { return 'Class '.$this->getSpellLevel(); }
	public function getSpellLevel() { return 1; } # spells own level
	public function getRange() { return -1; }
	public function getRequirements() { return array(); }
	public abstract function getHelp();
	public abstract function isOffensive();
	public abstract function getCastTime($level);
	public abstract function getManaCost(SR_Player $player, $level);
	public abstract function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player);
	
	const MODE_SPELL = 0;
	const MODE_POTION = 1;
	const MODE_BREW = 2;
	private $mode = self::MODE_SPELL;
	public function setMode($mode) { $this->mode = $mode; }
	public function isCastMode() { return $this->mode === self::MODE_SPELL; }
	public function isBrewMode() { return $this->mode === self::MODE_BREW; }
	public function isPotionMode() { return $this->mode === self::MODE_POTION; }
	
	##############
	### Loader ###
	##############
	private static $spells = array();
	public static function getSpells() { return self::$spells; }
	public static function getTotalSpellCount() { return count(self::$spells); }
	
	/**
	 * @param string $name
	 * @return SR_Spell
	 */
	public static function getSpell($name) { return isset( self::$spells[$name]) ? self::$spells[$name] : false; }
	public static function includeSpell($filename, $fullpath)
	{
		$spellname = substr($filename, 0, -4);
		$classname = 'Spell_'.$spellname;
		Lamb_Log::logDebug("SR_Spell::includeSpell($classname)");
		require_once $fullpath;
		self::$spells[$spellname] = new $classname($spellname);
	}
	
	#############
	### Spell ###
	#############
	private $name;
	public function __construct($name) { $this->name = $name; }
	public function getName() { return $this->name; }	
	public function getLevel(SR_Player $player) { return $player->getSpellLevel($this->getName()); }
	public function getBaseLevel(SR_Player $player) { return $player->getSpellBaseLevel($this->getName()); }
	
	private $caster = NULL;
	public function setCaster(SR_Player $player) { $this->caster = $player; }
	public function getCaster() { return $this->caster; }
	
	/**
	 * @param SR_Player $player
	 * @param array $args
	 * @return SR_Player
	 */
	public function getTarget(SR_Player $player, array $args, $verbose=true)
	{
		if ($this->isOffensive())
		{
			$target = Shadowfunc::getOffensiveTarget($player, $args[0]);
		}
		else
		{
			$target = Shadowfunc::getFriendlyTarget($player, $args[0]);
		}
		
		if ($target === false)
		{
			if (true === $verbose)
			{
				$player->msg('1012');
			}
// 			$player->message('The target is unknown');
		}
		
		return $target;
	}
	
	####################
	### Requirements ###
	####################
	public function checkRequirements(SR_Player $player)
	{
		$back = '';
		foreach ($this->getRequirements() as $require => $level)
		{
			if (false !== ($spell = self::getSpell($require)))
			{
				if ($spell->getBaseLevel($player) < $level)
				{
					$back .= sprintf(', %s level %s', $require, $level);
				}
			}
			elseif (in_array($require, SR_Player::$ATTRIBUTE))
			{
				if ($player->getBase($require) < $level)
				{
					$back .= sprintf(', %s level %s', $require, $level);
				}
			}
			elseif (in_array($require, SR_Player::$SKILL))
			{
				if ($player->getBase($require) < $level)
				{
					$back .= sprintf(', %s level %s', $require, $level);
				}
			}
			else
			{
				Lamb_Log::logError(sprintf('Unknown requirement for Spell "%s": %s.', $this->getName(), $require));
			}
		}
		return $back === '' ? false : substr($back, 2);
	}
	
	public function displayRequirements()
	{
		return Shadowfunc::getRequirements($player, $this->getRequirements());
	}
	
	#################
	### Base Cast ###
	#################
	public function hasEnoughMP(SR_Player $player, $level)
	{
		return $this->getManaCost($player, $level) <= $player->getMP();
	}

	public function onCast(SR_Player $player, array $args, $wanted_level=true)
	{
		if ($this instanceof SR_CombatSpell)
		{
			if ($this->mode === self::MODE_BREW)
			{
			}
			elseif (!$player->isFighting())
			{
				$player->msg('1052', array($this->getName()));
// 				$player->message(sprintf('The spell %s works in combat only.', $this->getName()));
				return false;
			}
			elseif (count($args) === 0) {
				$members = $player->getEnemyParty()->getMembers();
				$member = $members[array_rand($members)];
				$args[] = $member->getEnum();
//				$args[] = rand(1, $player->getEnemyParty()->getMemberCount());
			}
		}
		
		else
		{
			if (count($args) === 0)
			{
				$args[] = $player->getName();
			}
		}
		
		if ($this->mode === self::MODE_BREW)
		{
			# Dummy player
			$dummy = new SR_Player(SR_Player::getPlayerData(0));
			$dummy->modify();
			$target = $dummy;
		}
		elseif (false === ($target = $this->getTarget($player, $args)))
		{
			return false;
		}
		
		$level = $this->getLevel($this->getCaster());
		
		if ($this->mode === self::MODE_BREW)
		{
			$level = $wanted_level;
		}
		elseif ($wanted_level !== true)
		{
			$wanted_level = (int)$wanted_level;
			if ($wanted_level < 0)
			{
				$player->msg('1053');
// 				$player->message('You cannot cast a spell with a level smaller than 0.');
				return false;
			}
			elseif ($wanted_level > $level)
			{
				$player->msg('1054', array($this->getName(), $wanted_level, $level));
// 				$player->message(sprintf('You cannot cast %s level %s because your spell level is only %s.', $this->getName(), $wanted_level, $level));
				return false;
			}
			else
			{
				$level = $wanted_level;
			}
		}
		
		$mp_faktor = $this->mode === self::MODE_BREW ? 1.5 : 1.0;
		
		$need = round($this->getManaCost($player, $level)*$mp_faktor, 1);
		$need = Common::clamp($need, 1, 1000000);
		$have = $player->getMP();
		
		if ( ($need > $have) && (false === $this->isPotionMode()) )
		{
			$player->msg('1055', array($need, $this->getName(), $level, $have));
// 			$player->message(sprintf('You need %s MP to cast %s, but you only have %s.', $need, $this->getName(), $have));
			return false;
		}
		
		$hits = $this->dice($this->getCaster(), $target, $level);
		
		echo "!!! CASTED $hits hits !!!\n";
		
		$busy = '';
		if ($player->isFighting())
		{
			$busy = Shadowfunc::displayBusy($player->busy($this->getCastTime($level)));
		}
		
// 		if ($hits < $target->get('essence'))
// 		{
// 			$waste = round($need/2, 1);
// 			$player->healMP(-$waste);
// 			$player->msg('1056', array($this->getName(), $waste, $busy));
// // 			$player->message(sprintf('You failed to cast %s. %s MP wasted.%s', $this->getName(), $waste, $busy));
// 			return false;
// 		}
		
		if (false === $this->isPotionMode())
		{
			$player->healMP(-$need);
		}		
		
		if ($this->mode === self::MODE_BREW)
		{
			return true;
		}
		
		return $this->cast($player, $target, $level, $hits, $player);
	}
	
	public function dice(SR_Player $player, SR_Player $target, $level)
	{
		return $this->isOffensive() ? $this->diceOffensive($player, $target, $level) : $this->diceDefensive($player, $target, $level);
	}

	private function diceOffensive(SR_Player $player, SR_Player $target, $level)
	{
		$dices = round($level * 10);
		$int = $player->get('intelligence');
		$int += Common::pow($level, 1.3);
		$dices += round($int * 5);
		$dices += round($player->get('spellatk') * 6);
		$dices += round($player->get('essence') * 18);
		$dices -= round(Shadowfunc::calcDistance($this->caster, $target)/4); # XXX Cannot apply distance malus because of alchemy.
		
		$defense = round($target->get('essence') * 2);
		$defense += round($target->get('intelligence') * 2);
		$defense += round($target->get('spelldef') * 2);

		echo "Dice Offensive with $dices dices and defense $defense\n";
		return Shadowfunc::dicePoolB($dices, $defense);
// 		return Shadowfunc::dicePool($dices, $defense, 4);
		
	}

	private function diceDefensive(SR_Player $player, SR_Player $target, $level)
	{
		$dices = round($level * 10);
		$int = $player->get('intelligence');
		$int += Common::pow($level, 1.25);
		$dices += round($int * 5);
		$dices += round($target->get('essence') * 15);
		
// 		# To have supportive defense is bad.
		$es = $target->get('essence');
		echo "Target has $es essence\n";
		$defense = 9 - $es * 1.5;
		$defense = Common::clamp($defense, 1.0, 8.0);

		echo "Dice Defensive with $dices dices and defense $defense\n";
		return Shadowfunc::dicePoolB($dices, $defense);
// 		$hits = Shadowfunc::dicePool($dices, $defense, 4);
// 		return rand($hits/2, $hits);
// 		return $hits;
	}
	
	################
	### Announce ###
	################
	public function announceADV(SR_Player $player, SR_Player $target, $level, $key='10000', $arg1='', $arg2='', $arg3='')
	{
		# Pick right keys. Each spell has own 4 keys for all 4 possibilities.
		$key_friend = $key;
		$key_foe = $key+2;
		if ($this->isCastMode())
		{
			$key_friend++;
			$key_foe++;
		}
		$key_friend = (string)$key_friend;
		$key_foe = (string)$key_foe;

		# 8 args
		$args = array($player->displayName(), $level, $this->getName(), $target->displayName(), $arg1, $arg2, $arg3, Shadowfunc::displayBusy($player->getBusyLeft()));
		
		# Announce
		$p = $player->getParty();
		$ep = $target->getParty();
		if ($ep->getID() !== $p->getID())
		{
			$ep->ntice($key_foe, $args);
		}

		if ($this->isCastMode())
		{
			# 9 args
			
			# TODO: this 11 args
// 			$args[] = $this->getManaCost($player, $level);
// 			$args[] = $player->getMP();
// 			$args[] = $player->getMaxMP();
			
			# Old spell style 9 args
			$gain = $this->getManaCost($player, $level);
			$oldmp = $player->getMP() + $gain;
			$maxmp = $player->getMaxMP();
			$args[] = Shadowfunc::displayMPGain($oldmp, -$gain, $maxmp); 
		}

		
		$p->ntice($key_friend, $args);
		
	}
	
	#####################
	### Single Damage ###
	#####################
	/**
	 * Do simple damage to a single target.
	 * Loot the stuff, send messages.
	 * @param SR_Player $player
	 * @param SR_Player $target
	 * @param int $level
	 * @param double $damage
	 */
	public function spellDamageSingleTarget(SR_Player $player, SR_Player $target, $level, $key='10000', $damage)
	{
		$maxhp = $target->getMaxHP();
		$damage = round($damage, 1);
		if ($damage <= 0)
		{
// 			$append = $append_ep = $player->lang('but no damge');
// 			$append = $append_ep = ' but caused no damage';
			$hp = $target->getHP();
			$this->announceADV($player, $target, $level, $key, $damage, $hp, $maxhp);
			return true;
		}
		
		$p = $player->getParty();
		$mc = $p->getMemberCount();
		
		
		$target->dealDamage($damage);
		if ($target->isDead())
		{
// 			$append = $append_ep = ' and kills them with '.$damage.' damage';
			
			$this->announceADV($player, $target, $level, $key, $damage, '0', $maxhp);

			# Loot him!
			$xp = $target->isHuman() ? 0 : $target->getLootXP();
//			$xp = $target->getLootXP();
			$ny = round($target->getLootNuyen() / $mc, 1);
			$pxp = 0;
			if ($player->isNPC())
			{
				$target->resetXP();
			}
			
			foreach ($p->getMembers() as $member)
			{
				$lxp = $xp/$mc;
				$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
				$lxp *= $leveldiff;
				$lxp = round(Common::clamp($lxp, 0.01), 2);
				$pxp += $lxp;
				$member->giveXP($lxp);
				$member->giveNuyen($ny);
				$member->msg('5105', array(Shadowfunc::displayNuyen($ny), $lxp));
// 				$member->message(sprintf('You loot %s Nuyen and %s XP.', $ny, $lxp));
			}
			
			$p->givePartyXP($pxp);
			
			$target->gotKilledBy($player);

		}
		else # just some dmg
		{
			$hp = $target->getHP();
// 			$maxhp = $target->getMaxHP();
// 			$append = " and caused {$damage} damage";
// 			$append_ep = "{$append} ($hp/$maxhp)HP left.";
			$this->announceADV($player, $target, $level, $key, $damage, $hp, $maxhp);
		}

		return true;
	}

	###################
	### Area Damage ###
	###################
	/**
	 * Cause damage to multiple targets.
	 * @param SR_Player $player
	 * @param array $damage
	 * @param int $level
	 */
	public function spellDamageMultiTargets(SR_Player $player, array $damage, $level)
	{
		Shadowfunc::multiDamage($player, $damage, $this->getName());
	}
}

#----------------#
#--- Abstract ---#

abstract class SR_HealSpell extends SR_Spell
{
	public function displayType() { return 'Support Spell'; }
	public function isOffensive() { return false; }
	public function getRange() { return 6; }
}

abstract class SR_SupportSpell extends SR_Spell
{
	public function displayType() { return 'Support Spell'; }
	public function isOffensive() { return false; }
	public function getRange() { return 8; }

	public function getSpellDuration(SR_Player $player, SR_Player $target, $level, $hits)
	{
		$wis = $player->get('wisdom');
		$hits += $level * 10;
		$hits += $wis * 10;
		$hits += rand(-10, +10);
		return round($hits * (5.0 + $level * 0.5));
	}
	
	public function getSpellIncrement(SR_Player $player, SR_Player $target, $level, $hits)
	{
		return round(sqrt($hits)/8, 2);
	}
}

abstract class SR_CombatSpell extends SR_Spell
{
	public function displayType() { return 'Combat Spell'; }
	public function isOffensive() { return false; }
}

abstract class SR_OffensiveSpell extends SR_CombatSpell
{
	public function displayType() { return 'Offensive Combat Spell'; }
	public function isOffensive() { return true; }
	public function getRange() { return 10; }
}

?>
