<?php
/**
 * Turn off MapCenterPan for 600 seconds.
* @author gizmore
*/
class SAB extends TGC_Spell
{
	public function getCodename() { return 'Cockroach'; }
	
	public function getMinPower() { return 2; }

	public function canTargetSelf() { return true; }
	public function canTargetOther() { return true; }

	public function getCode()
	{
		$duration = $this->duration * 1000;
		return "PlayerSrvc.OWN.NO_SCROLL_LOCK += $duration; setTimeout(function(){ PlayerSrvc.OWN.NO_SCROLL_LOCK -= $duration; }, $duration); ";
	}

	public function executeSpell()
	{
		$this->executeDefaultCast();
	}
}
