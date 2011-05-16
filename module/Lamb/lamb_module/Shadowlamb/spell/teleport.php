<?php
final class Spell_teleport extends SR_Spell
{
	const MANA_MIN = 10;
	const MANA_PER_M = 5;
	
	public function isOffensive() { return false; }
	public function getHelp(SR_Player $player) { return 'Teleport your party outside a known place in the same city.'; }
	public function getCastTime($level) { return 60; }
	public function getRequirements() { return array('magic'=>5); }
	public function getManaCost(SR_Player $player)
	{
		$p = $player->getParty();
		return self::MANA_MIN + self::MANA_PER_M * $p->getMemberCount();
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits) {}
	
	public function onCast(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		
		if (!$p->isIdle()) {
			$player->message('This spell only works when your party is idle.');
			return false;
		}
		
		if (count($args) === 0) {
			$player->message('Please specify a target to teleport to.');
			return false;
		}
		
		$tlc = $args[0];
		$cityclass = $p->getCityClass();
		if (is_numeric($tlc))
		{
			$tlc = $player->getKnowledgeByID('places', $tlc);
		}
		if (false === ($target = $cityclass->getLocation($tlc)))
		{
			$bot->reply(sprintf('The location %s does not exist in %s.', $tlc, $cityname));
			return false;
		}
		$tlc = $target->getName();
		if (!$player->hasKnowledge('places', $tlc)) {
			$bot->reply(sprintf('You don`t know where the %s is.', $tlc));
			return false;
		}
		
		if ($p->getLocation('inside') === $tlc || $p->getLocation('outside') === $tlc) {
			$bot->reply(sprintf('You are already at the %s.', $tlc));
			return false;
		}
		
		$level = $this->getLevel($player);
		
		$mc = $p->getMemberCount();
		$need_level = $mc / 2;
		if ($level < $mc) {
			$bot->reply(sprintf('You need at least teleport level %s to teleoport %s party members.', $need_level, $mc));
			return false;
		}
		
		$need = $this->getManaCost($player);
		$have = $player->getMP();
		if ($need > $have) {
			$player->message(sprintf('You need %s MP to cast %s, but you only have %s.', $need, $this->getName(), $have));
			return false;
		}

		$player->healMP(-$need);
		$p->notice(sprintf('%s used %s MP to cast teleport and your party is now outside of %s.', $player->getName(), $need, $tlc));
		$p->pushAction('outside', $tlc);
		return true;
	}
	
}
?>