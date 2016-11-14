<?php
/**
 * Turn off MapCenterPan for 600 seconds.
* @author gizmore
*/
class SAB extends TGC_Spell
{
	public function getCodename() { return 'Cockroach'; }

	public function canTargetSelf() { return true; }
	public function canTargetOther() { return true; }

	public function getCode()
	{
		$duration = $this->duration * 1000;
		return "PlayerSrvc.OWN.NO_SCROLL_LOCK = true; setTimeout(function(){ PlayerSrvc.OWN.NO_SCROLL_LOCK = undefined; }, $duration); ";
	}

	public function executeSpell()
	{
		$this->executeDefaultCast();
	}
}
