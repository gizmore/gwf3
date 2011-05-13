<?php
final class Redmond_Ninja extends SR_TalkingNPC
{
	const TEMP_WORD = 'Redmond_Shr_Nin_sr';
	
	public function getName() { return 'The monk'; }
	
	private function meleeSkill(SR_Player $player, $word)
	{
		if ($player->getBase('melee') >= 0) {
			return true;
		}
		
		$this->reply('MMMh... you are unsure about your path...');
		$player->message('The monk strengthens your self confidence... you have learned the melee skill!');
		$player->updateField('melee', 0);
		$player->modify();
		return false;
	}
	
	public function onNPCTalk(SR_Player $player, $word)
	{
		if (false === $this->meleeSkill($player, $word)) {
			return;
		}
		
		$b = chr(2);
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		$quest = SR_Quest::getQuest($player, 'Redmond_Shrine');
		$amt = $quest->getNeededAmount();
		$has = $quest->isInQuest($player);
		$done = $quest->isDone($player);
		$price = 300;
		$son = $player->isMale() ? 'son' : 'daughter';
		
		switch ($word)
		{
			case 'ninja':
				$this->teachNinja($player, $price);
				break;
			
			case 'donate': case 'donation': case 'donating':
				$this->reply("It would be really kind from you if you donate a few Nuyen. For ".Shadowfunc::displayPrice($price)." i would teach you the {$b}ninja{$b} skill.");
				break;
			
			case 'yes':
				if ($player->hasTemp(self::TEMP_WORD)) {
					$this->reply("Thank you my $son. Good luck on your journey, and let buddha guide your way.");
					$quest->accept($player);
					$player->unsetTemp(self::TEMP_WORD);
				}
				else {
					$this->reply('Yes, you said yes.');
				}
				break;
				
			case 'no':
				if ($player->hasTemp(self::TEMP_WORD)) {
					$this->reply("Oh alright. Buddha will send us another person to help us.");
					$quest->decline($player);
					$player->unsetTemp(self::TEMP_WORD);
				}
				else {
					$this->reply('Saying "no" is a skill that many people lack in this world...');
				}
				break;
				
			case 'blackmarket':
				if ($done || $has) {
					$quest->checkQuest($this, $player);
				}
				else {
					$this->reply("Humm, the blackmarket is in {$b}Seattle{$b}... which is troublesome for us ... we could need some stuff from the blackmarket.");
					$this->reply('In fact we could need some weapons to help us defending the Orks, they keep attacking us for no reason.');
					$this->reply("Maybe you can bring us $amt Nunchakus so we can protect us better from their attacks? We will reward you very well.");
					$player->giveKnowledge('words', 'Yes','No','Seattle');
					$player->setTemp(self::TEMP_WORD, true);
				}
				break;
				
			case 'shadowrun':
				if ($done || $has) {
					$quest->checkQuest($this, $player);
				}
				else {
					$this->reply("Young $son, you look for a quest? We could need somebody who will organize some items from the {$b}blackmarket{$b}.");
					$player->giveKnowledge('words', 'Blackmarket');
				}
				break;
				
			case 'hello': default:
				if ($has === true) {
					$quest->checkQuest($this, $player);
				} else {
					$this->reply("Hello. What leads you to this sacred place? Maybe you are interested in {$b}donating{$b} some Nuyen to us?");
				}
				break;
				
		}
	}
	
	private function teachNinja(SR_Player $player, $price)
	{
		$p = Shadowfunc::displayPrice($price);
		
		if ($player->hasSkill('ninja')) {
			$this->reply('Thank you, but you already donated enough :)');
		} elseif ($player->hasNuyen($price)) {
			$player->pay($price);
			$player->updateField('ninja', 0);
			$this->reply("Thank you my friend. Come with me...");
			$player->message('The monk teaches you the Ninja Skill. This will improve attack and damage for ninja weapons.');
			$player->modify();
		} else {
			$this->reply("I am sorry, but learning the ninja skill cost $p.");
		}
	}
}
?>