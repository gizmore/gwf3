<?php
/**
 * Turn off MapCenterPan for 600 seconds.
 * @author gizmore
 *
 */
class SABRECHEWRA extends TGC_Spell
{
	public function canTargetSelf()
	{
		return true;
	}
	
	public function doCast()
	{
		$this->defaultCast(array('duration', $this->calculateDuration()));
	}
	
	public function calculateDuration()
	{
		return 600;
	}
}