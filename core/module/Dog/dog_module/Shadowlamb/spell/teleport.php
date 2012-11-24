<?php
class Spell_teleport extends SR_Spell
{
	public function getSpellLevel() { return 2; }
	
	const MANA_MIN = 10;
	const MANA_PER_M = 5;
	
	public function isOffensive() { return false; }
	public function getHelp() { return 'Teleport your party outside a known place in the same city.'; }
	public function getCastTime($level) { return 60; }
	public function getRequirements() { return array('magic'=>5); }
	public function getManaCost(SR_Player $player, $level)
	{
		$p = $player->getParty();
		return self::MANA_MIN + self::MANA_PER_M * $p->getMemberCount();
	}
	public function cast(SR_Player $player, SR_Player $target, $level, $hits, SR_Player $potion_player) {}
	
	public function onCast(SR_Player $player, array $args, $wanted_level=true)
	{
		echo "Casting teleport with ... ".implode(',', $args)." L$wanted_level\ņ";
		
		if (true === $this->isBrewMode())
		{
			return $this->onBrew($player, 30, 2, 5);
		}
		
		echo "Casting teleport with ... ".implode(',', $args)." L$wanted_level\ņ";
		
		$p = $player->getParty();
		
		if (false === $p->isIdle())
		{
			$player->msg('1033');
// 			$player->message('This spell only works when your party is idle.');
			return false;
		}
		
		if (count($args) === 0)
		{
			$player->msg('1072');
// 			$player->message('Please specify a target to teleport to.');
			return false;
		}

		$bot = Shadowrap::instance($player);
		
		if (false === ($tlc = Shadowcmd_goto::getTLCByArg($player, $args[0])))
		{
			$player->msg('1069');
// 			$player->message('This location is unknown.');
			return false;
		}

		$cityclass = $p->getCityClass();
		
		if (false === ($target = $cityclass->getLocation($tlc)))
		{
			$player->msg('1070', array($p->getCity()));
// 			$bot->reply(sprintf('The location %s does not exist in %s.', $tlc, $p->getCity()));
			return false;
		}
		$tlc = $target->getName();
		if (!$player->hasKnowledge('places', $tlc))
		{
			$player->msg('1023');
// 			$bot->reply(sprintf('You don`t know where the %s is.', $tlc));
			return false;
		}
		
		if ($p->getLocation() === $tlc)
		{
			$player->msg('1071', array($tlc));
// 			$bot->reply(sprintf('You are already at the %s.', $tlc));
			return false;
		}

		# Imprisoned
		if (false !== ($loc = $p->getLocationClass('inside')))
		{
			if (!$loc->isExitAllowed($player))
			{
				$player->msg('1074');
// 				$bot->reply('You cannot cast teleport inside this lcoation.');
				return false;
			}
		}
		
		# Minlevels (thx sabretooth)
		if (false === $this->checkCityTargetLimits($player, $target))
		{
			return false;
		}

		$level = $this->getLevel($this->getCaster());
		
		$mc = $p->getMemberCount();
		$need_level = $mc / 2;
		if ($level < $need_level)
		{
			$player->msg('1076', array($this->getName(), $need_level, $mc));
			return false;
// 			$bot->reply(sprintf('You need at least teleport level %s to teleport %s party members.', $need_level, $mc));
// 			return false;
		}
		
		$need = $this->getManaCost($player, $need_level);
		$have = $player->getMP();
		if ($need > $have)
		{
			$player->msg('1055', array($need, $this->getName(), $need_level, $have));
			return false;
// 			$player->message(sprintf('You need %s MP to cast %s, but you only have %s.', $need, $this->getName(), $have));
// 			return false;
		}

		if (true === $this->isCastMode())
		{
			$player->healMP(-$need);
		}
		$p->ntice('5133', array($player->getName(), $need, $this->getName(), $tlc));
// 		$p->notice(sprintf('%s used %s MP to cast teleport and your party is now outside of %s.', $player->getName(), $need, $tlc));
		$p->pushAction('outside', $tlc);
		return true;
	}
	
	public function checkCityTargetLimits(SR_Player $player, SR_Location $target)
	{
		$p = $player->getParty();
		
		if (false === ($city = $target->getCityClass()))
		{
			return false;
		}
		
		$minlvl = $city->getMinLevel();
		
		if ($minlvl < 0)
		{
			$player->message('You cannot teleport there, because the cities minlevel is invalid(BUG)!');
			return false;
		}
		
		$errors = '';
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$lvl = $member->getBase('level');
			if ($lvl < $minlvl)
			{
				$errors .= sprintf(', %s(L%s)', $member->getName(), $lvl);
			}
		}

		if ($errors !== '')
		{
			$errors = substr($errors, 2);
			$player->msg('1075', array($city->getName(), $errors, $minlvl));
// 			return sprintf('You cannot teleport to %s because %s do(es) not have the min level of %s.', $city->getName(), $errors, $minlvl);
			return false;
		}
		
		return true;
	}
	
	public function onBrew(SR_Player $player, $mp, $diff, $hits)
	{
		if ($player->getMP() < $mp)
		{
			$player->msg('1077', array($mp, $player->getMP()));
// 			$player->message(sprintf('You need %s MP to brew this potion, but you got only %s.', $mp, $player->getMP()));
			return false;
		}
		$player->healMP(-$mp);

		$es = $player->get('essence');
		$al = $player->get('alchemy');
		$wi = $player->get('wisdom');
		$dices = $es*3 + $al*2 + $wi;
		$hit = Shadowfunc::dicePool($dices, $diff, $diff);
		
		return $hit >= $hits;
	}
}
?>