<?php
abstract class SR_Spell
{
	################
	### Abstract ###
	################
	public abstract function isOffensive();
	public abstract function getManaCost(SR_Player $player);
	public abstract function getHelp(SR_Player $player);
	public abstract function cast(SR_Player $player, SR_Player $target, $level, $hits);
	public abstract function getCastTime($level);

	public function getDistance() { return 20.0; }
	public function getRequirements() { return array(); }
	
	##############
	### Loader ###
	##############
	private static $spells = array();
	public static function getSpells() { return self::$spells; }
	/**
	 * @param string $name
	 * @return SR_Spell
	 */
	public static function getSpell($name) { return isset( self::$spells[$name]) ? self::$spells[$name] : false; }
	public static function includeSpell($filename, $fullpath)
	{
		$spellname = substr($filename, 0, -4);
		$classname = 'Spell_'.$spellname;
		Lamb_log::log("SR_Spell::includeSpell($classname)");
		require_once $fullpath;
		self::$spells[$spellname] = new $classname($spellname);
	}
	
	#############
	### Spell ###
	#############
	private $name;
	public function __construct($name) { $this->name = $name; }
	public function getName() { return $this->name; }	
	public function getLevel(SR_Player $player)
	{
		return $player->getSpellLevel($this->getName());
	}

	public function getBaseLevel(SR_Player $player)
	{
		return $player->getSpellBaseLevel($this->getName());
	}
	
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
	
	public function checkRequirements(SR_Player $player)
	{
		$back = '';
		foreach ($this->getRequirements() as $spellname => $level)
		{
			if (false !== ($spell = self::getSpell($spellname))) {
				if ($spell->getBaseLevel($player) < $level) {
					$back .= sprintf(', %s level %s', $spellname, $level);
				}
			}
			elseif (in_array($spellname, SR_Player::$ATTRIBUTE)) {
				if ($player->getBase($spellname) < $level) {
					$back .= sprintf(', %s level %s', $spellname, $level);
				}
			}
			elseif (in_array($spellname, SR_Player::$SKILL)) {
				if ($player->getBase($spellname) < $level) {
					$back .= sprintf(', %s level %s', $spellname, $level);
				}
			}
			else {
				Lamb_Log::log(sprintf('Unknown requirement for %s: %s.', $this->getName(), $spellname));
			}
		}
		return $back === '' ? false : substr($back, 2);
	}
	
	#################
	### Base Cast ###
	#################
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
		
		if ($player->isFighting()) {
			$player->busy($this->getCastTime($level));
		}
		
		if ($hits < 10) {
			$waste = round($need/2, 1);
			$player->healMP(-$waste);
			$player->message(sprintf('You failed to cast %s. %s MP wasted.', $this->getName(), $waste));
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
		
		$defense = round($target->get('essence') * 6);
		$defense += round($target->get('intelligence') * 3);

		return Shadowfunc::dicePool($dices, $defense, 2);
	}

	private function diceDefensive(SR_Player $player, SR_Player $target, $level)
	{
		$dices = round($level * 10);
		$dices += round($player->get('intelligence') * 5);
		$dices += round($player->get('essence') * 20);
		
		$defense = (7 - $target->get('essence')) * 15;

		return Shadowfunc::dicePool($dices, $defense, $defense);
	}
	
	public function getAnnounceMessage(SR_Player $player, SR_Player $target, $level)
	{
		return sprintf('%s casts %s level %s on %s', $player->getName(), $this->getName(), $level, $target->getName());
	}

	public function announce(SR_Player $player, SR_Player $target, $level)
	{
		$msg = $this->getAnnounceMessage($player, $target, $level).'.';
		
		$player->getParty()->notice($msg);
		if ($this->isOffensive()) {
			$target->getParty()->notice($msg);
		}
	}
	
	public function announceADV(SR_Player $player, SR_Player $target, $level, $append='', $append_ep='')
	{
		$msg = $this->getAnnounceMessage($player, $target, $level);
		$player->getParty()->notice($msg.$append.'.');
		if ($this->isOffensive()) {
			$target->getParty()->notice($msg.$append_ep.'.');
		}
	}

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
			
			foreach ($p->getMembers() as $member)
			{
				$lxp = $xp/$mc;
				$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
				$lxp *= $leveldiff;
				$lxp = round(Common::clamp($lxp, 0.01), 2);
				$member->message(sprintf('You loot %s Nuyen and %s XP.', $ny, $lxp));
			}
			
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
				
				foreach ($p->getMembers() as $member)
				{
					$lxp = $xp/$mc;
					$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
					$lxp *= $leveldiff;
					$lxp = round(Common::clamp($lxp, 0.01), 2);

					$loot_xp[$member->getID()] += $lxp;
					$loot_ny[$member->getID()] += $nuyen / $mc;
				}
				
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
?>
