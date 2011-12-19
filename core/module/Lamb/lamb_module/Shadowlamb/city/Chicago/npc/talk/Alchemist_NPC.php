<?php
final class Chicago_Alchemist_NPC extends SR_TalkingNPC
{
	public function getName() { return 'Newton'; }
	
	public function getNPCModifiers()
	{
		return array('race'=>'gnome');
	}
	
	public function getNPCQuests(SR_Player $player) { return array('Chicago_Alchemist1'); }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word, $args))
		{
			return true;
		}
		$b = chr(2);
		
		switch ($word)
		{
			case 'seattle': return $this->reply('Renraku is not as hitech as you might think... you cannot bend the universe as you wish.');
// 			case 'shadowrun':
			case 'cyberware': return $this->reply("Cyberware is bad for your essence. {$b}Alchemy{$b} safes lifes.");
			case 'magic': return $this->reply('Magic knowledge is required to perform powerful alchemy.');
			case 'hire': return $this->reply('You cannot hire me, chummer.');
			case 'blackmarket': return $this->reply('You won\'t get illegal stuff here, chummer.');
			case 'bounty': return $this->reply('You won\'t get illegal stuff here, chummer.');
			case 'seattle': return $this->reply('Seattle is not as hitech as you might think... all are cooking with water.');
			case 'alchemy': return $this->reply('I can teach you alchemy for a little favor.');
			case 'invite': return $this->reply('I have no time for parties.');
			case 'malois': return $this->reply('Never heard of him.');
// 			case 'yes':
// 			case 'no':
			case 'negotiation': return $this->reply('Negotiate negotiate .... all want to negotiate ... my prices are fair.');
			
			case 'hello': 
			default:
				return $this->reply("Hello my name is Newton, your alchemic milestone :)");
		}
	}
}
?>