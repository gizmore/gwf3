<?php
final class Quest_Redmond_Johnson_3 extends SR_Quest
{
	public function getQuestDescription() { return 'Deliver a package to the Hotelier in Seattle_Hotel.'; }
	
	public function accept(SR_Player $player)
	{
		parent::accept($player);
		$player->giveItems(SR_Item::createByName('Package'));
	}
}
?>