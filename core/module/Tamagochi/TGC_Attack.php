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
	
	
	public function dice($skill)
	{
		if ($this->attacker === $this->defender) {
			return $this->attacker->sendError(TGC_Commands::payload('ERR_ATTACK_SELF', $this->mid));
		}
		
		$a = $this->attacker; $d = $this->defender;

		$am = $a->getVar('p_active_mode'); $dm = $d->getVar('p_active_mode');
		$as = $a->getVar('p_active_skill'); $ds = $d->getVar('p_active_skill');
		$ac = $a->getVar('p_active_color'); $dc = $d->getVar('p_active_color');
		$ae = $a->getVar('p_active_element'); $de = $d->getVar('p_active_element');
		
		$slaps = require(GWF_CORE_PATH.'module/Tamagochi/slapdata/slaps.php');
		
		$adverb = $this->randomItem($slaps['adverbs']);
		$verb = $this->randomItem($slaps['verbs']);
		$adjective = $this->randomItem($slaps['adjectives']);
		$noun = $this->randomItem($slaps['nouns']);
		$adverbName = $adverb[0];
		$adverbPower = $adverb[1];
		$verbName = $verb[0];
		$verbPower = $verb[1];
		$adjectiveName = $adjective[0];
		$adjectivePower = $adjective[1];
		$nounName = $noun[0];
		$nounPower = $noun[1];
		
		$power = round(1 * ($adverbPower/10.0) * ($verbPower/10.0) * ($adjectivePower/10.0) * ($nounPower/10.0));
		
		$crit = $this->isCriticalHit($a, $d);
		if ($crit) {
			$power *= 2;
		}
		
		$power *= $this->modePowerMultiplier($a, $d);
		$power *= $this->skillPowerMultiplier($a, $d, $skill);
		$power *= $this->colorPowerMultiplier($a, $d);
		$power *= $this->elementPowerMultiplier($a, $d);

		$payload = array(
			'adverb' => $adverbName,
			'verb' => $verbName,
			'adjective' => $adjectiveName,
			'nounPower' => $nounName,
			'adverbPower' => $adverbPower,
			'verbPower' => $verbPower,
			'adjectivePower' => $adjectivePower,
			'noun' => $nounName,
			'power' => $power,
			'type' => $skill,
			'attacker' => $a->getName(),
			'defender' => $d->getName(),
			'critical' => $crit,
		);
		$payload = TGC_Commands::payload(json_encode($payload), $this->mid);
		
		$a->sendCommand('SLAP', $payload);
		$d->sendCommand('SLAP', $payload);
		
		$a->giveXP($skill, $power, $this->mid);
	}

	private function randomItem($slaps)
	{
		return $slaps[array_rand($slaps)];
	}
	private function isCriticalHit(TGC_Player $attacker, TGC_Player $defender)
	{
		return TGC_Logic::dice(1, 20) === 20;
	}

	private function modePowerMultiplier(TGC_Player $a, TGC_Player $d)
	{
		$am = $a->getVar('p_active_mode'); $dm = $d->getVar('p_active_mode');
		if ($am == $dm) {
			return 1.00;
		}
		else if ($am == 'attacker') {
			return 1.05;
		}
		else {
			return 0.95;
		}
	}

	private function skillPowerMultiplier(TGC_Player $attacker, TGC_Player $defender, $skill)
	{
		return 1.0;
		$af = $attacker->getVar('p_fighter_level'); $df = $defender->getVar('p_fighter_level');
		$an = $attacker->getVar('p_ninja_level'); $dn = $defender->getVar('p_ninja_level');
		$ap = $attacker->getVar('p_priest_level'); $dp = $defender->getVar('p_priest_level');
		$aw = $attacker->getVar('p_wizard_level'); $dw = $defender->getVar('p_wizard_level');
		
		switch ($skill)
		{
		case 'fighter':
			$atotal = $af + $an;
			$dtotal = $df + $dn;
		case 'ninja':
			
		case 'priest':
			
		case 'wizard':
			
		}
	}

	private function colorPowerMultiplier(TGC_Player $attacker, TGC_Player $defender)
	{
		return 1.0;
	}

	private function elementPowerMultiplier(TGC_Player $attacker, TGC_Player $defender)
	{
		return 1.0;
	}
	
}
