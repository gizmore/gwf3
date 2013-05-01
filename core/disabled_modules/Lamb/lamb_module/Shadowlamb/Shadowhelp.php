<?php
/**
 * The evil Shadowhelp files.
 * @author gizmore
 */
final class Shadowhelp
{
	public static function unshortcut($word)
	{
		if ('' === ($word = strtolower(trim($word))))
		{
			return 'root';
		}
		$shortcuts = array(
			'def' => 'defense',
			'dmg' => 'damage',
			'skill' => 'skills',
			'attribute' => 'attributes',
			'bmi' => 'body_mass',
			'die' => 'death',
		);
		
		$shortcuts = array_merge($shortcuts, Shadowcmd::getCommandShortcutMap(), SR_Player::$ATTRIBUTE, SR_Player::$SKILL, SR_Player::$KNOWLEDGE, SR_Player::$MOUNT_STATS);
		
		if (true === isset($shortcuts[$word]))
		{
			return $shortcuts[$word];
		}
		
		return $word;
	}
	
	public static function getAllHelp($player=NULL)
	{
		$sell_rate = $player === NULL ? 10 : Shadowfunc::calcSellPrice(100/10, $player);
		$buy_rate = $player === NULL ? 100 : Shadowfunc::calcBuyPrice(100, $player);
		
		# XP karma
		$xp = $player === NULL ? 0 : round($player->getBase('xp'), 2);
		$xppk = $player === NULL ? SR_Player::XP_PER_KARMA : $player->getXPPerKarma();
		# XP level
		$xpl = $player === NULL ? 0 : round($player->getBase('xp_level'), 2);
		$xppl = $player === NULL ? SR_Player::XP_PER_LEVEL : $player->getXPPerLevel();
		# XP total
		$xpt = $player === NULL ? 0 : round($player->getBase('xp_total'), 2);
		
		$ele = $player === NULL ? 0 : $player->get('elephants');
		$ele_gain = $player === NULL ? 0 : $player->getHPGain();
		$ele_time = GWF_Time::humanDuration(SR_Player::HP_REFRESH_TIMER); 
		
		$orca = $player === NULL ? 0 : $player->get('orcas');
		$orca_gain = $player === NULL ? 0 : $player->getMPGain();
		$orca_time = GWF_Time::humanDuration(SR_Player::MP_REFRESH_TIMER); 
		
		$crit = $player === NULL ? 0 : sprintf('%.01f', $player->getCritPermille()/10); # permille -> percent
		
		$bad_karma = $player === NULL ? '' : sprintf(' Your current character has %.02f bad_karma.', $player->getBase('bad_karma')+SR_PlayerVar::getVal($player, '__SLBADKARMA', 0.00));
		
		$hjbk = SR_Mount::HIJACK_BAD_KARMA;

		$all_ny = GDO::table('SR_Player')->selectVar('SUM(sr4pl_nuyen+sr4pl_bank_nuyen)');
		$all_ny += GDO::table('SR_Clan')->selectVar('SUM(sr4cl_money)');
		$all_ny = Shadowfunc::displayNuyen($all_ny);
		
		$eqs = implode('|', array_keys(SR_Player::$EQUIPMENT));
		$back = array(
			'root' => "Check out these topics",
			array(
			
				'beginners' => 'First steps',
				array(
					'get_started' => 'First you should #talk to the hotelier. Then you should #equip clothes. Then you should #party up with players and #join their parties. Then you should #explore the first city.',
					'where_am_i' => 'You begin in the Redmond Hotel. Check your party status with #(p)arty. Check your #known_places with #(kp). Find new places with #(exp)lore. Do not forget to check your #e(q)uipment and cleanup your #(i)nventory.',
					'what_is_it' => "Shadowlamb is a full featured mmorpg. You can #(j)oin parties, solve #(qu)ests, runecraft your items and learn magic spells. It combines multiple irc networks into a single gameworld, and thus is unique among all irc games.",
					'first_talk' => 'You should #talk to the hotelier first. Use #talk <word|kw_id> to ask for something in particular. You will get your first_equipment.',
					'first_equipment' => 'The hotelier will give you some items. Check your #inventory and #equip them, so you are ready to #explore.',
				),
				
				'attributes' => "Player Command. Usage: #(a)ttributes. Attributes",
				array(
					'body' => "The body attribute raises your max_hp by ".SR_Player::HP_PER_BODY.'.',
					'magic' => "The magic attribute raises your max_mp by ".SR_Player::MP_PER_MAGIC.'. It also increases your MP refresh rate slightly.',
					'strength' => "The strength attribute raises attack for melee weapons. It also raises the max weight you can carry.",
					'quickness' => "Quickness raises your defense by increasing your chance to evade attacks. Also your busytime and explore times will decrease.",
					'wisdom' => "Wisdom increases duration of magic spells and increases your chance for successfull spell casting.",
					'intelligence' => "Intelligence increases the power of your magic spells. It also increases your magic defense.",
					'charisma' => "Charisma raises the time that hirelings follow you. It also betters the sell(+".Shadowfunc::SELL_PERCENT_CHARISMA."%) and buy(-".Shadowfunc::BUY_PERCENT_CHARISMA."%) prices for your character. You currently sell to {$sell_rate}% and buy to {$buy_rate}%.",
					'luck' => "Luck increases the chance of better drops.",
					'reputation' => "Reputation determines how famous you are amongst the world of Shadowlamb. Some quests require a minimum reputation.",
					'essence' => "Essence describes how wasted your body and mind is. Every player starts with an essence of 6. You cannot lvlup your essence. Although it is known that some rare runes can increase your essence. Essence is essential for magic, similar to intelligence.",
				),
				
				'skills' => 'Player Command. Usage: #(sk)ills. Show your learned Skills',
				array(
					'melee' => 'The melee skill will increase your attack for melee weapons.',
					'ninja' => 'The ninja skill will increase your damage and attack for ninja weapons. The ninja weapons extend melee weapons, so they get a big additional bonus.',
					'swordsman' => 'The swordsman skill will increase your damage and attack for swords. The swords extend the melee weapons, so they get an additional bonus.',
					'viking' => 'The viking skill will increase your damage and attack for axes. The axes extend the melee weapons, and get an additional bonus.',
					'firearms' => 'The firearms skill will increase your damage and attack for fireweapons.',
					'bows' => 'The bows skill will increase your damage and attack for bows.',
					'pistols' => 'The pistols skill will increase your damage and attack for pistols.',
					'shotguns' => 'The shotguns skill will increase your damage and attack for shotguns.',
					'smgs' => 'The smgs skill will increase your damage and attack for small machine guns.',
					'hmgs' => 'The hmgs skill will increase your damage and attack for heavy machine guns.',
					'computers' => 'The computers skill will increase your chance to hack computers.',
					'electronics' => 'The electronics skill will increase your chance to disable traps. It also increases the chance of a successful #hijack.',
					'biotech' => 'The biotech skill will increase your healing when using items.',
					'negotiation' => "The negotiation skill will lower prices when buying items(-".Shadowfunc::BUY_PERCENT_NEGOTIATION."%), and raise prices when selling items(+".Shadowfunc::SELL_PERCENT_NEGOTIATION."%). This is also effected by charisma. You currently sell to {$sell_rate}% and buy to {$buy_rate}%.",
					'sharpshooter' => 'The sharpshooter skill will raise your chance for a critical hit. This also applies to melee and ninja weapons.',
					'searching' => 'The searching skill will increase the dropchance on searches.',
					'lockpicking' => 'The lockpicking skill will increase your chance on picking locks. It also increases the chance of a successful #hijack.',
					'thief' => 'The thief skill will increase your chance on thieving items of shops and not getting caught. It also increases the chance of a successful #hijack.',
					'alchemy' => 'The alchemy skill improves the power of your AlchemicPotions. An AlchemicPotion is a spell in a bottle. Alchemic_Potion_of_spell. The other attributes equal the stats that are used when casting the spell from the bottle.',
				),
				
				'knowledge' => 'Your character can gather special knowledge during the game (unused)',
				array(
					'math' => 'Math knowledge will be helpful in some quests.',
					'crypto' => 'Advanced knowledge of cryptography will be helpful in some quests. All cryptograms can be solved by the players itself. A highlevel crypto character does not need to solve these by hand.',
					'stegano' => 'Advanced knowledge of steganography makes you see things that are not there. Most useful when wearing a TinfoilCap.',
					'indian_culture' => 'It will be useful to know about the amerindian culture in the 5th area.',
					'indian_language' => 'It will be useful to know about the amerindian language in the 5th area.',
				),
				
				'combat' => 'Combat topics',
				array(
					'combat1' => "In combat you have a one-item-stack. When your busytime is over your last command gets executed. The default command is #attack <random>.",
					'combat2' => "Spells and weapons have a combat distance. Before you can attack an enemy, it has to be in range. Therefor, the #attack command will lock the target you have chosen.",
					'combat3' => "If you do nothing in combat, your default action is #attack rand(), locking a random target.",
					'combat4' => "Do not forget to cleanup your inventory. An overloaded character might get a malus on their combat stats.",
					'busytime' => "When a fight starts, you have an initial busytime. When this time is over your last command gets executed, and you get busy again, depending on your action.",
					'range' => 'In combat you have a range and position. Party A has positive position and Party B has negative postition. You need to be in range for weapons and spells.',
					'range2' => 'Spells and weapons have a minimum range. A range of 2m has no malus in combat / is considered 0.',
					'distance' => "Imagine the combat as a line. +10 +8 +6 +4 +2 +0 -2 -4 -6 -8 -10. One party starts in the positive, the other in the negative. You can set your default distance with #sd.",
					'death' => "When you die you might loose a random item. Also you will loose XP and nuyen you might have in your pocket. You will respawn in your nearest respawn location which is mostly a Hotel.",
					'combat_lock' => 'In combat some commands lock your current target. The default command is attack random, which will also lock this target.',
				),
				
				'your_status' => 'Your character status',
				array(
				
					'gender' => 'Your gender',
					array(
						'male' => 'Males have a slight strength and body bonus.',
						'female' => 'Females have a slight intelligence and charisma bonus.',
					),
				
					'race' => 'There two major types of races',
					array(
					
						'player_races' => 'Available player races',
						array(
							'fairy' => 'The fairy is small, weak and very hard to play. It is meant to be a party character.'.self::helpRace('fairy'),
							'elve' => 'The elve is weak and difficult to play. He enjoys the arcane powers. As every elve he has a bonus on the bows skill.'.self::helpRace('elve'),
							'halfelve' => 'The halfelve are often merchants or teachers that stopped to learn magic.'.self::helpRace('halfelve'),
							'vampire' => 'Vampires are undead creatures. They have a low body and HP and trust in equipment they have collected over their years.'.self::helpRace('vampire'),
							'darkelve' => 'The darkelve combines melee, bows and magic into a playable character.'.self::helpRace('darkelve'),
							'woodelve' => 'The woodelve combines melee, bows and magic into a playable character.'.self::helpRace('woodelve'),
							'human' => 'The human is the intermediate character of the player_races.'.self::helpRace('human'),
							'gnome' => 'The gnome is a bit smaller than a halfork.'.self::helpRace('gnome'),
							'dwarf' => 'The dwarf is a bit smaller than a gnome.'.self::helpRace('dwarf'),
							'halfork' => 'The halfork is a bit dumb, but easy to play for beginners.'.self::helpRace('halfork'),
							'halftroll'=> 'The halftroll is a bit dumb, but very easy to play for beginners.'.self::helpRace('halftroll'),
							'ork' => 'The ork is dumb and easy to play for beginners.'.self::helpRace('ork'),
							'troll' => 'The population of trolls has increased by 140% in the last year.'.self::helpRace('troll'),
							'gremlin' => 'The gremlin is not meant to be played because it cannot swim.'.self::helpRace('gremlin')
						),
						
						'npc_races' => 'NPC only races',
						array(
							'droid' => 'An electronical device that makes your life harder.',
							'dragon' => 'A mysterious creature from the very same planet.',
						),
					),
					
					'asl' => 'Player command. Usage: #asl [<age|bmi|height>]. Use #aslset to setup your asl. Show your',
					array(
						'age' => 'Your character\'s age, in years.',
						'body_mass' => 'Your characters body_mass in gramm.',
						'height' => 'Your character\'s height in centimeters.',
					),
					
					'level' => 'Player command. Show the party- and memberlevels. Your level determines what mobs you can encounter. Collect '.$xppl.' XP to levelup.',
					'hp' => "HP are your hitpoints. Use #hp to see all party HP. You can refresh hitpoints in Hotel, or by healing items and spells.",
					'max_hp' => 'The maximum amount of HP your character can have. You can increase this with the body attribute or rune modifiers.',
					'mp' => "MP are your manapoints. Use #mp to see all party MP. To cast magic #spells you need MP. You can refresh manapoints in Hotel, or by using certain potions or items.",
					'max_mp' => 'The maximum amount of MP your character can have. You can increase this with the magic attribute or rune modifiers.',
					'atk' => 'Your amount of chances to hit. The more hits you generate the more damage you cause. Your atk should be around twice your maxdmg, or even higher.',
					'defense' => 'You chance to evade attacks. Reduces hits. You can increase defense with quickness',
					'damage' => 'The min and max damage you can cause.',
					'arm' => "Armor reduces damage. There are two types of armor",
					array(
						'marm' => 'Your melee armor. Reduces melee damage.',
						'farm' => 'Your fireweapon armor. Reduces firearms damage.',
					),
					'xp' => NULL,
					'karma' => NULL,
					'weight' => NULL,
					'max_weight' => 'The max_weight you can carry. If you exceed your max_weight you get a malus on your attack and defense or cannot move at all.',
					'nuyen' => NULL,
					'bad_karma' => "Bad karma determines how evil your character is. If you have bad karma you might encounter Polizia, also known as BlackOps. These will annoy the bad guys during their journey.$bad_karma",
					
					'special_stats' => 'There are some special stats too:',
					array(
						'casting' => 'Similar to the magic attribute, this skill increases your MP, but does not increase your MP refreshing.',
						'spellatk' => 'Increases your magic attack. This is also affected by essence and intelligence.',
						'spelldef' => 'Increases your magic defense. This is also affected by essence and intelligence.',
						'orcas' => "Increases your MP refreshening. This is also affected by the magic attribute. Your current orcas level is {$orca} and you gain {$orca_gain} every {$orca_time}.",
						'elephants' => "Increases your HP refreshening. Your current elephants level is {$ele} and you gain {$ele_gain} every {$ele_time}.",
						'critical' => "Your current chance of a critical hit is {$crit}%.",
					),
				),
				
				'effects' => 'Known effects',
				array(
					'alc' => 'The alcohol effect determines how drunk a character is. If a character is too drunk, it might do random actions in combat.',
					'caf' => 'The caffeine effect determines how caffinated a character is. If a character is too caffinated it cannot sleep.',
				),
				
//				'items' => "There are ".SR_Item::getTotalItemCount()." items",
//				self::getItemTree($player),
				
				'all_spells' => 'There are '.SR_Spell::getTotalSpellCount().' spells',
				self::getSpellTree($player),
				
				'all_cmds' => 'There are a lot of commands',
				array(
				
//					'www_cmds' => 'Wrapper Commands for the WWW',
//					array(
//						'helo' => 'Will make the www client join the irc network ... Kinda',
//					),
//					
//					'debug_cmds' => 'Debugging commands',
//					array(
//						'debug' => 'Undocumented',
//					),

					'leader_cmds' => 'Some special leader commands',
					array(
						'leader' => 'Leader command. Usage: #(le)ader <member_name|member_enum>. Set a new party leader for your party.',
						'party_loot' => "Leader command. Usage: #pl <killer|cycle|rand>. Define who loots the items from kills. The default is killer.",
						'party_order' => 'Leader command. Usage #party_order <member1> <member2>. Swap the order of two party members.',
						'fight' => 'Leader Command. Usage: #(fi)ght [<player>]. When you meet talking parties on the street you can #fight them. This command also works inside PVP locations.',
						'bye' => 'Leader Command. Usage: #bye. Say goodbye to a talking party. If you meet humans, both have to say bye so the "evil" players get a chance to kill you.',
						'kick' => 'Leader command. Usage: #kick <player>. Kick a player from you party. See #ban.',
						'ban' => 'Leader command. Usage: #ban [<player>]. Ban all or one player from your party. If no argument is given you ban all players.',
						'unban' => 'Leader command. Usage: #unban [<player>]. Unban all or one player from your party. If no argument is given your party will be open to all players again.',
					),
					
					'guest_cmds' => 'These commands always work',
					array(
						'start' => 'Player command. The first command you have to type in Shadowlamb. Usage: #start <race> <gender>. Each race has a different bonus. The human is medium. Left from it has more magic. Right from it has more melee.',
						'help' => 'Browse the Shadowhelp file. Usage: #help [<keyword>].',
						'stats' => 'Print current gameworld stats.',
						'motd' => 'Print the current "message of the day".',
						'world' => 'Print info about the world of Shadowlamb.',
						'players' => 'Usage: #players <page>. Print info about the current players. Paginated.',
						'parties' => 'Usage: #parties <page>. Print info about the current active parties, paginated.',
					),
					
					'gm_cmds' => '"Game Master" commands for debugging and cheating',
					array(
						'gm' => 'GM command. Usage: #gm <username> <field> [<value>].',
						'gmc' => 'GM command. Usage: #gmc. Cleanup the database. Handle with care!',
						'gmd' => 'GM command. Usage: #gmd <player> <remote command to execute>.',
						'gmi' => 'GM command. Usage: #gmi <username> <item_name>. Example: gmi gizmore LeatherVest_of_strength:1,quickness:4,marm:4,foo:4',
						#'gmk' => 'GM command. Usage: #gmk <username> <field> <knowledge>',
						'gml' => "GM command. Usage: #gml <username> <city_location> [inside|outside]. Teleport a party to a location. By default parties end up outside of the location.",
						'gmm' => "GM command. Usage: #gmm <the message>. Send a hyperglobal message to all Shadowlamb channels.",
						'gmn' => "GM command. Usage: #gmn <the message>. Send a hyperglobal message to all Shadowlamb players.",
						'gmq' => "GM command. Usage: #gmq <username> <quest> [amount|data] [<value>]. Get or set quest information.",
						'gms' => "GM command. Usage: #gms <player>. Print a lot of status of a player.",
						'gmsp' => "GM command. Usage: #gmsp <player> <spell> <level>. Adjust the spell for a player.",
						'gmt' => "GM command. Usage: #gmt <username> <enemy,enemy,...>. Attack a party with enemies for debugging purposes.",
					),
						
					'status_cmds' => 'Commands for player information',
					array(
						'commands' => "Player command. Usage: #(c)ommands. List your currently available commands. These are ordered by always,leader,special,location and change depending on your current location and party action.",
						'ccommands' => "Player command. Usage: #(cc)ommands. List many hidden default commands. These always work and you maybe don't even use them.",
						'status' => 'Player command. Usage: #(s)tatus. View your status.',
						'attributes' => NULL,
						'skills' => NULL,
						'asl' => NULL,
						'aslset' => "Player command. Usage: #aslset RANDOM || #aslset <age>y <bmi>kg <hgt>cm. Example: #aslset 20y 140cm 80kg.",
						'equipment' => 'Player command. Usage: #e(q)uipment. View your equipment.',
						'sets' => 'Player command: Usage: #sets [<setpage|item_name|setname>]. Show all sets or list items and boni for an itemset.',
						array(
							'amulet' => 'You can #equip amulets and wear them as #equipment.',
							'armor' => 'You can #equip armory and wear them as #equipment.',
							'boots' => 'You can #equip boots and wear them as #equipment.',
							'earring' => 'You can #equip earrings and wear them as #equipment.',
							'helmet' => 'You can #equip helmets and wear them as #equipment.',
							'legs' => 'You can #equip legs and wear them as #equipment.',
							'ring' => 'You can #equip rings and wear them as #equipment.',
							'shield' => 'You can #equip shields and wear them as #equipment.',
							'weapon' => 'You can #equip weapons and wear them as #equipment.',
							'mount' => 'You can #equip mounts to lower your travel times. Also you can store items in them. There are also mount runes:',
							array(
								'lock' => 'LOCK determines the safety of your mount and prevents a #hijack. LOCK runes can only get applied on a mount.',
								'tuneup' => 'Tuneup runes can only be applied to a mount and reduce travel times.',
								'transport' => 'Transport runes can only be applied to a mount and increase the max weight it can store.',
							),
						),
				
						'party' => 'Player command. Usage. #(p)arty. View your party status.',
						'inventory' => 'Player command. Usage: #(i)nventory [<page|search>] <[page]>. View or search your inventory. See',
						array(
							'compare' => 'Player command. Usage: #(c)o(mp)are <item_name|inv_id|S_<view_id>|item_name> [<item2:inv_id|S_<view_id>|item_name>]. Will compare item1 with currently equiped item, or item2 if specified',
							'swap' => 'Player command. Usage: #(sw)ap <item1> <item2>. Will swap inventory item position',
							'sort' => 'Use the swap command to sort your inventory.',
						),
						'cyberware' => 'Player command. Usage: #(cy)berware [<cy_id>]. View your cyberware.',
						'effects' => 'Player command. Usage: #(ef)fects. View your current effects. For example after beeing the target of a spell or drinking a potion.',
						'examine' => 'Player command. Usage: #(ex)amine <inv_id|'.$eqs.'|item_name>. Examine your items.',
						'show' => 'Player command. Usage: #show [<player>] <inv_id|'.$eqs.'|item_name>. Show another player the examine string of your items, or behave like #examine.',
						'known_knowledge' => "Player command. Usage: #known_knowledge|#kk. List your known knowledge. Knowledge can help you on some quests but it is not required.",
						'known_places' => "Player command. Usage: #known_places|#kp <[city]>. List your known places in your current or specified city. You can go to them with #(g)oto. Use #(exp)lore to find new places.",
						'swapkp' => 'Player command. Usage: #swapkp <kp1> <kp2>. Swap the position of two known places in the current city.',
						'known_words' => "Player command. Usage: #known_words|#kw. List some useful words you have learned, which you can enumerate with #talk and #say.",
						'known_spells' => 'Player command. Usage: #known_spells|#ks <[ks_id|spell_name]>. List your known magic spells or examine a spell.',
						'quests' => 'Player command. Usage: #(qu)ests [<open|done|deny|fail|abort|missing|stats|cstats|searchterm|qu_id>] [<page|city>]. Shows info about your quests. To get quests you need to talk to the npc. Most often, the trigger is #talk shadowrun and #talk yes to get them.',
						'nuyen' => "Player command. Usage: #(n)u(y)en/#ny. Show the parties nuyen. Nuyen is the currency(money) in Shadowlamb. It means \"New Yen\". The nuyen is considered strong as there are only {$all_ny} in the whole world.",
						'karma' => 'Player command. Usage: #(ka)rma. Show the parties karma. With karma you can #lvlup your skills, attributes and spells.',
						'hp' => NULL,
						'mp' => NULL,
						'xp' => "Player command: Usage: #xp. Show party XP stats. In total you have collected {$xpt} XP",
						'weight' => "Player command. Usage: #(we)ight. Show how much stuff the party is carrying. You can increase your max_weight with strength. If you carry more than your max weight, you get a malus on attack and defense.",
						'lvlup' => "Player command. Usage: #lvlup [<skill|attribute|spell|knowledge>]. Increase your level for an attribute,skill,spell or knowledge by using karma. With no arguments show the list of things you can level up, the level they will go to, and how much karma is needed. Bolded karma values are ones you can 'afford'. ",
						'level' => NULL,
						'party_level' => 'A higher party level increases the drop chance for items.',
					),
					
					'chat_cmds' => 'Commands for chat and talk',
					array(
						'clan_message' => 'Player command. Usage: #(c)lan_(m)essage <your message ...>. Send a message to all your clan members. See: #help chat_cmds.',
						'party_message' => 'Player command. Usage: #(p)arty_(m)essage <your message ...>. Send a message to all party members. Useful for cross-server/cross-channel messages. See: #help chat_cmds.',
						'say' => "Player command. Usage: #say <#kw_id|the message>. If you meet other parties on street you can use #say to talk to them. Inside and outside locations this sends messages accross the servers. In fight this sends messages to enemy party. See: #help chat_cmds.",
						'talk' => "Player command. Usage: #talk <#kw_id|word>. In many locations you can use #talk to talk to the NPCs. If there is more than one NPC it is often #ttX. Always check your #c inside locations. Bold words during a talk indicate a further topic to talk about. See: #help chat_cmds.",
						'shout' => "Player command. Usage: #shout <the message>. Shout a message to all shadowlamb channels on all servers. See: #help chat_cmds.",
						'whisper' => "Player command. Usage: #(w)hisper <player> <the message>. Send a message to another player. This works accross networks. See: #help chat_cmds.",
						'whisper_back' => "Player command. Usage: #(w)hisper_(b)ack <the message>. Send a message back to the player who whispered you. See: #help chat_cmds.",
					),
					
					'combat_cmds' => 'Commands work in combat',
					array(
						'idle' => "Combat command. Usage: #idle. Do nothing.",
						'forward' => "Combat command. Usage: #forward|#fw. Move forward in distance.",
						'backward' => "Combat command. Usage: #backward|#bw. Move backwards in distance.",
						'flee' => "Combat command. Usage: #(fl)ee. Try to flee from the enemy. If successful you will #part the current #(p)arty. You will also loose some XP.",
						'attack' => "Combat command. Usage: #attack|## [<enemy_name|enemy_enum>]. Select your target to attack with your weapon. Attack will lock your target, so you don't need to type attack all the time. See #help busytime and #help combat. See atk to see what the atk stat does.",
						'set_distance' => 'Player command. Usage: #(s)et_(d)istance/#sd <meters>. Set your default combat distance. The max distance is '.SR_Player::MAX_SD.'.',
					),
					
					'action_cmds' => 'Action commands',
					array(
						'npc' => 'Leader command. Usage: #npc <thenpc> <the remote command>. Execute a command in the name of your NPC. Example: #npc 2 status.',
						'say' => NULL,
						'use' => 'Player command. Usage: #(u)se <inv_id|item_name> [<target_name|target_enum>]. Use an item. In combat this costs time.',
						'brew' => 'Player command. Usage: #(br)ew <spell> [<level>]. Try to brew a magic potion. Needs a WaterBottle and Mandrake(s).',
						'cast' => 'Player command. Usage: #(ca)st [<ks_id|spell_name>][:level] [<target_name|target_enum>]. Cast a spell. If spell is friendly the enum is member_enum. If spell is offensive the enum is enemy enum. See #ks|#known_spells for your spells.',
						'drop' => 'Player command. Usage: #(dr)op <inv_id|item_name> [<amount>]. Drop one or multiple items. Used to save weight.',
						'equip' => 'Player command. Usage: #(eq)uip <item_name|inv_id>. Equip yourself with an item. Will cost time in combat.',
						'unequip' => 'Player command. Usage: #uneqip|#uq <'.$eqs.'>. Unequip a wearing item. Will cost time in combat.',
						'reload' => "Player command. Usage: #(r)eload. Reload your weapon. This is only needed for fireweapons and costs time in combat.",
						'hijack' => "Leader command. Usage: #hijack [<target>]. Try to break into a player mount and steal an item. This will always add {$hjbk} bad karma to your character for trying such bad things.",
						'give' => 'Player command. Usage: #give <player_name> <inv_id|item> [<amount>]. Give a player in the same location some items. In combat this costs time. See also #givekp, #givekw and #giveny.',
						'givekp' => 'Player command. Usage: #givekp [<player_name>] <#(kp)_id|location>. Tell a player in your location about a known place. See #give, #givekw and #giveny. If no player is specified, it will tell all your party members about it.',
						'givekw' => 'Player command. Usage: #givekw [<player_name>] <#(kw)_id|word>. Tell a player in your location about a known word. See #give, #givekp and #giveny. If no player is specified, it will tell all your party members about it.',
						'giveny' => 'Player command. Usage: #giveny <player_name> <nuyen>. Give a player in your location some nuyen. See #give, #givekp and #givekw.',
					),
					
					'option_cmds' => 'Commands that change your player and client options',
					array(
						'redmond_reset' => 'Player command. Usage: #redmond. If idle you can teleport to Redmond_Hotel. This will cost some XP from the karmapool and part your current party.',
						'reset' => 'Player command. Usage: #reset. #reset. Use reset to delete your player and start over. Handle with care!',
						'enable' => 'Player command. Usage: #enable <help|notice|privmsg|lock|bot|norl|norefresh|noautolook>. Toggle player and interface options for your player.',
						'disable' => 'Player command. Usage: #disable <help|notice|privmsg|lock|bot>. Toggle user interface options for your player.',
						'running_mode' => "Player command. Usage: #(r)unning_(m)ode. Use it twice to convert your character into a real runner. This means raised max stats, but permanent death. The permdeath rule applies only when killed by NPC or other Runners / RM Players.",
					),
					
					'move_cmds' => 'Commands that change the party location or action',
					array(
						'explore' => 'Leader command. Usage: #(exp)lore. Start to explore the current city. When the explore time is over, you find a new #kp. When you have found a new known_place, you are outside of it. Use #(en)ter to enter it.',
						'goto' => "Leader command. Usage: #(g)oto <kp_id|location>. Goto another place in your current city.",
						'hunt' => "Leader command. Usage: #hunt <player>. Hunt another human party. When your ETA is over, you will be in the same location, or meet the party on streets.",
						'enter' => 'Leader command. Usage: #(en)ter. Enter a location. Check your current location with #kp. Find new locations with #(exp)lore.',
						'exit' => 'Leader command. Usage: #exit. Exit a location and return outside of it in the same city. To leave a dungeon, use #leave in the dungeons exit.',
						'sleep' => "Leader command. Usage: #sleep. In Hotels and some other locations, you can sleep to rest and restore your HP and MP.",
						'stop' => "Leader command. Usage: #stop. The leader can interrupt a moving party with the stop command. Your #(exp)lore and #(g)oto timers will reset.",
					),
					
					'party_cmds' => 'Party commands',
					array(
						'request_leader' => 'Player command. Usage: #(r)equest_(l)eader. Request leadership in case the current leader is away.',
						'join' => 'Player command. Usage: #(j)oin <player>. Join the party of another player who is at the same location as you. You can #look to see which players are around you.',
						'part' => 'Player command. Usage: #(pa)rt. Leave your current party and create a fresh one.',
						'info' => "Player command. Usage: #info. Show the info text of your current location.",
						'clan' => 'Player command. Usage: #clan [<player|historypage|!(m)embers>] [<memberpage>]. Show clan info for a player or browse the clan history or member pages.',
					),
					
					'mount_cmds' => 'Mount commands',
					array(
						'mount' => 'Player command. Usage #(mo)unt [<push|pop|clean>] [<item>]. Show your mount or push and pop items from it. Items in your mount can be stolen via #hijack from other players.',
						'mounts' => 'Player command. Usage #(mo)unt(s). Show all the mounts in your party.',
					),
					
					'location_cmds' => 'All location commands',
					array(
					
						'look' => "Location command. Usage: #(lo)ok. Look around to spot other players in your current location. You can see players from other servers too.",
					
						'shop_cmds' => 'Store commands',
						array(
							'buy' => 'Location command. Usage: #(bu)y <view_id|item_name> [<amount>]. In shops you can buy items with this command. The price depends on your negotiation.',
							'sell' => 'Location command. Usage: #(se)ll <inv_id|item_name> [<amount>]. In shops you can sell your items with this command. The price depends on your negotiation.',
							'secondhand_sell' => 'Location command. Usage: #(se)ll <inv_id|item_name>. In second hand stores you can only sell equipment, but modified items get slightly better prices here.',
							'steal' => 'Location command. Usage: #(st)eal [<view_id>]. In some shops you can steal items with this command. Beware, you can get caught and get bad_karma.',
							'view' => 'Location command. Usage: #(v)iew [<pattern>] [<page>]. In shops and alike you can use view to list or search items stored there.',
 							'viewi' => 'Location command: Usage: #(v)iew(i) <view_id>. In shop and alike you can use viewi to examine items stored there.',
						),
							
						'alchemist_cmds' => 'Alchemist commands',
						array(
							'recipes' => 'Location command. Usage: #recipes [<recipe>]. Show all the recipes here that you can create with #recipe, or show the details of a single recipe.',
							'recipe' => 'Location command. Usage: #recipe <recipe>. Create a recipe from it\'s incredients.',
						),
						
						'bank_cmds' => 'Bank commands',
						array(
							'push' => NULL,
							'pushy' => "Location command. Usage: #pushy <amount>. In banks you can store items and nuyen to keep them safe for later usage.",
							'pop' => NULL,
							'popy' => "Location command. Usage: #popy <amount>. In banks you can store items and nuyen to keep them safe for later usage.",
							'bank_search' => 'Location command. Usage: #search <term> [<page>]. Search your bank for items.',
						),
						
						'bazar_cmds' => 'Bazar commands',
						array(
							'bazar_view' => 'Bazar command. Usage #(v)iew [<player>] [<item>]. Browse the bazar.',
							'bazar_push' => 'Bazar command. Usage #push <item> <price> [<amt>]. Push your items to the bazar and offer it for a price.',
							'bazar_pop' => 'Bazar command. Usage #pop <item>. Remove an item from your bazar and put it back into your inventory. The fee is 50Y.',
							'bazar_buy' => 'Bazar command. Usage #buy <player> <item> [<amt>]. Buy an item from the bazar.',
							'bazar_buyslot' => 'Bazar command. Usage: #buyslot [<CONFIRM>]. Buy another slot in your bazar to sell items. ',
							'bazar_price' => 'Bazar command. Usage: #price <item> <price>. Set a new price for one of your items offered in your bazar.',
							'bazar_search' => 'Bazar command. Usage: #search <item_name>. Search the bazar for items in their full-name.',
							'bazar_bestbuy' => 'Bazar command. Usage: #bestbuy <item_name> <price> [<amt>]. Try to purchase an item for a given price or less.',
						),

						'smith_cmds' => 'Blacksmith commands',
						array(
							'clean' => 'Location command. Usage: #(cl)ean <item>. Will remove all modifiers from an item. The runes / modifiers will be lost.',
							'break' => 'Location command. Usage: #(b)rea(k) <item>. Will destroy an item and release it`s runes, which you will receive.',
							'split' => 'Location command. Usage: #split <rune>. Will split a rune into multiple runes. Useful to extract modifiers from high level runes.',
							'upgrade' => 'Location command. Usage: #upgrade <item> <rune>. Apply a rune on your equipment. This may fail or even destroy the item.',
							'safeupgrade' => 'Location command. Usage: #safeupgrade <item> <rune>. Apply a rune on your equipment. This uses one amount of MagicOil and may still fail. However, breakchances are zero for this command.',
						),
							
						'piercer_cmds' => 'Piercer commands',
						array(
							'pierce' => 'Location command. Usage: #pierce <rune>. Apply a rune to your body. This rune cannot be upgraded further and is lost on #unpierce.',
							'unpierce' => 'Location command. Usage: #unpierce. Remove your piercing which will be lost forever.',
						),
						
						'school_cmds' => 'School and Temple commands',
						array(
							'courses' => 'Location command. Usage: #courses. In schools you can show available courses to learn.',
							'learn' => 'Location command. Usage: #learn <course>. In schools you can learn new skills and spells.',
						),
						
						'hospital_cmds' => 'Hospital commands',
						array(
							'implant' => 'Hospital command. Usage #implant <view_id|item>. In hospitals you can implant cyberware. Cyberware will cost essence, which is important for magic spells.',
							'unplant' => 'Hospital command. Usage #unplant <cy_id|item>. In hospitals you can unimplant your cyberware, in case it conflicts with other cyberware or you need more essence.',
							'heal_cmd' => 'Hospital command. Usage #heal. In hospitals you can quickly get healed for a small fee.',
							'surgery' => 'Hospital command. Usage #surgery [<section>]. Revert some lvlup into karma or change your class or gender. This is a quite costly process and could even cost you some cost essence.',
						),
						
						'subway_cmds' => 'Subway commands',
						array(
							'travel' => 'Location command. Usage: #travel [<target>]. In subways you can travel to other cities. When no argument is given, the available targets are shown.',
						),
//						
						'hotel_cmds' => 'Hotel commands',
						array(
							'sleep' => NULL,#'Location command. Usage: #sleep. In hotels you can sleep to recover your parties HP and MP. In some hotels this cost some nuyen.',
						),
						
						'dungeon_cmds' => 'Dungeon commands',
						array(
							'leave' => 'Location command. Usage: #leave. In most dungeons you can goto an exit and issue leave there to leave the dungeon.',
							'search' => 'Location command. Usage: #search. In some dungeon rooms you can use #search to search for hidden items.',
						),
							
						'clan_cmds' => 'ClanHQ commands',
						array(
							'clan_create' => 'Player command: Usage: #create <name>. Create your clan.',
							'clan_manage' => 'ClanLeader command. Usage: #manage <buywealth|buystorage|buymembers|slogan>. Manage your clan size and motto.',
							'clan_request' => 'Player command. Usage: #request <player>. Join another player\'s clan.',
							'clan_accept' => 'ClanLeader command. Usage #accept <player>. Accept another player\'s clan join request.',
							'clan_abondon' => 'Player command. Usage: #abondon. Abondon or even destroy your current clan. The clan has to be emptied for beeing destroyed.',
							'clan_toggle' => 'ClanLeader command. Usage #toggle <moderation>. Switch various clan setting bits.',
							'clan_pushy' => 'Player command. Usage: #pushy <amt>. Deposit money into your clan\'s bank.',
							'clan_popy' => 'Player command. Usage: #popy <amt>. Withdraw money out of your clan\'s bank.',
							'clan_push' => 'Player command. Usage: #push <item> <amt>. Deposit items into your clan\'s storage.',
							'clan_pop' => 'Player command. Usage: #pop <item> <amt>. Withdraw items out of your clan\'s storage.',
							'clan_view' => 'Player command. Usage: #view <page|item_name|searchterm>. Browse and view items in the clan bank.',
						),
					),
				),
				
				'various' => 'I know about',
				array(
				
					'action' => 'Each #(p)arty has an action',
					array(
						'action_delete' => 'This means the party is going to be deleted from database.',
						'action_talk' => 'This means the party is talking to another party.',
						'action_fight' => 'This means the party is fighting another party.',
						'action_inside' => 'This means the party is inside a location.',
						'action_outside' => 'This means the party is outside a location. Use #(en)ter to enter it.',
						'action_sleep' => 'This means the party is sleeping.',
						'action_travel' => 'This means the party is travelling to another city.',
						'action_explore' => 'This means the party is exploring the current city.',
						'action_goto' => 'This means the party is going to a location in the current city.',
						'action_hunt' => 'This means the party is hunting another human player.',
					),
					
					'location' => "Each (p)arty has a location. There are multiple cities and dungeons with lots of locations. You can #(g)oto your #known_places and #(exp)lore your current city to find more. Check your #kp to see all your known places in the current city. Cities",
					self::getLocationTree(),

					'annoying' => 'Annoying stuff',
					array(
						'annoy_kvirc' => "Add a new event handler for 'OnQueryMessage'. Code: if(\$0 == \"BotNick\"){ echo \$3-; halt; }",
						'bots' => 'You are allowed to write bots. Maybe you even like to contribute code or ideas to the AI. Although if you abuse your powers in-game, or your bot disturbs other players, you might get bad_karma, which will annoy you during your journey. If you use scripts, please #enable bot.',
						'clones' => 'You are allowed to have multiple characters, aka. Clones. For clones, the same rules as for bots apply.',
						'cheating' => 'If you get caught all your characters will be deleted. Do not whine! You have been warned!',
					),
				
					'features' => 'Features',
					array(
						'crafting' => 'Crafting System: ',
						array(
							'runes' => "You can runecraft items at the Blacksmith, but you need to solve the blacksmith quest first.",
							'statted' => "Statted means crafted, like Cap_of_strength:1. The more modifiers the more complex is your item. The higher the modifiers, the more complex is your item. Adding a new modifier is more complex than increasing the power of the same modifiers.",
						),
							
						'pvp' => 'PVP, or Player Vs Player, means attacking other humans. Most locations are non pvp, and you cannot #fight there. Dungeons usually have pvp enabled. Please note that outside of locations, pvp generally works.',
						array(
							'kill_protection' => '',
						),
							
// 						'items' => SR_Item::getTotalItemCount().' items: ',
// 						self::getItemTree($player),
					),
						
					'selection' => 'Selection: ',
					array(
						'enum' => 'To select items, words, places and spells, you can use the id from their respective status_commands; #inventory, #known_words, #known_places, #known_spells.',
						'id' => 'ID´s:',
						array(
							'inv_id' => 'inv_id means inventory ID, which is an enumeration of your invenotry items. The enumeration changes as less as possible, when removing or adding items.',
							'view_id' => 'view_id specifies an item from a shop by enumeration. This type of enum / ID works for buy and similar commands. With #compare you can use S_1 to reference the first shop item.',
							'spell_id' => 'Refer to your spell by using the id from #known_spells. Use #(k)nown_(s)pells to list your spells, use #(ca)st to cast a spell.',
							'kp_id' => 'A kp_id means the enum of one of your #(k)nown_(p)laces. You can find new known_places with #explore.',
							'kw_id' => 'The game stores common #talk triggers inside your #(k)nown_(w)ords. you can use their enumeration when using #talk.',
							'target_id' => 'Also with #cast, #attack and #use you can specify a target by enum. For friendly actions this is the ID from the #party command, for offensive actions this is the enemy_party member_id.',
							'player_id' => '',
							'server_id' => '',
							'npc_id' => '',
						),
						'shortcuts' => 'Most often you can use IDs and shortcut names to reference things. If you use shortcuts in names please use at least 3 characters.',
						'item_name' => 'Specify an item by name. You can use abbreviations, like lglo for TinfoilGloves, but an abbreviation has to be at least 3 characters in length.',
					),
					
					'events' => 'Events: ',
					array(
						'meet' => 'When you meet people or NPC on streets, you are in talk mode. Use #say to talk to the party you met. You can also use #join or #give or any other command you can imagine.',
						'encounter' => 'When you encounter an enemy party, you start to combat them. In combat you can do any cmd, and the default is to lock a random target.',
					),
					
					'teachers' => 'The teachers',
					array(
						'caesum' => 'Caesum is the founder of the \'School of Cryptography and applied Math\' in Seattle.',
						'digitalseraphim' => 'digitalseraphim is the founder of the School of Alchemy in Delaware.',
						'dloser' => 'There is not much notes on dloser yet.',
						'freeartman' => 'FreeArtMan is the founder of the "School of Electronics" in the Amerindian Area.',
						'jmoncayo' => 'jmoncayo is the founder of the \'School of Fireweapons\' in Redmond.',
						'livinskull' => 'livinskull is the founder of the "School of Computers" in the Amerindian Area.',
						'monnino' => 'Monsieur monnino teaches swordsmanship and other melee skills in the MeleeRange in Chicago.',
						'noother' => 'Mr. Northwood is the head of NySoft, the most successful software company in the 21th century.',
						'paipai' => 'Senor paiapi teaches hacking and spanish at the coelet institute.',
						'bsdhell' => 'bsdhell and kwisatz run the School of Assembly in Vegas.',
						'kwisatz' => 'kwisatz and bsdhell run the School of Assembly in Vegas.',
						'sabretooth' => 'Owner of the school of Social Engineering in Vegas. Narrator of many voices in the Shadowlamb Multiverse.',
						'more_teachers' => 'Erik, MiB, Tsutomu, epoch_qwert, Mawekl, InfoMirmo, Caesum, Edge, Sphinx, TheBlackSheep, ChaosDreamer, quangtenemy, matrixman, wb7331, Z, and a lot more!',
						'way_more_teachers' => 'TheHiveMind, Jinx, Garfield, jjk, dalfor, Jander, Kender, Inferno, digitalseraphim, spaceone!',
					),
					
					'options' => 'Player and interface options',
					array(
						'help_option' => 'You can dis/enable this option to receive some basic help messages or not.',
						'notice_option' => 'You can toggle your lamb reply type to NOTICE with #enable notice.',
						'privmsg_option' => 'You can toggle your lamb reply type to PRIVMSG with #enable privmsg.',
						'lock_option' => 'Dis/enable equipment lock, which determines how your (effective) level is computed. When you lock your equipment you cannot change it in combat.',
						'bot_option' => 'Dis/enable the bot flag for your player. This has no effect on the game, just that [BOT] is shown behind your playername as information.',
						'norl_option' => 'You can dis/enable this option to specify if it is allowed to steal your leadership with the #rl command.',
						'norefresh_option' => 'You can enable this option to supress HP/MP refreshing messages.',
						'noautolook_option' => 'You can enable this option to supress auto look, and arrival / leave messages.',
					),
					
					'glossary' => 'Some glossary of terms and keywords used.',
					array(
						'decker' => "In the Shadowrun(tm) world, a decker is a hacker, who directly connects to computersystem using cyberdecks.",
						'eta' => 'ETA means estimated time to arrival; How many time is left until your party completed an action.',
					),
				),
			),
		);
		return $back;
	}
	
//	private static function getItemTree($player)
//	{
//		$back = array('all_items' => 'to be done');
//		return $back;
//	}

