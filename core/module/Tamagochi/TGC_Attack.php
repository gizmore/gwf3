<?php
final class TGC_Attack
{
	private $attacker;
	private $defender;
	
	private $mid;
	
	public function __construct(TGC_Player $attacker, TGC_Player $defender, $mid)
	{
		$this->attacker = $attacker;
		$this->defender = $defender;
		
		$this->mid = $mid;
	}
	
	
	public function dice()
	{
		if ($this->attacker === $this->defender) {
			return $this->attacker->sendError(TGC_Commands::payload('ERR_ATTACK_SELF', $this->mid));
		}
		
		$a = $this->attacker; $d = $this->defender;

		$am = $a->getVar('p_active_mode'); $dm = $d->getVar('p_active_mode');
		$as = $a->getVar('p_active_skill'); $ds = $d->getVar('p_active_skill');
		$ac = $a->getVar('p_active_color'); $dc = $d->getVar('p_active_color');
		$ae = $a->getVar('p_active_element'); $de = $d->getVar('p_active_element');
		
		$adverb = 1;
		
	}
}