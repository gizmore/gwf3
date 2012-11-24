<?php
final class Chicago_HotelWoman extends SR_TalkingNPC
{
	public function getName() { return 'Charly'; }
	public function getNPCQuests(SR_Player $player)
	{
		$quest = SR_Quest::getQuest($player, 'Seattle_Malois2');
		if (false === $quest->isDone($player))
		{
			return array();
		}
		return array('Chicago_HotelWoman1', 'Chicago_HotelWoman2');
	}
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		switch ($word)
		{
			case 'renraku': return $this->reply('I hate renraku ... they are responsible for much bad things lately.');
			case 'shadowrun': return $this->reply('I am not into illegal stuff.');
			case 'cyberware': return $this->reply('Most of my friends don\'t use a headcomputer.');
			case 'magic': return $this->reply('Most of my friends are not from a magic race.');
			case 'hire': return $this->reply('I am not interested in anything like that.');
			case 'blackmarket': return $this->reply('I have no needs for illegal goods.');
			case 'bounty': return $this->reply('It is illegal to set a price on a human beeing.');
			case 'seattle': return $this->reply('I live in Seattle, i am just here this weekend for my job.');
			case 'alchemy': return $this->reply('I do not believe in such hocus pocus waters.');
			case 'invite': return $this->reply('I am not intersted in such things.');
			case 'negotiation': return $this->reply('I don\'t even have money to negotiate.');
			case 'malois': return $this->reply('Anything new?');
			
			case 'hello': return $this->reply('Hello ...');
// 			case 'yes':
// 			case 'no':
			
			default:
				return $this->reply("I don't know anything about {$word}.");
		}
	}	
}
?>
