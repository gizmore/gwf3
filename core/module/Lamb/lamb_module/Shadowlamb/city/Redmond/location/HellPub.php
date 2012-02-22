<?php
final class Redmond_HellPub extends SR_Store
{
	public function getFoundPercentage() { return 45.00; }
	
// 	public function getFoundText(SR_Player $player) { return sprintf('You find a pub with a lot of motorbikes in front of it. The sign reads "Hell`s Pub".'); }
// 	public function getEnterText(SR_Player $player) { return 'You enter the Hell`s Pub. A few bikers are playing pool, a few others drink some beer.'; }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttb(arkeeper), {$c}ttp(ool_player) and {$c}ttd(rinking_guest) here."; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	public function getNPCS(SR_Player $player) { return array('ttb'=>'Redmond_Hellkeeper', 'ttp'=>'Redmond_Hellplayer', 'ttd'=>'Redmond_Helldrinker'); }
	
	/**
	 * The Hells pub offers a moped, cool! 
	 * @see SR_Store::getStoreItems()
	 */
	public function getStoreItems(SR_Player $player)
	{
		$back = array(
			array('Moped', 100.0, 1500), # TODO: raise price to 5000 on beta release
		);
		return $back;
	}
	
	public function getCommands(SR_Player $player)
	{
		# only view and buy
		return array('view','viewi','buy');
	}
}
?>