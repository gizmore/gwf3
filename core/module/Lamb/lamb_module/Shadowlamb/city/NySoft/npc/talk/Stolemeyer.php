<?php
/**
 * Richard Stolemeyer. As the name suggests, he is an asshole.
 * @author gizmore
 */
final class NySoft_Stolemeyer extends SR_TalkingNPC
{
	public function getName() { return $this->getPartyID() > 0 ? parent::getName() : 'Mr.Stolemeyer'; }

	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$quest = SR_Quest::getQuest($player, 'Renraku_III');
		if ($quest->isInQuest($player))
		{
			$p = $player->getParty();
			$p->notice('You confront Mr.Stoleymeyer with the illegal Renraku experiments...');
			$p->notice('"You are one of those bastards!", he shouts, "Tho shalt not escape!" ... he calls for his minions...');
			$p->fight(SR_NPC::createEnemyParty('NySoft_Stolemeyer','Redmond_Lamer','TrollCellar_Imp','Redmond_Ueberpunk','Seattle_Shaolin','Redmond_Ueberpunk','Prison_GrayOP','Delaware_Goth','Chicago_Commando'));
			return true;
		}
		
		$b = chr(2); # bold
		switch ($word)
		{
			case 'seattle': return $this->reply("Why?");
			case 'shadowrun': return $this->reply("Go away.");
			case 'cyberware': return $this->reply("Stop talking.");
			case 'magic': return $this->reply("You are not worth talking about that.");
			case 'hire': return $this->reply("Hah!");
			case 'blackmarket': return $this->reply("You are wrong here.");
			case 'bounty': return $this->reply("I can arrange things, but not for you.");
			case 'alchemy': return $this->reply("...");
			case 'invite': return $this->reply("Pleaes leave my office now.");
			case 'renraku':
				if ($quest->isDone($player))
				{
					return $this->onTalkToStolemeyer($player);
				}
				else
				{
					return $this->reply("We have nothing todo with Renraku.");
				}
			case 'malois': return $this->reply("We have nothing todo with the Malois case.");
			case 'bribe': return $this->reply("I am not a bribeable person.");
			case 'yes': return $this->reply("You think so.");
			case 'no': return $this->reply("Go away!");
			case 'negotiation': return $this->reply("We don't negotiate. We are professionals.");
			case 'hello': return $this->reply("Hello?");
			default: return $this->reply("Yes?");
		}
	}
	
	private function onTalkToStolemeyer(SR_Player $player)
	{
		$this->reply("Ok ok chummer, they are using our software to control genetic experiments.");
		$this->reply("It's probably not legal, that's all i know. Heck i am not even sure what kind of DNA they to mix... Please leave now.");
		$this->reply("Maybe you should find out what DNA they play with first :O.");
		$quest4 = SR_Quest::getQuest($player, 'Renraku_IV');
		if ($quest4->isUnknown($player))
		{
			$quest4->accept($player);
		}
		return true;
	}
	

	##############
	### Fight! ###
	##############
	public function getNPCLevel() { return 28; }
	public function getNPCPlayerName() { return 'Richard'; }
	public function canNPCMeet(SR_Party $party) { return false; }
	public function getNPCMeetPercent(SR_Party $party) { return 20.00; }
	public function getNPCEquipment()
	{
		return array(
			'weapon' => 'M16',
			'armor' => 'KevlarVest',
			'legs' => 'KevlarLegs',
			'boots' => 'ArmyBoots',
			'shield' => 'KevlarShield',
			'amulet' => 'Amulet_of_body:4',
		);
	}
	
	public function getNPCInventory() {
		return array('Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Ammo_5mm', 'Katana', 'Stimpatch');
	}
	
	public function getNPCModifiers()
	{
		return array(
			'race' => 'human',
			'gender' => 'male',
			'melee' => 5,
			'strength' => 8,
			'quickness' => 16,
			'distance' => 10,
			'hmgs' => 12,
			'firearms' => 12,
			'sharpshooter' => 12,
			'intelligence' => 4,
			'nuyen' => 400,
			'base_hp' => 120,
		);
	}

	public function getNPCLoot(SR_Player $player)
	{
		$p = $player->getParty();
		$p->notice('"You bastard, we talk later...", Mr.Stolemeyer cries... and disappears from combat.');
		foreach ($p->getMembers() as $member)
		{
			$quest = SR_Quest::getQuest($player, 'Renraku_III');
			if ($quest->isInQuest($player))
			{
				$quest->onSolve($player);
			}
		}
		return array();
	}
}
?>