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
		
		if (false === ($target = $this->getOffensiveTarget($player, $arg))) {
			return false;
		}
		
		$d = abs($player->getDistance()-$target->getDistance());
		
		if ($d > $this->getItemRange()) {
			$player->getParty()->moveTowards($player, $target);
			return false;
		}
		
		$player->busy($this->getAttackTime());
		
		$msg = sprintf(' attacks %s with %s', $target->getName(), $this->getName());
		$hpmsg = $lootmsg = '';
		
		$mindmg = $player->get('min_dmg');
		$arm = $target->get($armor_type);
		$atk = Common::clamp(($player->get('attack')-$d*2), 2);
		$def = ($target->get('defense'));
		$hits = Shadowfunc::diceHits($mindmg, $arm, $atk, $def, $player, $target);
		
		# Dice Hits
//		$hits = 0;
//		for ($i = 0; $i < $atk; $i++)
//		{
//			if (Shadowfunc::dice($def, 8))
//			{
//				$hits++;
//			}
//		}
		
		# Debug
		Lamb_Log::log(sprintf('%s (ATK: %s HP: %s) vs. %s (DEF: %s HP: %s) = HITS: %s',$player->getName(),$atk,$player->getHP(),$target->getName(),$def,$target->getHP(),$hits));
		
		# Miss
		if ($hits === 0) {
			$msg .= ' but misses.';
		}
		
		# Hit
		else
		{
			$damage = $hits * 0.1;
//			$damage = $player->get('min_dmg') + ($hits*0.1);
//			$damage -= $target->get($armor_type);
			$damage = round(Common::clamp($damage, 0.0, $player->get('max_dmg')), 2);
			
			$sharp = $player->get('sharpshooter') * 10;
			if (rand(0, 1000) < $sharp) {
				$damage += rand(0, $damage);
				$crit = ' critically';
			} else {
				$crit = '';
			}
			
			if ($damage > 0.0) {
				$target->dealDamage($damage);
			}
			if ($damage === 0.0) {
				$msg .= sprintf(' but causes no damage.');
				$hpmsg = sprintf(' %s/%s HP left.', round($target->getHP(), 1), round($target->get('max_hp'), 1)); 
			}
			elseif ($target->isDead())
			{
				$xp = $target->getLootXP();
				$nuyen = $target->getLootNuyen();
				$target->resetXP();
				$target->giveNuyen(-$nuyen);
				
//				$target->getBase('level');
//				$player->getBase('level');
				
				foreach ($p->getMembers() as $member)
				{
					$member instanceof SR_Player;
					$lxp = $xp/$mc;

//					$lxp += $target->getBase('level') - $member->getBase('level');
					
					$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
					$lxp *= $leveldiff;
					$lxp = round(Common::clamp($lxp, 0.01), 2);

					$member->giveXP($lxp);
					$member->giveNuyen($nuyen/$mc);
					$lootmsg[] = sprintf(' You loot %s and %.02f XP.', Shadowfunc::displayPrice($nuyen/$mc), $lxp);
					$member->setOption(SR_Player::STATS_DIRTY, true);
				}
				
//				$lootmsg = sprintf(' You loot %s and %.02f XP.', Shadowfunc::displayPrice($nuyen/$mc), $xp/$mc);
//				$p->giveLoot($xp, $nuyen);
				$msg .= sprintf(' and kills him%s with %s damage!', $crit, $damage);
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
			$member->message($player->getName().$msg.$lmsg);
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