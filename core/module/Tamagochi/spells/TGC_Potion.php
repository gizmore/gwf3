<?php
abstract class TGC_Potion extends TGC_Spell
{
	public function canTargetSelf() { return true; }
	public function canTargetOther() { return true; }

	public function dicePower()
	{
		$this->power = TGC_Logic::dice(1, 20 * $this->level * $this->player->priestLevel());
	}
	
	public function brew()
	{
		$this->spell();
	}
	
	public function cast()
	{
		$this->player->sendError('ERR_NO_CAST');
	}
}
