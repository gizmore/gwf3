<?php
final class Quest_Chicago_OwlJohnsonRoundtrip extends SR_Quest
{
	public static $JOHNSONS = array(
		'Redmond_Johnson',
		'Seattle_DJohnson',
		'Seattle_GJohnson',
		'Delaware_DJohnson',
		'Delaware_MCJohnson',
	);
	
	public function getQuestName() { return 'Roundtrip'; }
	public function getQuestDescription() { return sprintf('Show the DataCrystal to all Mr.Johnson\'s in Redmond, Seattle and Delaware.'); }
	public function getRewardXP() { return 3; }
	public function getRewardNuyen() { return 450; }

	public function getCrystalData()
	{
		return $this->getQuestData();
	}
	
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$data = $this->getQuestData();
		
		if (count($data) === 5)
		{
			$npc->reply('I have your quest confirmed, well done. Here is your payment.');
			return $this->onSolve($player);
		}
		else
		{
			return $npc->reply(sprintf('Your mission is not over?'));
		}
	}

	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		$need = $this->getNeededAmount();
		$ny = $this->getRewardNuyen();
		$dny = Shadowfunc::displayNuyen($ny);
		
		switch ($word)
		{
			case 'shadowrun':
				$npc->reply("I have to securely inform some friends with some message.");
				$npc->reply("Can you show a DataCrystal to all my friends?");
				break;
			case 'confirm':
				$npc->reply("Just show them to all the Johnsons.");
				break;
			case 'yes':
				$player->giveItems(array(SR_Item::createByName('DataCrystal')), 'Mr.Johnson');
				$npc->reply("Just show them to all the Johnsons.");
				break;
			case 'no':
				$npc->reply('ok');
				break;
		}
		return true;
	}
	
	public function onRoundtripShow(SR_Player $player, SR_TalkingNPC $johnson)
	{
		# Has crystal?
		if (false === ($crystal = $player->getInvItemByName('DataCrystal', false)))
		{
			return false;
		}
		
		# Is a johnson?
		$name = $johnson->getNPCClassName();
		if (!in_array($name, self::$JOHNSONS, true))
		{
			echo "$name is NOT A JOHNSON!\n";
			return false;
		}

		# Already shown?
		$data = $this->getQuestData();
		if (in_array($name, $data, true))
		{
			echo "ALREADY SHOWN TO A JOHNSON!\n";
			return false;
		}

		# Save it!
		$data[] = $name;
		$this->saveQuestData($data);
		
		$player->message(sprintf('You show Mr. Johnson the data crystal ...'));
		$johnson->reply('Thank you ... this was very important!');
		return true;
	}
}
?>