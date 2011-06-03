<?php
final class Spell_teleport2 extends SR_Spell
{
	public function getSpellLevel() { return 3; }
	
	const MANA_MIN = 15;
	const MANA_PER_M = 10;
	
	public function isOffensive() { return false; }
	public function getHelp() { return 'Teleport your party outside a known place.'; }
	public function getCastTime($level) { return 60; }
	public function getRequirements() { return array('magic'=>6,'teleport'=>1); }
	public function getManaCost(SR_Player $player)
	{
		$p = $player->getParty();
		return self::MANA_MIN + self::MANA_PER_M * $p->getMemberCount();
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits) {}
	
	public function onCast(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		
		if (!$p->isIdle())
		{
			$player->message('This spell only works when your party is idle.');
			return false;
		}
		
		if (count($args) === 0)
		{
			$player->message('Please specify a target to teleport to.');
			return false;
		}

		$bot = Shadowrap::instance($player);
		
		$tlc = $args[0];
		if (is_numeric($tlc))
		{
			$tlc = $player->getKnowledgeByID('places', $tlc);
		}
		
		$city = Common::substrUntil($tlc, '_');
		if (false === ($cityclass = Shadowrun4::getCity($city)))
		{
			$bot->reply('This city is unknown.');
			return false;
		}
		
		if ($cityclass->isDungeon())
		{
			$bot->reply('You can not teleport into dungeons.');
			return false;
		}
		
		if (false === ($target = $cityclass->getLocation($tlc)))
		{
			$bot->reply(sprintf('The location %s does not exist in %s.', $tlc, $city));
			return false;
		}
		
		$tlc = $target->getName();
		if (!$player->hasKnowledge('places', $tlc))
		{
			$bot->reply(sprintf('You don`t know where the %s is.', $tlc));
			return false;
		}
		
		if ($p->getLocation('inside') === $tlc || $p->getLocation('outside') === $tlc)
		{
			$bot->reply(sprintf('You are already at the %s.', $tlc));
			return false;
		}
		
		$level = $this->getLevel($player);
		
		$mc = $p->getMemberCount();
		$need_level = $mc / 2;
		if ($level < $mc)
		{
			$bot->reply(sprintf('You need at least teleport2 level %s to teleport %s party members.', $need_level, $mc));
			return false;
		}
		
		$need = $this->getManaCost($player);
		$have = $player->getMP();
		if ($need > $have)
		{
			$player->message(sprintf('You need %s MP to cast %s, but you only have %s.', $need, $this->getName(), $have));
			return false;
		}

		$player->healMP(-$need);
		$p->notice(sprintf('%s used %s MP to cast teleport2 and your party is now outside of %s.', $player->getName(), $need, $tlc));
		$p->pushAction('outside', $tlc);
		return true;
	}
	
}
?>