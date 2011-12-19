<?php
final class Chicago_SubwayGuy extends SR_TalkingNPC
{
	public function getName() { return 'The passenger'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'renraku':
			case 'shadowrun':
			case 'cyberware':
			case 'magic':
			case 'hire':
			case 'blackmarket':
			case 'bounty':
			case 'seattle':
			case 'alchemy':
			case 'invite':
			case 'malois':
			case 'hello': 
			case 'yes':
			case 'no':
			case 'negotiation':
			
			default:
				return $this->reply("Leave me alone.");
		}
	}	
}
?>
