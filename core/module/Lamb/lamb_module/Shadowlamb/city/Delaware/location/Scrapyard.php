<?php
final class Delaware_Scrapyard extends SR_Arena
{
	public function getFoundPercentage() { return 25.0; }
	public function getFoundText(SR_Player $player) { return 'You found a scrapyard. You see lots of junk already from far behind.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the scrapyard. A lot of metal, old cars and other garbage.'; }
	
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_ScrapGuy'); }
	
	public function getCommands(SR_Player $player) { return array('view', 'buy', 'challenge'); }
	
	public function getArenaEnemies(SR_Player $player)
	{
		return array(
			array(0x01, 'Delaware_MeleeOrk', 'A grunt looking ork in a melee armor.', 250),
			array(0x02, 'Delaware_MeleeTroll', 'A grunt looking troll in a melee armor.', 350),
			array(0x04, 'Delaware_Knight', 'A medival knight in shiny armor.', 750),
		);
	}
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Aygo1000'),
		);
		
	}
}
?>