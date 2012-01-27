<?php
final class PrisonB2_Cell5 extends SR_SearchRoom
{
	public function getFoundPercentage() { return 50; }
	public function getLockLevel() { return 3; }
	public function getFoundText(SR_Player $player) { return 'You found cell 5 ... Malois might be kept here.'; }
	public function getEnterText(SR_Player $player)
	{
		if ($this->isMaloisHere($player))
		{
			return 'You enter the cell and spot Malois on a small bed.';
		}
		else
		{
			return 'You enter the cell.';
		}
	}
	
	public function getHelpText(SR_Player $player)
	{
		if ($this->isMaloisHere($player))
		{
			return 'Use #talk to talk to Malois.';
		}
		return parent::getHelpText($player);
	}
	
	public function getNPCS(SR_Player $player)
	{
		if ($this->isMaloisHere($player))
		{
			return array('talk'=>'PrisonB2_Malois');
		}
		else
		{
			return array();
		}
	}
	
	private function isMaloisHere(SR_Player $player)
	{
		if (false === ($party = $player->getParty()))
		{
			return false;
		}
		return ( ($party->hasNPCNamed('Malois')) || ($party->hasConst('RESCUED_MALOIS')) ) ? false : true;
	}
}
?>