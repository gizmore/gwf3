<?php
/**
 * Extend Min Zoom by 1 for Duration Seconds;
 * @author gizmore
 *
 */
class SABRECHEWRA extends TGC_Spell
{
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