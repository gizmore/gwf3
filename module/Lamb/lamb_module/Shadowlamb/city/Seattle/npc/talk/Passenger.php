<?php
final class Seattle_Passenger extends SR_TalkingNPC
{
	public function getName() { return 'The passenger'; }
	public function onNPCTalk(SR_Player $player, $word)
	{
		switch ($word)
		{
			default:
				$this->reply('Lol i was at a party in Seattle Hotel over there... It was awesome. But now i head back to Redmond.');
				$player->giveKnowledge('places', 'Seattle_Hotel');
				$this->reply('If you are new to Seattle, you might want to know where the Ares is... it\'s just down the road, then left.');
				$player->giveKnowledge('places', 'Seattle_Ares');
				break;
		}
	}
}
?>