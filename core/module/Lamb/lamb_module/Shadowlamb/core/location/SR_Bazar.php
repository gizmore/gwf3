<?php
class SR_Bazar extends SR_Location
{
	public function getBazarFee() { return 10.0; } #10%
	public function getHelpText(SR_Player $player) { return "In a bazaar you can sell your items. You can use #sell, #search and #buy here."; }
	public function getCommands(SR_Player $player) { return array('sell','search','buy'); }
	
	public function on_sell()
	{
		
	}
}
?>