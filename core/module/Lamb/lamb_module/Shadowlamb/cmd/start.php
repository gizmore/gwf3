<?php
final class Shadowcmd_start extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$c = Shadowrun4::SR_SHORTCUT;
		$b = chr(2);
		
		if ($player->isCreated())
		{
			$bot->reply('Your character has been created already. You can type '.$c.'reset to start over.');
			return false;
		}

		$races2 = SR_Player::getHumanRaces();
		$races = implode(', ', $races2);
		$genders = implode(', ', array_keys(SR_Player::$GENDER));
		
		if (count($args) !== 2)
		{
			return self::onHelp($player, $races, $genders);
		}
		
		$race = strtolower($args[0]);
		if (!in_array($race, $races2, true))
		{
			$bot->reply('Your race is unknown or an NPC only race. Valid races: '.$races.'.');
			return false;
		}

		$gender = strtolower($args[1]);
		if (!SR_Player::isValidGender($gender))
		{
			$bot->reply('Your gender is unknown. Valid genders: '.$genders.'.');
			return false;
		}
		
		$player->saveOption(SR_Player::CREATED, true);

		$player->saveVars(array('sr4pl_race'=>$race,'sr4pl_gender'=>$gender));
		$player->initRaceGender();
		Shadowcmd_aslset::onASLSetRandom($player);
		$player->modify();
		$player->healHP(10000);
		$player->healMP(10000);
		
		$player->message('You wake up in a bright room... it seems like it is past noon...looks like you are in a hotel room.');
		$player->message('What happened... you can`t remember anything.... Gosh, you even forgot your name.');
		$player->message("You check your {$b}{$c}inventory{$b} and find a pen from 'Renraku Inc.'. You leave your room and walk to the counter. Use {$b}{$c}talk{$b} to talk with the hotelier.");
		$player->help("Use {$b}{$c}c{$b} to see all available commands. Check {$b}{$c}help{$b} to browse the Shadowlamb help files.");
	
		$player->giveItems(array(SR_Item::createByName('Pen')));
		$player->giveKnowledge('words', 'Renraku');
		$player->giveKnowledge('words', 'Shadowrun');
		$player->giveKnowledge('places', 'Redmond_Hotel');
		return true;
	}
	
	private static function onHelp(SR_Player $player, $races, $genders)
	{
//		$bot = Shadowrap::instance($player);
		$b = chr(2);
		$player->message(Shadowhelp::getHelp($player, 'start'));
		$player->message(sprintf("{$b}Known races{$b}: %s. {$b}Known genders{$b}: %s.", $races, $genders));
		return false;
	}
}
?>