	private static function getSpellTree($player)
	{
		$back = array();
		$spells = SR_Spell::getSpells();
		ksort($spells);
		
		foreach ($spells as $name => $spell)
		{
			$spell instanceof SR_Spell;
			if ( ($player === NULL) || ($spell->getBaseLevel($player) < 0) )
			{
				$back[$name] = self::getSpellHelpGuest($spell);
			}
			else
			{
				$back[$name] = self::getSpellHelp($spell, $player);
			}
		}
		return $back;
	}
	
	private static function getSpellHelpGuest(SR_Spell $spell)
	{
		return sprintf('%s %s. %s', $spell->displayType(), $spell->displayClass(), $spell->getHelp());
		
	}
	
	private static function getSpellHelp(SR_Spell $spell, SR_Player $player)
	{
		$maxlevel = $spell->getLevel($player);
		$costs = '';
		for ($level = 0; $level <= $maxlevel; $level++)
		{
			$costs .= sprintf(", L%d(%sMP)", $level, $spell->getManaCost($player, $level));
		}
		$costs = substr($costs, 2);
		return sprintf('%s %s. %s %s.', $spell->displayType(), $spell->displayClass(), $spell->getHelp(), $costs);
	}
	
	###############
	### Trigger ###
	###############
	private static function getHelpRec($topic, &$root, &$results)
	{
		$len = count($root);
		
		for ($i = 0; $i < $len; $i++)
		{
			$item1 = array_slice($root, $i, 1, true);
			$key1 = key($item1);
			$item1 = $item1[$key1];
			
			if (is_array($item1))
			{
				self::getHelpRec($topic, $item1, $results);
			}
			
			elseif ( (strtolower($key1) === $topic) && ($item1 !== NULL) )
			{
				$item2 = '';
				if ($i <($len-1))
				{
					$item2 = array_slice($root, $i+1, 1, true);
					$key2 = key($item2);
					$item2 = $item2[$key2];
				}
				
				$results[] = array($item1, $item2);
			}
		}
	}
	
