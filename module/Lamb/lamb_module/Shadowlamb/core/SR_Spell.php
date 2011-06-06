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
	public abstract function getManaCost(SR_Player $player);
	public abstract function cast(SR_Player $player, SR_Player $target, $level, $hits);

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
	
	
	/**
	 * @param SR_Player $player
	 * @param array $args
	 * @return SR_Player
	 */
	public function getTarget(SR_Player $player, array $args)
	{
		if ($this->isOffensive()) {
			$target = Shadowfunc::getOffensiveTarget($player, $args[0]);
		} else {
			$target = Shadowfunc::getFriendlyTarget($player, $args[0]);
		}
		
		if ($target === false) {
			$player->message('The target is unknown');
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
	public function hasEnoughMP(SR_Player $player)
	{
		return $this->getManaCost($player) <= $player->getMP();
	}
	
	public function onCast(SR_Player $player, array $args)
	{
		if ($this->isOffensive()) {
			if (!$player->isFighting()) {
				$player->message(sprintf('The spell %s works in combat only.', $this->getName()));
				return false;
			}
			if (count($args) === 0) {
				$args[] = rand(1, $player->getEnemyParty()->getMemberCount());
			}
		}
		
		else
		{
			if (count($args) === 0) {
				$args[] = $player->getName();
			}
		}
		
		if (false === ($target = $this->getTarget($player, $args))) {
			return false;
		}
		
		$need = $this->getManaCost($player);
		$have = $player->getMP();
		
		if ($need > $have) {
			$player->message(sprintf('You need %s MP to cast %s, but you only have %s.', $need, $this->getName(), $have));
			return false;
		}
		
		$level = $this->getLevel($player);
		$hits = $this->dice($player, $target, $level);
		
		if ($player->isFighting())
		{
			$busy = Shadowfunc::displayBusy($player->busy($this->getCastTime($level)));
		}
		
		if ($hits < $target->get('essence')*2)
		{
			$waste = round($need/2, 1);
			$player->healMP(-$waste);
			$player->message(sprintf('You failed to cast %s. %s MP wasted.%s', $this->getName(), $waste, $busy));
			return true;
		}
		
		$player->healMP(-$need);
		
		return $this->cast($player, $target, $level, $hits);
	}
	
	protected function dice(SR_Player $player, SR_Player $target, $level)
	{
		return $this->isOffensive() ? $this->diceOffensive($player, $target, $level) : $this->diceDefensive($player, $target, $level);
	}

	private function diceOffensive(SR_Player $player, SR_Player $target, $level)
	{
		$dices = round($level * 10);
		$dices += round($player->get('intelligence') * 5);
		$dices += round($player->get('essence') * 20);
		$dices -= round(Shadowfunc::calcDistance($player, $target)/4);
		
		$defense = round($target->get('essence') * 2);
		$defense += round($target->get('intelligence') * 2);

		return Shadowfunc::dicePool($dices, $defense, 2);
	}

	private function diceDefensive(SR_Player $player, SR_Player $target, $level)
	{
		$dices = round($level * 10);
		$dices += round($player->get('intelligence') * 5);
		$dices += round($player->get('essence') * 15);
		
		# To have supportive defense is bad.
		$es = $target->get('essence');
		$defense = Common::clamp(($es/6), 0.1, 1.0); # 0.1-1.0 compared against base essence
		$dices *= $defense; # percent of dices
		
		# The dice defense
		$defense = Common::clamp(self::MAX_ESSENCE-$es, 2, self::MAX_ESSENCE); # roll a 1-8 against essence

		return Shadowfunc::dicePool($dices, $defense, 2);
	}
	
	################
	### Announce ###
	################
	public function getAnnounceMessage(SR_Player $player, SR_Player $target, $level)
	{
		return sprintf('%s casts a level %s %s on %s', $player->getName(), $level, $this->getName(), $target->getName());
	}

	public function announceADV(SR_Player $player, SR_Player $target, $level, $append='', $append_ep='')
	{
		$msg = $this->getAnnounceMessage($player, $target, $level);
		$p = $player->getParty();
		$p->notice($msg.$append.'.');
		if ($p->isFighting()) {
			$p->getEnemyParty()->notice($msg.$append_ep.'.');
		}
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
	public function spellDamageSingleTarget(SR_Player $player, SR_Player $target, $level, $damage)
	{
		$damage = round($damage, 1);
		if ($damage <= 0) {
			$append = $append_ep = ' but caused no damage';
			$this->announceADV($player, $target, $level, $append, $append_ep);
			return true;
		}
		
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		$mc = $p->getMemberCount();
		
		
		$target->dealDamage($damage);
		if ($target->isDead())
		{
			$append = $append_ep = ' and kills him with '.$damage.' damage';
			$this->announceADV($player, $target, $level, $append, $append_ep);

			# Loot him!
			$xp = $target->getLootXP();
			$ny = round($target->getLootNuyen() / $mc, 1);
			$pxp = 0;
			
			foreach ($p->getMembers() as $member)
			{
				$lxp = $xp/$mc;
				$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
				$lxp *= $leveldiff;
				$lxp = round(Common::clamp($lxp, 0.01), 2);
				$pxp += $lxp;
				$member->giveXP($lxp);
				$member->giveNuyen($ny);
				$member->message(sprintf('You loot %s Nuyen and %s XP.', $ny, $lxp));
			}
			
			$p->givePartyXP($pxp);
			
			$target->gotKilledBy($player);

			if ($ep->getMemberCount() === 0) {
				$p->onFightDone();
			}
			
			return true;
		}
		else # just some dmg
		{
			$hp = $target->getHP();
			$maxhp = $target->getMaxHP();
			$append = " and caused {$damage} damage";
			$append_ep = "{$append} ($hp/$maxhp)HP left.";
			$this->announceADV($player, $target, $level, $append, $append_ep);
			return true;
		}
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
		$p = $player->getParty();
		$mc = $p->getMemberCount();
		$ep = $p->getEnemyParty();
		
		$loot_xp = array();
		$loot_ny = array();
		foreach ($p->getMembers() as $member)
		{
			$loot_xp[$member->getID()] = 0;
			$loot_ny[$member->getID()] = 0;
		}
		
		
		$out = '';
		$out_ep = '';
		foreach ($damage as $pid => $dmg)
		{
			if ($dmg <= 0) {
				continue; 
			}
			
			$target = $ep->getMemberByPID($pid);
			$target->dealDamage($dmg);
			
			if ($target->isDead())
			{
				$xp = $target->getLootXP();
				$nuyen = $target->getLootNuyen();
				$target->resetXP();
				$target->giveNuyen(-$nuyen);
				
				$out .= sprintf(', kills %s with %s', $target->getName(), $dmg);
				$out_ep .= sprintf(', kills %s with %s', $target->getName(), $dmg);
				$pxp = 0;
				foreach ($p->getMembers() as $member)
				{
					$lxp = $xp/$mc;
					$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
					$lxp *= $leveldiff;
					$lxp = round(Common::clamp($lxp, 0.01), 2);
					$pxp += $lxp;

					$loot_xp[$member->getID()] += $lxp;
					$loot_ny[$member->getID()] += $nuyen / $mc;
				}
				$p->givePartyXP($pxp);
				
			}
			else 
			{
				$out .= sprintf(', hits %s with %s damage', $target->getName(), $dmg);
				$out_ep .= sprintf(', hits %s with %s(%s/%s)HP left', $target->getName(), $dmg, $target->getHP(), $target->getMaxHP());
			}
		}

		if ($out === '') {
			return;
		}
		
		$out = substr($out, 2);
		foreach ($p->getMembers() as $member)
		{
			$loot_out = '';
			
			$ny = $loot_ny[$member->getID()];
			$xp = $loot_xp[$member->getID()];
			
			if ($ny > 0 || $xp > 0)
			{
				$loot_out = sprintf('. You loot %s Nuyen and %s XP', $ny, $xp);
				$member->giveNuyen($ny);
				$member->giveXP($xp);
			}
			
			$member->message($out.$loot_out.'.');
		}
		
		$out_ep = substr($out_ep, 2);
		$ep->message($player, $out_ep.'.');
		
		foreach ($ep->getMembers() as $target)
		{
			if ($target->isDead())
			{
				$target->gotKilledBy($player);
			}
		}
		
		if ($ep->getMemberCount() === 0)
		{
			$p->onFightDone();
		}
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
	public function isOffensive() { return true; }
	public function getRange() { return 10; }
}

?>
