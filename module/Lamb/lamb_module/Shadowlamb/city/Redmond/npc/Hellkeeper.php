<?php
final class Redmond_Hellkeeper extends SR_TalkingNPC
{
	public function getName() { return 'The barkeeper'; }
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'shadowrun':
				$this->reply("You are looking for a job? You could ask my brother in the TrollsInn. He has some urgent need for spiritouses.");
				break;
			case 'bikers':
				$this->reply('Most of my guests are hardcore bikers. They protect my pub and in exchange they can have cheap parties here. They do not annoy the other guests, so all are fine with that.');
				break;
			case 'punk': case 'punks':
				$this->reply("The punks and the bikers are in kinda clanwar. Better don`t mention them when you like to talk with the {$b}bikers{$b}.");
				break;
			case 'hello':
				$this->reply("Hello chummer. Better don`t annoy the bikers. They are pissed because of the {$b}punks{$b}");
				break;
			default:
				$this->reply('Hello chummer, how may i serve you?');
				break;
		}
		return true;
	}	
}
?>