	private static function collectKeysRec(&$root, &$keywords)
	{
		foreach ($root as $key => $value)
		{
			if (is_array($value))
			{
				self::collectKeysRec($root[$key], $keywords);
			}
			else
			{
				if (!in_array($key, $keywords, true))
				{
					$keywords[] = $key;
				}
			}
		}
	}
	
	public static function sort_strlen($a, $b)
	{
		return strlen($b) - strlen($a);
	}
	
	public static function getHelp(SR_Player $player, $topic)
	{
		$bot = Shadowrap::instance($player);
		
		if (false !== ($quest = SR_Quest::getQuestWithoutCity($player, $topic)))
		{
			return $quest->getQuestDescription();
		}
		
		if (false !== ($item = SR_Item::getItemCI($topic)))
		{
			return $item->getItemInfo($player);
		}
		
		# Shortcuts
		$topic = self::unshortcut($topic);
		
		# Build tree
		$help = self::getAllHelp($player);
		
		# Collect results
		$results = array();
		self::getHelpRec($topic, $help, $results);
		if (count($results) === 0)
		{
			return 'This help topic is unknown.';
		}
		
		# Display
		$back = '';
		$keywords = self::getHighlightKeywords();
		self::collectKeysRec($help, $keywords);
		usort($keywords, array(__CLASS__, 'sort_strlen'));
		foreach ($results as $result)
		{
			$back .= ' '.self::displayResult($bot, $result, $keywords);
		}
		return substr($back, 1);
	}
	
