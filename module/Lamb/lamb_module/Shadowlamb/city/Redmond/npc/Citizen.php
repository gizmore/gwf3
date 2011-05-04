<?php
final class Redmond_Citizen extends SR_TalkingNPC
{
	public function getNPCLevel() { return 1; }
//	public function getNPCPlayerName() { return Shadowfunc::getRandomName($this); }
	public function getNPCMeetPercent(SR_Party $party) { return 100.00; }
	public function canNPCMeet(SR_Party $party) { return true; }
	public function getNPCLoot(SR_Player $player) { return array('Cake'); }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'Knife',
			'armor' => 'Clothes',
			'legs' => 'Trousers',
		);
	}
	public function getNPCInventory() { return array(); }
	public function getNPCModifiers() {
		return array(
			'nuyen' => rand(10, 20),
			'base_hp' => rand(-8, -6),
		);
	}
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'shadowrun': case 'yes':
				$this->reply("I am looking for a job. Would you like to {$b}hire{$b} me?");
				$player->giveKnowledge('words', 'Hire');
				break;

			case 'no':
				$this->reply("Sure, you are not a runner... though you look like a runner to me.");
				break;
				
			case 'hire':
				
//				$player->get('charisma') + $player->get('reputation');
				$this->reply('You look not very skilled. I better follow my own way.');
				break;
				
			default:
			case 'hello':
				$this->reply("Hello chummer. Are you on a {$b}Shadowrun{$b}?");
				$player->giveKnowledge('words', 'Yes');
				$player->giveKnowledge('words', 'No');
				$player->giveKnowledge('words', 'Shadowrun');
				break;
		}
	}
}
?>