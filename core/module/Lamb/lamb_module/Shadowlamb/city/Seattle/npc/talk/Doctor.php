<?php
final class Seattle_Doctor extends SR_TalkingNPC
{
	public function getName() { return 'The doctor'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
// 		$c = Shadowrun4::SR_SHORTCUT;
// 		$b = chr(2);
		switch ($word)
		{
			case 'malois':
// 				return $this->reply('I do not talk about customers.');
			case 'heal':
				return $this->rply($word);
// 				return $this->reply("We can heal you for some nuyen. Just use {$c}heal here.");
			
			case 'yes': case 'no':
			case 'cyberware':
				return $this->rply('cyber');
// 				return $this->reply("We have the best Renraku Cyberware available. Use {$c}view, {$c}implant and {$c}unplant to manage your accessoires.");
				
			case 'hello':
			default:
				$this->rply('default');
// 				$this->reply("Hello chummer, need some {$b}heal{$b} or {$b}cyberware{$b}?");
				$player->giveKnowledge('words', 'Cyberware','Yes','No');
				return true;
		}
	}
}
?>