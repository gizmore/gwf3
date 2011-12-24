<?php
final class PrisonB3 extends SR_Dungeon
{
	public function getCityLocation() { return 'Delaware_Prison'; }
	public function getArriveText() { return 'You enter cell block 3.'; }
	public function getImportNPCS() { return array('Seattle_BlackOp','Prison_GrayOp'); }
	
	public function onCityEnter(SR_Party $party)
	{
		if ($party->hasNPCClassed('PrisonB2_Malois'))
		{
			$this->setAlert($party, 9000000);
		}
		parent::onCityEnter($party);
	}
}
?>
