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
		
//		$player->combatPush("attack ".$target->getName());
		
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
		
		$player->busy($this->getAttackTime());
		
		$msg = sprintf(' attacks %s-%s with %s', $target->getEnum(), $target->getName(), $this->getName());
		$hpmsg = $lootmsg = '';
		
		$mindmg = $player->get('min_dmg');
		$maxdmg = $player->get('max_dmg');
		$arm = $target->get($armor_type);
		$atk = round(Common::clamp(($player->get('attack')-$d2*1.2), 1));
		$def = ($target->get('defense'));
		$hits = Shadowfunc::diceHits($mindmg, $arm, $atk, $def, $player, $target);
		
		# Debug
//		Lamb_Log::logDebug(sprintf('%s (ATK: %s HP: %s) vs. %s (DEF: %s HP: %s) = HITS: %s',$player->getName(),$atk,$player->getHP(),$target->getName(),$def,$target->getHP(),$hits));
		
		# Miss
		if ($hits < 1) {
			$msg .= ' but misses.';
		}
		
		# Hit
		else
		{
			$damage = $hits * 0.1;
//			$damage = Shadowfunc::diceFloat(0.1, $damage*3, 1);

//			$damage = $player->get('min_dmg') + ($hits*0.1);

			$damage = round(Common::clamp($damage, 0.0, $maxdmg), 1);
			
			$sharp = $player->getCritPermille();
			if (rand(0, 1000) < $sharp) {
				$damage += Shadowfunc::diceFloat(1.0, $hits*0.1+1.0, 1);
				$crit = ' critically';
			} else {
				$crit = '';
			}
			
//			$damage -= $arm;
//			$damage -= rand(0, $arm*10)/10;
			
			if ($damage > 0) {
				$target->dealDamage($damage);
			}
			if ($damage <= 0) {
				$msg .= sprintf(' but causes no damage.');
				$hpmsg = sprintf(' %s/%s HP left.', round($target->getHP(), 1), round($target->get('max_hp'), 1)); 
			}
			elseif ($target->isDead())
			{
				$xp = $target->isHuman() ? 0 : $target->getLootXP();
				$nuyen = $target->getLootNuyen();
				if ($player->isNPC())
				{
					$target->resetXP();
				}
				$target->giveNuyen(-$nuyen);
				
//				$target->getBase('level');
//				$player->getBase('level');
				
				$pxp = 0;
				foreach ($p->getMembers() as $member)
				{
					$member instanceof SR_Player;
					$lxp = $xp/$mc;

//					$lxp += $target->getBase('level') - $member->getBase('level');
					
					$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
					$lxp *= $leveldiff;
					$lxp = round(Common::clamp($lxp, 0.01), 2);

					$pxp += $lxp;
					$member->giveXP($lxp);
					$member->giveNuyen($nuyen/$mc);
					$lootmsg[] = sprintf(' You loot %s and %.02f XP.', Shadowfunc::displayNuyen($nuyen/$mc), $lxp);
					$member->setOption(SR_Player::STATS_DIRTY, true);
				}
				
				$p->givePartyXP($pxp);
				
//				$lootmsg = sprintf(' You loot %s and %.02f XP.', Shadowfunc::displayNuyen($nuyen/$mc), $xp/$mc);
//				$p->giveLoot($xp, $nuyen);
				$msg .= sprintf(' and kills them%s with %s damage!', $crit, $damage);
			}
			else
			{
				$msg .= sprintf('%s and causes %s damage.', $crit, $damage);
				$hpmsg = sprintf(' %s/%s HP left.', $target->getHP(), $target->get('max_hp')); 
			}
		}
		
		# Announce it
		$i = 0;
		foreach ($p->getMembers() as $member)
		{
			$lmsg = is_array($lootmsg) ? $lootmsg[$i++] : $lootmsg;
			$member->message($player->getEnum().'-'.$player->getName().$msg.$lmsg);
		}
//		$p->message($player, $msg.$lootmsg);
		$ep->message($player, $msg.$hpmsg);
		
		if ($target->isDead())
		{
			$target->gotKilledBy($player);
			if ($emc === 1) {
				$p->onFightDone();
			}
		}
		
		return true;
	}
}
?>