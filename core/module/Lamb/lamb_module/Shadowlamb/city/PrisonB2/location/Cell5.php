<?php
final class PrisonB2_Cell5 extends SR_SearchRoom
{
	public function getLockLevel() { return 3; }
	public function getNPCS(SR_Player $player)
	{
		$party = $player->getParty();
		if ( ($party->hasNPCNamed('Malois')) || ($party->hasConst('RESCUED_MALOIS')) )
		{
			return array();
		}
		else
		{
			return array('talk'=>'PrisonB2_Malois'); 
		}
	}
}
?>