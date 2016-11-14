<?php
/**
 * Makes you jump on map.
 * @author gizmore
 */
class CAYOTOTHSUN extends TGC_Spell
{
	public function getCodename() { return 'Bunny'; }
	
	public function getMinPower() { return 10; }
	
	public function canTargetSelf() { return true; }
	public function canTargetOther() { return false; }
	
	public function getCode()
	{
		
	}
	
	public function executeSpell()
	{
		$this->executeDefaultCast();
	}
}
