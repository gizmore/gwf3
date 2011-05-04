<?php
abstract class SR_Tower extends SR_Location
{
	public function teleport(SR_Player $player, $target)
	{
		$party = $player->getParty();
		$party->pushAction(SR_Party::ACTION_TRAVEL, $target, 4);
		$party->giveKnowledge('places', $target);
	}
}
?>