	private static function getHighlightKeywords()
	{
		return array('example');
	}
	
	private static function displayResult(Shadowrap $bot, array $two_items, array &$keywords)
	{
		list($text, $item) = $two_items;
		
		$keys = array();
		if (is_array($item))
		{
			foreach ($item as $key => $var)
			{
				if (is_string($var))
				{
					$keys[] = $key;
				}
			}
			$text .= ': '.implode(', ', $keys).'.';
		}

		# Highlight
		$b = chr(2);
		foreach ($keywords as $keyword)
		{
			$text = preg_replace("/([^a-z0-9_])({$keyword})([^a-z0-9_])/i", "$1{$b}$2{$b}$3", $text);
		}
		
		return $text;
	}
	
	private static function helpRace($race)
	{
		$base = SR_Player::$RACE_BASE[$race];
		$bonus = SR_Player::$RACE[$race];
		$out = array();
		foreach ($base as $k => $v) { $out[$k] = array(0, 0); }
		foreach ($bonus as $k => $v) { $out[$k] = array(0, 0); }
		foreach ($base as $k => $v) { $out[$k] = array($v, $v); }
		foreach ($bonus as $k => $v) { $out[$k][1] += $v; }
		
		unset($out['height']);
		unset($out['age']);
		unset($out['bmi']);
		
		$erace = GDO::escape($race);
		$pop = GDO::table('SR_Player')->selectVar('COUNT(*)', "sr4pl_race='$erace'");
		
		$back = sprintf(', Population(%d)', $pop);
		foreach ($out as $k => $data)
		{
			$back .= sprintf(', %s: %s(%s)', $k, $data[0], $data[1]);
		}
		
		return sprintf(' Stats: %s.', substr($back, 2));
	}
	
