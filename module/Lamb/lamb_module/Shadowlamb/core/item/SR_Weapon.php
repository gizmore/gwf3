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
		
		if (abs($player->getDistance()-$target->getDistance()) > $this->getItemRange()) {
			$player->getParty()->moveTowards($player, $target);
			return false;
		}
		
		$player->busy($this->getAttackTime());
		
		$msg = sprintf(' attacks %s with %s', $target->getName(), $this->getName());
		$hpmsg = $lootmsg = '';
		
		$mindmg = $player->get('min_dmg');
		$arm = $target->get($armor_type);
		
		$atk = ($player->get('attack'));
		$def = ($target->get('defense'));
		
		$oops = $player->isHuman() ? 10 : 4;
		
		$chances = (($atk*6 + $mindmg*6) / ($def*3 + $arm*3)) * $oops;
		
		
		
		
		$hits = Shadowfunc::dicePool((int)$chances, 3, 1);
		
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
			if ($damage > 0.0) {
				$target->dealDamage($damage);
			}
			if ($damage === 0.0) {
				$msg .= sprintf(' but causes no damage.');
				$hpmsg = sprintf(' %s/%s HP left.', $target->getHP(), $target->get('max_hp')); 
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
				$msg .= sprintf(' and kills him with %s damage!', $damage);
			}
			else
			{
				$msg .= sprintf(' and causes %s damage.', $damage);
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
	}
}
?>