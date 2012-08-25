<?php
/**
 * The Seattle Arena. You can PvP here or fight a few NPC.
 * @author gizmore
 */
final class Seattle_Arena extends SR_Location
{
	public function isPVP() { return true; }
	public function getNPCS(SR_Player $player) { return array("talk" => "Seattle_ArenaGuy"); }
	public function getFoundPercentage()  { return 45.0; }
	public function getCommands(SR_Player $player) { return array('challenge'); }
	
// 	public function getFoundText(SR_Player $player) { return "You found the Seattle Arena. A well hidden place, because the fights are illegal."; }
// 	public function getEnterText(SR_Player $player) { return 'You enter the Seattle Arena. A guy comes to you and it seems like this is the director.'; }
// 	public function getHelpText(SR_Player $player) { return 'Use #talk <topic> to talk to the director.'; }
	
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	public function getHelpText(SR_Player $player) { return $this->lang($player, 'help'); }
	
	public function on_challenge(SR_Player $player, array $args)
	{
		# No fight with party:
		if ($player->isInParty())
		{
			$player->msg('1099');
// 			$player->message("You can't fight here when you are in a party. Use #part to leave your party.");
			return false;
		}
		
		# Get current enemy
		$key = 'SEATTLE_ARENA_N';
		if (!$player->hasConst($key)) {
			$player->setConst($key, 1);
		}
		$n = $player->getConst($key);
		
		# Possible flags/enemies in Arena:
		$enemies = array(
			array("Seattle_AToughGuy", $this->lang($player, 'e1')),
			array("Seattle_ASecOrk", $this->lang($player, 'e2')),
			array("Seattle_AToughTroll", $this->lang($player, 'e3')),
			array("Seattle_AMagician", $this->lang($player, 'e4')),
			array("Seattle_AElite", $this->lang($player, 'e5')),
		);
		
		# No more fights:
		if ($n > count($enemies))
		{
// 			$player->message("Sorry. You fought all the enemies here. Try #fight <player> then :P");		
			$player->msg('1098');
			return false;
		}
		$n--;
		$enemy = $enemies[$n];
		$player->msg('5141', array($enemy[1]));
// 		$player->message("The Arena-Guy leads you to the locker room. After a few minutes you were guided into the arena and see your enemy: ".$enemy[1].". " );
		SR_NPC::createEnemyParty($enemy[0])->fight($player->getParty(), true);
		return true;
	}
}
?>
