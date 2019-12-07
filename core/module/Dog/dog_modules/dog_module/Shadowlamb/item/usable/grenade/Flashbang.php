<?php
final class Item_Flashbang extends SR_Grenade
{
	public function getItemDescription() { return 'SHock-Grenade: Will blind and enemy party and does slight party damage.'; }
	public function getItemPrice() { return 150; }
	public function getItemUsetime() { return 15; }
	public function getItemWeight() { return 450; }
	
	public function onThrow(SR_Player $player, SR_Player $target)
	{
		$party = $player->getParty();
		$ep = $party->getEnemyParty();
		$mc = $party->getMemberCount();
		$firearms = $player->get('firearms');
		
		$atk = 15;
		$mindmg = 1;
		$maxdmg = 4;
		
		$damage = array();
		
		$inaccuracy = rand(2,4) - ($firearms?1:0);
		$targets = self::computeDistances($target, $inaccuracy);
		
		foreach ($targets as $data)
		{
			list($pid, $d) = $data;
			$target = $ep->getMemberByPID($pid);
			$target instanceof SR_Player;
			$a = $atk - ($d*$d) + rand(-1,2);

			$a = Common::clamp($a, 0, $atk);
			$def = $target->get('defense');
			$arm = $target->get('marm');
			$hits = Shadowfunc::diceHits($mindmg, $arm, $a, $def, $player, $target);
			$hits = Common::clamp($hits, 0);
			echo "Dicing... DIST: $d, ATK: $a, DEF: $def. Hits: $hits\n";
//			$hits -= $arm;
			
			if ($hits <= 0)
			{
				continue;
			}
			
			$dmg = round($mindmg + ($hits*0.1), 2);
			$dmg = Common::clamp($dmg, $mindmg, $maxdmg);
			$dmg -= $arm;
			
			if ($dmg <= 0)
			{
				continue;
			}
			
			echo "Blinding the target with $hits hits ...\n";
			for ($i = 0; $i<$hits; $i+=3)
			{
				$target->addEffects(new SR_Effect($i*10, array('attack'=>-0.15), SR_Effect::MODE_ONCE));
			}
			
			$damage[$pid] = $dmg;
		}
		
		Shadowfunc::multiDamage($player, $damage, 'The Flashbang totally missed all targets.');
	}
	
//	public function onThrowOLD(SR_Player $player, SR_Player $target)
//	{
//		$party = $player->getParty();
//		$ep = $party->getEnemyParty();
//		$mc = $party->getMemberCount();
//		$firearms = $player->get('firearms');
//		
//		$atk = 15;
//		$mindmg = 1;
//		$maxdmg = 4;
//		
//		$loot_xp = array();
//		$loot_ny = array();
//		foreach ($party->getMembers() as $member)
//		{
//			$loot_xp[$member->getName()] = 0;
//			$loot_ny[$member->getName()] = 0;
//		}
//		
//		
//		$out = '';
//		$out_ep = '';
//		
//		$inaccuracy = rand(2,4) - ($firearms?1:0);
//		$targets = self::computeDistances($target, $inaccuracy);
//		
//		foreach ($targets as $data)
//		{
//			list($pid, $d) = $data;
//			$target = $ep->getMemberByPID($pid);
//			$target instanceof SR_Player;
//			$a = $atk - ($d*$d) + rand(-1,2);
//
//			$a = Common::clamp($a, 0, $atk);
//			$def = $target->get('defense');
//			$arm = $target->get('marm');
//			$hits = Shadowfunc::diceHits($mindmg, $arm, $a, $def, $player, $target);
//			$hits = Common::clamp($hits, 0);
//			echo "Dicing... DIST: $d, ATK: $a, DEF: $def. Hits: $hits\n";
////			$hits -= $arm;
//			
//			if ($hits <= 0) {
//				continue;
//			}
//			
//			$dmg = round($mindmg + ($hits*0.1), 2);
//			$dmg = Common::clamp($dmg, $mindmg, $maxdmg);
//			$dmg -= $arm;
//			
//			if ($dmg <= 0) {
//				continue;
//			}
//			
//			$target->dealDamage($dmg);
//			
//			$type = $target->isDead() ? 'kills' : 'hits'; 
//			$out .= sprintf(', %s %s with %s', $type, $target->getName(), $dmg);
//			$out_ep .= sprintf(', %s %s with %s(%s/%s)', $type, $target->getName(), $dmg, $target->getHP(), $target->getMaxHP());
//
//			if ($target->isDead())
//			{
//				$xp = $target->getLootXP();
//				$nuyen = $target->getLootNuyen();
//				$target->resetXP();
//				$target->giveNuyen(-$nuyen);
//				foreach ($party->getMembers() as $member)
//				{
//					$member instanceof SR_Player;
//					$lxp = $xp/$mc;
//					$leveldiff = ($target->getBase('level')+1) / ($member->getBase('level')+1);
//					$lxp *= $leveldiff;
//					$lxp = round(Common::clamp($lxp, 0.01), 2);
//					
//					$loot_xp[$member->getName()] += $lxp;
//					$loot_ny[$member->getName()] += $nuyen/$mc;
//				}
//			}
//			else # Blind them
//			{
//				echo "Blinding the target with $hits hits ...\n";
//				for ($i = 0; $i<$hits; $i+=3)
//				{
//					$target->addEffects(new SR_Effect($i*10, array('attack'=>-0.15), SR_Effect::MODE_ONCE));
//				}
//			}
//		} # foreach targets
//		
//		if ($out === '') {
//			return;
//		}
//		
//		$out = substr($out, 2);
//		
//		# Give the loot:
//		$out = $player->getName().$out.'.';
//		foreach ($party->getMembers() as $member)
//		{
//			$xp = $loot_xp[$member->getName()];
//			$ny = $loot_ny[$member->getName()];
//			$lootout = '';
//			if ($ny > 0 || $xp > 0) {
//				$lootout = sprintf(' You loot %s¥ and %s XP.', $ny, $xp);
//				$member->giveXP($xp);
//				$member->giveNuyen($ny);
//			}
//			$member->message($out.$lootout);
//		}
//		
//		$out_ep = substr($out_ep, 2);
//		$ep = $party->getEnemyParty();
//		$ep->message($player, $out_ep);
//		
//		foreach ($ep->getMembers() as $target)
//		{
//			if ($target->isDead())
//			{
//				$target->gotKilledBy($player);
//			}
//		}
//		
//		if ($ep->getMemberCount() === 0) {
//			$party->onFightDone();
//		}
//	}
}
