<?php
final class Prison_Block1 extends SR_Location
{
	const BAN_TIME = 300; # 5 min;
	
	public function getFoundPercentage() { return 100.00; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Prison_Prisoner'); }
	public function isPVP() { return true; }
	public function getAreaSize() { return 150; }
	public function getEnterText(SR_Player $player) { return 'You enter cell block 1.'; }
	public function getFoundText(SR_Player $player) { return 'You found cell block 1, whatever that means.'; }
	public function getCommands(SR_Player $player) { return array('read','write'); }
	
	public function isEnterAllowed(SR_Player $player) { return false; }
	public function isExitAllowed(SR_Player $player)
	{
		# Eek?
		if (false === ($user = $player->getUser()))
		{
			return false;
		}
		
		# Check idle time.
		$last = $user->getVar('lusr_timestamp');
		if (($last+self::BAN_TIME) > time())
		{
			return false;
		}
		
		return true;
	}
	
	public function onEnter(SR_Player $player)
	{
		$player->message('Seems like you are screwed.');
	}
	
	public function on_leave(SR_Player $player, array $args)
	{
		
	}
}
?>