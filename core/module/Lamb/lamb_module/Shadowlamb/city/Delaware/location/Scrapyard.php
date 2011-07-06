<?php
final class Delaware_Scrapyard extends SR_Store
{
	public function getFoundPercentage() { return 25.0; }
	public function getFoundText(SR_Player $player) { return 'You found a scrapyard. You see lots of junk already from far behind.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the scrapyard. A lot of metal, old cars and other garbage.'; }
	
	public function getStoreItems(SR_Player $player)
	{
		return array(
			array('Aygo1000'),
		);
		
	}
	
}
?>