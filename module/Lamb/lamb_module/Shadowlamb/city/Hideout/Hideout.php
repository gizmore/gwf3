<?php
final class Hideout extends SR_City
{
	public function getImportNPCS() { return array('Redmond_Lamer','Redmond_Punk'); }
	public function getArriveText() { return 'You enter the rotten building. It smells not good but you can breathe. You feel clumsy.'; }
	public function getSquareKM() { return 0.2; }
	public function onArrive(SR_Party $party)
	{
		$this->getLocation('HiddenStorage')->clearSearchCache($party);
		parent::onArrive($party);
	}

	
}
?>