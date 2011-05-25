<?php
final class Seattle_Doctor extends SR_TalkingNPC
{
	public function getName() { return 'The doctor'; }
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		$b = chr(2);
		switch ($word)
		{
			case 'heal':
				$this->reply("We can heal you for some nuyen. Just use {$c}heal here.");
				break;
			
			case 'yes': case 'no':
			case 'cyberware':
				$this->reply("We have the best Renraku Cyberware available. Use {$c}view, {$c}implant and {$c}unplant to manage your accesoires.");
				break;
				
			case 'hello':
			default:
				$this->reply("Hello chummer, need some {$b}heal{$b} or {$b}cyberware{$b}?");
				$player->giveKnowledge('words', 'Cyberware','Yes','No');
				break;
			
		}
	}
}
?>