<?php
final class Prison_VisitMalois extends SR_TalkingNPC
{
	public function getName() { return 'Malois'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'renraku':
				return $this->reply("Dude, you gotta get me out of here. It was not my wife who sent you. It was an allied victim. {$b}Bribe{$b} the guards to set me free, this often works.");
			case 'malois':
				return $this->reply("Hehe. Hello little brother.");
			case 'bribe':
				return $this->reply("Yes, try to {$b}bribe{$b} the right guards to get me outta here.");
			case 'hello':
				return $this->reply("Hello chummer. Great to see you.");
			default:
				return $this->reply("$word will not help us.");
		}
	}
}
?>