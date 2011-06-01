<?php
final class Seattle_BlackDwarf extends SR_TalkingNPC
{
	public function getName() { return 'Tuldir'; }
	public function getNPCQuests(SR_Player $player) { return array('Seattle_BD1','Seattle_BD2','Seattle_BD3','Seattle_BD4'); }
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b=chr(2);
		if ($this->onNPCQuestTalk($player, $word)) {
			return true;
		}
		switch ($word)
		{
			case 'seattle': return $this->reply('I have been in Seattle for all my life. I just love it.'); break;
			case 'cyberware': return $this->reply('Good cyberwear can be a great help. Just don\'t get wasted completely!'); break;
			case 'magic': return $this->reply('I think magic is overrated'); break;
			case 'runes': case 'rune': return $this->reply('I used to have the finest runes in my shop.'); break;
			case 'invite': return $this->reply('Oh yeah. Please greet the guys at the party. I will have to work.'); break;
			case 'hire': return $this->reply('I have a broken leg.'); break;
			case 'shadowrun':
			case 'yes':
			case 'no':
				return $this->reply('We know all of it.');
			default:
				return $this->reply("Hello. I know my shop looks wasted, but i am still in business! All my {$b}Runes{$b} are gone!");
		}
	}
}
?>