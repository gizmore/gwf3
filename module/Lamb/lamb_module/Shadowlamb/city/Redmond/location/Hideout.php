<?php
final class Redmond_Hideout extends SR_Tower
{
	public function getFoundPercentage() { return 8.00; }
	public function getFoundText(SR_Player $player) { return 'You see two punks coming out of a ruinous house. You stealthy move to one of the windows. Seems like this is one of the Punks hideout.'; }
	
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		$dice = rand(0, 6);
		if ($dice < 2) {
			$party->notice('You silently search the door and windows for an entrance. You were lucky and sneak in...');
			$this->teleport($player, 'Hideout_Exit');
//			$party->pushAction(SR_Party::ACTION_INSIDE, $this->getName());
		}
		else if ($dice < 4) {
			$party->notice('You silently search the door and windows for an entrance. You have no luck, everything\'s closed.');
//			$party->pushAction(SR_Party::ACTION_OUTSIDE, $party->getCity());
		}
		else if ($dice < 6) {
			$party->notice('You silently search the door and windows for an entrance. Two punks notice you and attack!');
//			$party->pushAction(SR_Party::ACTION_OUTSIDE, $party->getCity());
			SR_NPC::createEnemyParty('Redmond_Cyberpunk','Redmond_Cyberpunk')->fight($party, true);
		}
		else {
//			$party->pushAction(SR_Party::ACTION_OUTSIDE, $party->getCity());
//			$party->pushAction(SR_Party::ACTION_INSIDE, $this->getName());
			$party->notice('You take a look through the doors keyhole. A party of four punks opens the door and suprises you.');
			SR_NPC::createEnemyParty('Redmond_Cyberpunk','Redmond_Cyberpunk','Redmond_Cyberpunk','Redmond_Lamer')->fight($party, true);
		}
	}
}
?>