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

	public function getDistance() { return 10.0; }
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
		
		if ($hits < 10) {
			$waste = round($need/2, 1);
			$player->healMP(-$waste);
			$player->message(sprintf('You failed to cast %s. %s MP wasted.', $this->getName(), $waste));
			return true;
		}
		
		$player->healMP(-$need);
		
		return $this->cast($player, $target, $level, $hits);
	}
	
	private function dice(SR_Player $player, SR_Player $target, $level)
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

		return Shadowfunc::dicePool($dices, $defense, $defense);
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
	
	public function announceADV(SR_Player $player, SR_Player $target, $level, $append)
	{
		$msg = $this->getAnnounceMessage($player, $target, $level).'. '.$append;
		$player->getParty()->notice($msg);
		if ($this->isOffensive()) {
			$target->getParty()->notice($msg);
		}
	}

}
?>