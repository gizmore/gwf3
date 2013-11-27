<?php
require_once 'SR_TalkingNPC.php';
/**
 * You can hire these guys.
 * @author gizmore
 */
abstract class SR_HireNPC extends SR_TalkingNPC
{
	const HIRE_END = 'hire';
	
	public function getName() { return sprintf('%s[%s]', $this->getVar('sr4pl_name'), $this->getID()); }
	
	public function onHire(SR_Player $player, $price, $time)
	{
		$p = $player->getParty();
		if ($p->hasHireling()) {
			return "You already have a runner. I work alone.";
		}
		
		if ($price > 0)
		{
			if ($player->getNuyen() < $price) {
				return "I want {$price} nuyen to join join your party.";
			}
		}
		
		$this->onHireB($player, $price, $time);
		
		return "Ok chummers, let's go!";
	}
	
	public function onHireB(SR_Player $player, $price, $time)
	{
		$p = $player->getParty();
		$player->giveNuyen(-$price);
		$npc = $this->spawn($p);
		$npc->onHireC($player, $time);
	}
	
	public function onHireC(SR_Player $player, $time)
	{
		$player->getParty()->addUser($this, true);
		$this->onSetHireTime($time);
	}
	
	public function onSetHireTime($time)
	{
		$this->setConst(self::HIRE_END, Shadowrun4::getTime() + $time);
	}
	
	public function onAddHireTime($seconds)
	{
		$this->setConst(self::HIRE_END, $this->getConst(self::HIRE_END) + $seconds);
	}
	
	public function hasToLeave()
	{
		if (!$this->hasConst(self::HIRE_END)) {
			return false;
		}
		return $this->getConst(self::HIRE_END) < Shadowrun4::getTime();
	}
}
