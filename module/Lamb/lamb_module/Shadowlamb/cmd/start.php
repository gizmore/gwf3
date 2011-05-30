<?php
final class Shadowcmd_start extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$c = Shadowrun4::SR_SHORTCUT;
		$b = chr(2);
		if ($player->isCreated()) {
			return $bot->reply('Your character has been created already. You can type '.$c.'reset to start over.');
		}

		$races = SR_Player::getHumanRaces();
		$races = implode(', ', $races);
		$genders = implode(', ', array_keys(SR_Player::$GENDER));
		
		if (count($args) !== 2)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'start'));
			return $bot->reply(sprintf("{$b}Known races{$b}: %s. {$b}Known genders{$b}: %s.", $races, $genders));
		}
		
		$race = strtolower($args[0]);
		if (!SR_Player::isValidRace($race)) {
			return $bot->reply('Your race is unknown. Valid races: '.$races.'.');
		}

		$gender = strtolower($args[1]);
		if (!SR_Player::isValidGender($gender)) {
			return $bot->reply('Your gender is unknown. Valid genders: '.$genders.'.');
		}
		
		$player->saveOption(SR_Player::CREATED, true);

		$player->saveVars(array('sr4pl_race'=>$race,'sr4pl_gender'=>$gender));
		$player->initRaceGender();
		$player->modify();
		$player->healHP(10000);
		$player->healMP(10000);
		
		$player->message('You wake up in a bright room... it seems like it is past noon...looks like you are in a hotel room.');
		$player->message('What happened... you can`t remember anything.... Gosh, you even forgot your name.');
		$player->message("You check your {$b}{$c}inventory{$b} and find a pen from 'Renraku Inc.'. You leave your room and walk to the counter. Use {$b}{$c}talk{$b} to talk with the hotelier.");
		$player->help("Use {$b}{$c}c{$b} to see all available commands. Check {$b}{$c}help{$b} to browse the Shadowlamb help files.");
	
		$player->giveItems(SR_Item::createByName('Pen'));
		$player->giveKnowledge('words', 'Renraku');
		$player->giveKnowledge('places', 'Redmond_Hotel');
		
		return true;
	}
}
?>