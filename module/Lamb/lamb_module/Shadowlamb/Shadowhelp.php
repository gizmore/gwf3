<?php
final class Shadowhelp
{
	public static function getAllHelp(SR_Player $player)
	{
		$b = chr(2);
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		$back = array(
			'default' => "Check out these topics: attributes, spells, skills, combat, beginner, get_started, various.",

			# Attributes
			'attributes' => "These attributes describe your character: body, magic, strength, quickness, wisdom, intelligence, charisma, luck, reputation, essence.",
			'body' => "The body attribute raises your max_hp by ".SR_Player::HP_PER_BODY.'.',
			'magic' => "The magic attribute raises your max_mp by ".SR_Player::MP_PER_MAGIC.'.',
			'strength' => "The strength attribute raises attack for melee weapons. It also raises the max weight you can carry.",
			'quickness' => "Quickness raises your defense by increasing your chance to evade attacks. Also your busytime and explore times will decrease.",
			'wisdom' => "Wisdom increases duration of magic spells and increases your chance for successfull spell casting.",
			'intelligence' => "Intelligence increases the power of your magic spells.",
			'charisma' => "Charisma raises the time that hirelings follow you.",
			'luck' => "Luck increases the chance of better drops.",
			'reputation' => "Reputation determines how known you are amongs the world of Shadowlamb. Some quests require a minimum reputation.",
			'essence' => "Essence describes how wasted your body and mind is.",
		
			# Skills
			'skills' => 'You can learn the following skills: melee, ninja, firearms, bows, pistols, shotguns, smgs, hmgs, computers, electronics, biotech, negotiation, sharpshooter, searching, lockpicking, thief',
			'melee' => 'The melee skill will increase your attack for melee weapons.',
			'ninja' => 'The ninja skill will increase your damage and attack for ninja weapons.',
			'firearms' => 'The firearms skill will increase your damage and attack for fireweapons.',
			'bows' => 'The bows skill will increase your damage and attack for bows.',
			'pistols' => 'The firearms skill will increase your damage and attack for pistols.',
			'shotguns' => 'The shotguns skill will increase your damage and attack for shotguns.',
			'smgs' => 'The smgs skill will increase your damage and attack for small machine guns.',
			'hmgs' => 'The hmgs skill will increase your damage and attack for heavy machine guns.',
			'computers' => 'The computers skill will increase your chance to hack computers.',
			'electronics' => 'The electronics skill will increase your chance to disable traps.',
			'biotech' => 'The biotech skill will increase your healing when using items.',
			'negotiation' => 'The negotiation skill will lower prices when buying items, and raise prices when selling items.',
			'sharpshooter' => 'The sharpshooter skill will raise your chance for a critical hit.',
			'searching' => 'The searching skill will increase the dropchance on searches.',
			'lockpicking' => 'The lockpicking skill will increase your chance on picking locks.',
			'thief' => 'The thief skill will increase your chance on thieving items of shops and not getting caught. ',
		
			# Combat
			'combat' => 'Combat topics: combat1, combat2, combat3, busytime, death.',
			'combat1' => "In combat you have a one-item-stack. When your {$b}busytime{$b} is over your last command gets executed. The default {$b}command{$b} is {$c}attack <random>.",
			'combat2' => "Spells and weapons have a combat {$b}distance{$b}. Before you can attack an enemy, it has to be in range. Therefor, the #attack command will lock the target you have chosen.",
			'combat3' => "If you do nothing in combat, your default action is {$c}attack rand(), locking a random target.",
//			'combat4' => "Do not forget to cleanup your {$b}inventory{$b}. An {$b}overloaded{$b} {$b}character{$b} might get a malus on their combat stats.",
			'death' => "When you die you might loose a random item. Also you will loose {$b}XP{$b} and {$b}nuyen{$b} you might have in your pocket.",
			'busytime' => "When a fight starts, you have an initial busytime. When this time is over your last command gets executed, and you get busy again, depending on your action.",
//			'distance' => '',
		
			# Beginners
			'get_started' => 'First you should #talk to the hotelier. then you should #equip clothes. Then you should #party up with players and #join their parties. Then you should #explore the first city.',
			'level' => 'There is not really a level in Shadowlamb, but '.SR_Player::XP_PER_LEVEL.' XPs equal 1 level. It also determines which enemies you can encounter.',
		
			# Various
			'various' => 'I know about: annoying, bots.',
			'annoying' => "Bot is highlighting too much? Check out: {$b}annoy_kvirc{$b}.",
			'annoy_kvirc' => "Add a new event handler for 'OnQueryMessage'. Code: if(\$0 == \"BotNick\"){ echo \$3-; halt; }",
			'bots' => 'You are not allowed to do actions with an automated script (botting). If you get caught all your characters will be deleted. Do not whine! You have been warned!',
			'cheating' => 'If you get caught all your characters will be deleted. Do not whine! You have been warned!',
			'nuyen' => 'Nuyen is the currency(money) in Shadowlamb. It means "New Yen"',
			'xp' => "Collect ".'11'." XP and gain 1 {$b}Karma{$b}. With Karma you can {$c}{$b}lvlup{$b}.",
			'karma' => "With karma you can #{$b}lvlup{$b} your skills, attributes and spells.",
			'lvlup' => "Use #lvlup to spend karma on a skill, attribute or spell.",
			'range' => 'In combat you have a range and position. Party A has positive position and Party B has negative postition. You need to be in range for weapons and spells.',
			'school' => 'You should go to school and learn more skills.',
			'location' => "In Shadowlamb each party has a location. There are multiple cities or buildings with lots of locations. You can {$c}goto locations and {$c}explore your current city to find more. Check your {$c}kp to see all your known places in the current city.",
			'npc' => 'Currently there exist '.SR_NPC::$NPC_COUNTER.' different NPCs in '.SR_Location::$LOCATION_COUNT.' locations.',
			'distance' => "Imagine the combat as a line. +10 +8 +6 +4 +2 +0 -2 -4 -6 -8 -10. One party starts in the positive, the other in the negative. You can set your default distance with {$c}sd.",
			'statted' => "Statted means crafted, like Cap_of_strength:1. The more modifiers the more complex is your item. The higher the modifiers, the more complex is your item. {$c}upgrade the number of modifiers is way more complex than {$c}upgrade a single modifier.",
			# Eastereggs
			'jmoncayo' => 'jmoncayo is the founder of the \'School of Fireweapons\' in Redmond.',
			'caesum' => 'Caesum is the founder of the \'School of Cryptography and applied Math\' in Seattle.',
			'livinskull' => 'livinskull is the founder of the "School of Computers" in the Amerindian Area.',
			'freeartman' => 'FreeArtMan is the founder of the "School of Electronics" in the Amerindian Area.',
			# Stats
			'atk' => 'Your chances to hit.',
			'def' => 'You chance to evade attacks. Reduces hits. You can increase defense with quickness',
			'defense' => 'You chance to evade attacks. Reduces hits. You can increase defense with quickness',
			'arm' => "Armor reduces damage. There are two types of armor: {$b}marm{$b} and {$b}farm{$b}.",
			'armor' => "Armor reduces damage. There are two types of armor: {$b}marm{$b} and {$b}farm{$b}.",
			'marm' => 'Your melee armor. Reduces melee damage.',
			'farm' => 'Your fireweapon armor. Reduces firearms damage.',
		
			# items
			'items' => 'There are currently '.SR_Item::getTotalItemCount().' different items in Shadowlamb.',
			'rune' => "You can runecraft items at the Blacksmith, but you need to solve the blacksmith quest first.",
			'runes' => "You can runecraft items at the Blacksmith, but you need to solve the blacksmith quest first.",
		
			'shadowlamb' => "Shadowlamb is a full featured mmorpg. You can create parties, solve quests, runecraft your items and learn magic spells. It combines multiple irc networks into a single gameworld, and thus is unique among all irc games.",
		);

		# Commands
		$back = array_merge($back, Shadowcmd::getAllHelp());
		
		# Spells
		$sp = '';
		foreach (SR_Spell::getSpells() as $name => $spell) { $back[$name] = $spell->getHelp($player); $sp .= ', '.$name; }
		$back['spells'] = sprintf('Known Spells: %s.', substr($sp, 2));
		
		# Races
//		foreach (SR_Player::$RACE AS $race)
//		{
//			
//		}
		
		return $back;
	}

	###############
	### Trigger ###
	###############
	public static function getHelp(SR_Player $player, $topic)
	{
		$help = self::getAllHelp($player);
		
		if (isset(Shadowcmd::$CMD_SHORTCUTS[$topic])) {
			$topic = Shadowcmd::$CMD_SHORTCUTS[$topic];
		}
		
		
		if (!isset($help[$topic])) {
			$topic = 'default';
		}
		return $help[$topic];
	}
	
}