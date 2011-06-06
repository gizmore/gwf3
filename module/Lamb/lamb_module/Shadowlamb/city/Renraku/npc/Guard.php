<?php
final class Renraku_Guard extends SR_TalkingNPC
{
	public function getNPCLevel() { return 7; }
	public function getNPCPlayerName() { return 'Guard'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'renraku': $this->reply("The office is only for {$b}employee{$b}.");
			case 'employee': $this->checkIDCards($player); break;
			default: $this->reply("Good day sire. If you are not an {$b}employee{$b}, please move away.");
		}
	}
	
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'AresViper',
			'armor' => 'KevlarVest',
			'helmet' => 'Cap',
			'legs' => 'KevlarLegs',
		);
	}
	public function getNPCInventory() { return array('Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'Ammo_9mm', 'SmallFirstAid'); }
	public function getNPCModifiers() {
		return array(
			'race' => 'human',
			'gender' => 'male',
			'pistols' => rand(2, 3),
			'strength' => rand(2, 3),
			'quickness' => rand(2, 3),
			'firearms'  => rand(2, 3),
			'distance' => rand(2, 6),
			'sharpshooter' => rand(0, 2),
			'nuyen' => rand(20, 40),
			'base_hp' => rand(4, 9),
		);
	}
	
	private function checkIDCards(SR_Player $player)
	{
		$p = $player->getParty();
		$names = array();
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if (!$member->getInvItemByName('IDCard'))
			{
				$names[] = $member->getName();
			}
		}
		
		if (count($names) > 0)
		{
			$p->notice(sprintf("It seems like %s is/are missing an IDCard.", Common::implodeHuman($names)));
			$this->reply('Every person needs an own ID card. Move along.');
			return;
		}
		
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$card = $member->getInvItemByName('IDCard');
			$card->useAmount($member, 1);
			$this->reply('These ID cards need to be revoked and you have to get a new one. I will also have to keep them for investigation. I may let you pass as your security level is below 2.');
			$p->notice("Each member hands an IDCard to the guards and you enter the Renraku tower.");
			
			$p->giveKnowledge('places', 'Renraku_Exit');
			
			$renraku = Shadowrun4::getCity('Renraku');
			$exit = $renraku->getLocation('Renraku_Exit');
			$renraku->onCityEnter($p);
			$exit->onEnter($player);
		}
	}
}
?>
