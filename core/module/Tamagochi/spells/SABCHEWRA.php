<?php
/**
 * Extend Min Zoom by 1 for Duration Seconds;
 * @author gizmore
 *
 */
class SABRECHEWRA extends TGC_Spell
{
	public function getCodename() { return 'Hawk'; }

	public function getMinPower() { return 5; }
	
	public function canTargetSelf() { return true; }
	public function canTargetOther() { return true; }
	
	public function beforeCast()
	{
		$this->effect = 1;
	}
	
	public function getCode()
	{
		$duration = $this->duration * 1000;
		return "PlayerSrvc.OWN.EXTEND_MIN_ZOOM += 1; setTimeout(function(){ PlayerSrvc.OWN.EXEND_MIN_ZOOM -= 1; }, $duration); ";
	}
	
	public function executeSpell()
	{
		$this->executeDefaultCast();
	}
	
}