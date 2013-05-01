<?php
final class Delaware_Scrapyard extends SR_Arena
{
	public function getFoundPercentage() { return 25.0; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Delaware_ScrapGuy'); }
	public function getCommands(SR_Player $player) { return array('view', 'viewi', 'buy', 'challenge'); }
	
// 	public function getFoundText(SR_Player $player) { return 'You found a scrapyard. You see lots of junk already from far behind.'; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the scrapyard. A lot of metal, old cars and other garbage.'; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}view, #viewi, {$c}buy and #challenge here."; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	
	public function getArenaEnemies(SR_Player $player)
	{
		return array(
			array(0x01, 'Delaware_MeleeOrk', $this->lang($player, 'e_1'), 250),
			array(0x02, 'Delaware_MeleeTroll', $this->lang($player, 'e_2'), 350),
			array(0x04, 'Delaware_Knight', $this->lang($player, 'e_3'), 750),
			array(0x08, 'Delaware_DarkKnight', $this->lang($player, 'e_4'), 850),
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
