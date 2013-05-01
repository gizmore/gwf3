<?php
final class PrisonB2 extends SR_Dungeon
{
	public function getCityLocation() { return 'Delaware_Prison'; }
	public function getArriveText(SR_Player $player) { return 'You enter cell block 2.'; }
	public function getImportNPCS() { return array('Seattle_BlackOp','Prison_Guard','Prison_Ward', 'Prison_GrayOp'); }
	
	public function getGotoTime() {
		return 400;
	}
	public function getExploreTime() {
		return 60;
	}
	
	public function onCityEnter(SR_Party $party)
	{
		if ($party->hasNPCClassed('PrisonB2_Malois'))
		{
			$this->setAlert($party, 9000000);
		}
		parent::onCityEnter($party);
	}
	
	public function onCityExit(SR_Party $party)
	{
		if ($party->hasNPCClassed('PrisonB2_Malois'))
		{
			$party->notice('Malois says: "Hurry, we have to hurry!"');
		}
		parent::onCityExit($party);
	}
}
?>
