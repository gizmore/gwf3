<?php
final class TrollHQ2_TrollChief extends SR_TalkingNPC
{
	public function getName() { return $this->getPartyID() > 0 ? parent::getName() : 'Larry'; }
	public function getNPCPlayerName() { return 'Larry'; }
	public function getNPCLevel() { return 16; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCQuests(SR_Player $player) { return array('Troll_Intro', 'Troll_Feed', 'Troll_Support', 'Troll_Forever', 'Troll_Maniac'); }
	public function getNPCModifiers()
	{
		return array(
			'race' => 'troll',
			'strength' => rand(8, 12),
			'quickness' => rand(1, 2),
			'melee' => rand(6, 9),
			'base_hp' => rand(40, 48),
			'distance' => rand(4, 8),
			'nuyen' => rand(100, 200),
		);
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'NinjaSword',
			'armor' => 'KevlarVest',
			'boots' => 'KevlarBoots',
			'helmet' => 'SamuraiMask',
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		if ($this->onNPCQuestTalk($player, $word))
		{
			return true;
		}
		switch ($word)
		{
			case 'renraku': #return $this->reply('I hate Renraku. They discriminate Orks and Trolls.');
			case 'hello': #return $this->reply('Me is Larry. You better have reason for the visiting me.');
			case 'hire': #return $this->reply('You kidding?');
			case 'blackmarket': #return $this->reply('I have better stuff than blackmarket.');
			case 'cyberware': #return $this->reply('Tough trolls not need cyberware.');
				return $this->rply($word); 
			default:
				return $this->rply('default');
// 				return $this->reply("What is you want?");
		}		
	}
}
?>
