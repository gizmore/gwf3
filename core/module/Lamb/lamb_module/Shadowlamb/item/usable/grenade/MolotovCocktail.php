<?php
final class Item_MolotovCocktail extends SR_Grenade
{
	public function getItemDescription() { return 'Will do slight party damage to a larger area.'; }
	public function getItemPrice() { return 60; }
	public function getItemUsetime() { return 45; }
	public function getItemWeight() { return 550; }
	
	public function onThrow(SR_Player $player, SR_Player $target)
	{
		$firearms = $player->get('firearms');
		
		$atk = 20 + $firearms;
		$mindmg = 1;
		$maxdmg = 6;
		
		$out_dmg = '';
		$out_dmgep = '';
		$out_eff = '';
		
		$inaccuracy = rand(2,4) - ($firearms?1:0);
		$targets = $this->computeDistances($target, $inaccuracy);
		
		foreach ($targets as $data)
		{
			list($t, $d) = $data;
			$t instanceof SR_Player;
			$a = $atk - $d + rand(-1,2);
			$a = Common::clamp($a, 0, $atk);
			$def = $t->get('defense');
			$arm = $t->get('marm');
			$hits = Shadowfunc::diceHits($mindmg, $arm, $atk, $def, $player, $t);
			$hits -= $arm;
			$hits = Common::clamp($hits, 0);
			
			if ($hits == 0) {
				continue;
			}
			
			$dmg = round($mindmg + ($hits/10), 2);
			if ($dmg <= 0) {
				continue;
			}
		}
		
	}
}
?>