<?php
final class Delaware_Bazar extends SR_Bazar
{
	public function getBazarFee() { return 10.0; } #10%
	
	public function getFoundPercentage() { return 50.0; }
	public function getEnterText(SR_Player $player) { return "You enter the bazaar, an area with lot's of small shops and merchants."; }
}
?>