	private static function getLocationTree()
	{
		$back = array();
		foreach (Shadowrun4::$CITIES as $cityname)
		{
			$city = Shadowrun4::getCity($cityname);
			$back[$cityname] = sprintf('%s: %s', $cityname, $city->getArriveText(Shadowrun4::getCurrentPlayer()));
			$back[] = self::getLocationTreeB($cityname);
		}
		return $back;
	}
	
	private static function getLocationTreeB($cityname)
	{
		if (false === $city = Shadowrun4::getCity($cityname))
		{
			echo 'Unknown City in get location tree: '.$cityname.PHP_EOL;
			return array();
		}
		
		$player = Shadowrun4::getCurrentPlayer();
		
		$back = array();
		
		foreach ($city->getLocations() as $location)
		{
			$location instanceof SR_Location;
			if ($location->getFoundPercentage() <= 0)
			{
				continue;
			}
			$loc_name = $location->getName();
 			if ( ($location instanceof SR_Entrance) && ($location->getExitLocation() !== false) ) 
 			{
 				$exit_loc = $location->getExitCity();
 				$back[$exit_loc] = sprintf('%s: %s', $loc_name, $location->getFoundText($player));
 				$back[] = self::getLocationTreeB($exit_loc);
 			}
 			else
 			{
 				$back[$loc_name] = sprintf('%s: %s', $loc_name, $location->getFoundText($player));
 			}
		}
		return $back;
	}
}
?>
