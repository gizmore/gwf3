<?php
final class Delaware_Doctor extends SR_TalkingNPC
{
	public function getName() { return 'The doctor'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$c = Shadowrun4::SR_SHORTCUT;
		$b = chr(2);
		switch ($word)
		{
			case 'yes': case 'no':
			case 'hand':
				$quest = SR_Quest::getQuest($player, 'Delaware_Seraphim1');
				return $quest->onDoctorTalk($this, $player);
			
			case 'heal':
				$this->reply("We can heal you for some nuyen. Just use {$c}heal here.");
				break;
			
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