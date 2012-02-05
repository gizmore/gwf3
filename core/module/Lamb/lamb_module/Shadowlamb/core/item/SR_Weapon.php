<?php
abstract class SR_Weapon extends SR_Equipment
{
	public function getAttackTime() { return 30; }
	public function getItemType() { return 'weapon'; }
	public abstract function getItemModifiersW(SR_Player $player);
	public abstract function onAttack(SR_Player $player, $target);
	public abstract function onReload(SR_Player $player);

	public function onAttackB(SR_Player $player, $arg, $armor_type)
	{
		$p = $player->getParty();
		$mc = $p->getMemberCount();
		$ep = $p->getEnemyParty();
		$emc = $ep->getMemberCount();
		
		if (false === ($target = $this->getOffensiveTarget($player, $arg)))
		{
			return false;
		}
		
		$d = abs($player->getY()-$target->getY());
		$d2 = Common::clamp($d-2, 0);
		
		if ($d > $this->getItemRange())
		{
			$player->getParty()->moveTowards($player, $target);
			return true;
		}
		
		if ($this instanceof SR_FireWeapon)
		{
			$this->increase('sr4it_ammo', -$this->getBulletsPerShot());
		}
		
		# Bows are great for distance
		if ($this instanceof SR_Bow)
		{
			$d2 /= 4;
		}
		elseif ($this instanceof SR_MeleeWeapon)
		{
			$d2 = 0;
		}
		
		$busy = $player->busy($this->getAttackTime());
		
		$mindmg = $player->get('min_dmg');
		$maxdmg = $player->get('max_dmg');
		$arm = $target->get($armor_type);
		$atk = round(Common::clamp(($player->get('attack')-$d2*1.2), 1));
		$def = ($target->get('defense'));
		$hits = Shadowfunc::diceHits($mindmg, $arm, $atk, $def, $player, $target);
		
		$pname = $player->displayNameNB();
		$tname = $target->displayNameNB();
		$iname = $this->getName();
		
		# Debug
//		Lamb_Log::logDebug(sprintf('%s (ATK: %s HP: %s) vs. %s (DEF: %s HP: %s) = HITS: %s',$player->getName(),$atk,$player->getHP(),$target->getName(),$def,$target->getHP(),$hits));
		
		# Miss
		if ($hits < 1)
		{
			$p->ntice('5230', array($pname, $tname, $iname, $busy));
			$ep->ntice('5230', array($pname, $tname, $iname, $busy));
			return true;
// 			$msg .= ' but misses.';
		}
		
		# Hit
		$damage = $hits * 0.1;
		$damage = round(Common::clamp($damage, 0.0, $maxdmg), 1);

		# Crit?
		$sharp = $player->getCritPermille();
		if (rand(0, 1000) < $sharp)
		{
			$damage += Shadowfunc::diceFloat(1.0, $hits*0.1+1.0, 1);
			$crit = 1;
			$bold = "\X02";
		}
		else
		{
			$crit = false;
			$bold = '';
		}

		# No damage
		if ($damage <= 0)
		{
			$p->ntice('5231', array($pname, $tname, $iname, $busy));
			$p->ntice('5231', array($pname, $tname, $iname, $busy));
			return true;
// 			$msg .= sprintf(' but causes no damage.');
// 			$hpmsg = sprintf(' %s/%s HP left.', round($target->getHP(), 1), round($target->get('max_hp'), 1));
		}

		
		$target->dealDamage($damage);

		# Some damage
		if (false === $target->isDead())
		{
			$p->ntice('5232', array($pname, $tname, $iname, $damage, $busy, $bold, $crit));
			$ep->ntice('5233', array($pname, $tname, $iname, $damage, $target->getHP(), $target->getMaxHP(), $busy, $bold, $crit));
			return true;
		}
		
		###########
		# Killed! #
		###########
		$xp = $target->isHuman() ? 0 : $target->getLootXP();
		$nuyen = $target->getLootNuyen();
		if ($player->isNPC())
		{
			$target->resetXP();
		}
		$target->giveNuyen(-$nuyen);

		$tl = $target->getBase('level');
		
		$ploot = array();
		
		$pxp = 0;
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$lxp = $xp/$mc;
			$leveldiff = ($tl+1) / ($member->getBase('level')+1);
			$lxp *= $leveldiff;
			$lxp = round(Common::clamp($lxp, 0.01), 2);

			$pxp += $lxp;
			$member->giveXP($lxp);
			$lny = round($nuyen/$mc, 2);
			$member->giveNuyen($lny);
			$member->msg('5234', array($pname, $tname, $iname, $damage, $busy, $lxp, $lny, $bold, $crit));
			$member->setOption(SR_Player::STATS_DIRTY, true);
		}
				
		$p->givePartyXP($pxp);
				
		$ep->ntice('5235', array($pname, $tname, $iname, $damage, $busy, $bold, $crit));
		
		$target->gotKilledBy($player);
		if ($emc === 1)
		{
			$p->onFightDone();
		}
		
		return true;
	}
}
?>