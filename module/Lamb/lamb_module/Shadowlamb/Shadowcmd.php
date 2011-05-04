<?php
final class Shadowcmd
{
	const RL_TIME = 360;
	#################
	### Shortcuts ###
	#################
	public static $CMD_SHORTCUTS = array(
		'#' => 'attack',
		'a' => 'attributes',
		'bw' => 'backward',
		'c' => 'commands',
		'cy' => 'cyberware',
		'ef' => 'effects',
		'en' => 'enter',
		'eq' => 'equip',
		'ex' => 'examine',
		'exp' => 'explore',
		'fl' => 'flee',
		'fw' => 'forward',
		'g' => 'goto',
		'i' => 'inventory',
		'j' => 'join',
		'k' => 'knowledge',
		'ka' => 'karma',
		'kp' => 'known_places',
		'ks' => 'known_spells',
		'kw' => 'known_words',
		'l' => 'lvlup',
		'le' => 'leader',
		'ny' => 'nuyen',
		'p' => 'party',
		'pm' => 'party_message',
		'q' => 'equipment',
		'qu' => 'quests',
		'r' => 'reload',
		'rl' => 'request_leader',
		's' => 'status',
		'sd' => 'set_distance',
		'sp' => 'spell',
		'sk' => 'skills',
		'u' => 'use',
		'uq' => 'unequip',
		'we' => 'weight',
		'x' => 'flee',
	);
	private static function unshortcut($cmd)
	{
		return Shadowfunc::unshortcut($cmd, self::$CMD_SHORTCUTS);
//		return isset(self::$CMD_SHORTCUTS[$cmd]) ? self::$CMD_SHORTCUTS[$cmd] : $cmd;
	}
	
	private static function shortcut($cmd)
	{
		return Shadowfunc::shortcut($cmd, self::$CMD_SHORTCUTS);
//		
//		if (false === ($key = array_search($cmd, self::$CMD_SHORTCUTS, true))) {
//			return $cmd;
//		}
//		return $key;
	}
	
	################
	### Triggers ###
	################
	public static $CMDS_GM = array('gm','gmi','gml');
	public static $CMDS_ALWAYS_HIDDEN = array('helo','start','reset','enable','disable','redmond','c','ny','ka','hp','mp','we', 'gmstats');
	public static $CMDS_ALWAYS = array('help','s','a','sk','q','p','i','cy','ef','ex','kp','ks','kw','qu','sd','pm');
	public static $CMDS = array(
		'delete' => array(),
		'talk' => array('l','j','fight','bye','u','eq','uq','r','sp','part','give','drop','say'),
		'fight' => array('#','u','sp','fl','eq','uq','r','part','fw','bw','give'),
//		'search' => array(), 
		'inside' => array('l','rl','j','u','sp','eq','uq','r','part','give','drop','look'),
		'outside' => array('l','rl','j','u','sp','eq','uq','r','part','give','drop','look'),
		'sleep' => array(),
		'travel' => array('l','rl','u','sp','eq','uq','r','give','drop'),
		'explore' => array('l','rl','u','sp','eq','uq','r','part','give','drop'),
		'goto' => array('l','rl','u','sp','eq','uq','r','part','give','drop'),
		'hunt' => array('l','rl','u','sp','eq','uq','r','part','give','drop'), 
	);
	public static $CMDS_LEADER = array(
		'delete' => array(),
		'talk' => array('kick','ban','unban'),
		'fight' => array(),
//		'search' => array('ban','unban'), 
		'inside' => array('le','g','exp','hunt','kick','ban','unban','exit'),
		'outside' => array('le','g','exp','hunt','kick','ban','unban','en'),
		'sleep' => array('ban','unban'),
		'travel' => array('ban','unban'),
		'explore' => array('le','g','hunt','kick','ban','unban'),
		'goto' => array('le','g','exp','hunt','kick','ban','unban'),
		'hunt' => array('le','g','exp','hunt','kick','ban','unban'), 
	);
	public static function getCurrentCommands(SR_Player $player, $show_hidden=true)
	{
		$party = $player->getParty();
		$action = $party->getAction();
		$leader = $player->isLeader();
		
		# Allways commands
		$commands = self::$CMDS_ALWAYS;
		
		# GM commands
		if ($player->isGM()) {
			$commands = array_merge($commands, self::$CMDS_GM);
		}
		
		# Hidden commands
		if ($show_hidden === true) {
			$commands = array_merge($commands, self::$CMDS_ALWAYS_HIDDEN);
		}
		
		# Action commands
		if ($leader === true)
		{
			$commands = array_merge($commands, self::$CMDS_LEADER[$action]);
		}
		$commands = array_merge($commands, self::$CMDS[$action]);
		
		# Location commands
		if ( (false !== ($location = $party->getLocationClass('inside'))) && ($player->isCreated()) )
		{
			$commands = array_merge($commands, $location->getNPCTalkCommands($player));
			$commands = array_merge($commands, $location->getCommands($player));
			if ($leader === true)
			{
				$commands = array_merge($commands, $location->getLeaderCommands($player));
			}
		}
		
		return $commands;
	}
	
	################
	### Checkers ###
	################
	private static function checkCreated(SR_Player $player)
	{
		if ($player->isCreated()) {
			return false;
		}
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		return 'You did not start the game yet. Type '.$c.'start <race> <gender> to start your journey in Shadowlamb.';
	}
	
	private static function checkLeader(SR_Player $player)
	{
		if (false !== ($error = self::checkCreated($player))) {
			return $error;
		}
		if ($player->isLeader()) {
			return false;
		}
		return 'This command is only available to the party leader.';
	}
	
	private static function checkMove(SR_Party $party)
	{
		$back = '';
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if ($member->isDead()) {
				$back .= sprintf(', %s is dead', $member->getName());
			}
			elseif ($member->isOverloaded()) {
				$back .= sprintf(', %s is overloaded', $member->getName());
			}
		}
		return $back === '' ? false : 'You cannot move because '.substr($back, 2).'.';
	}
	
	############
	### Help ###
	############
	public static function getAllHelp()
	{
		$b = chr(2);
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		$eqs = implode('|', array_keys(SR_Player::$EQUIPMENT));
		
		return array(
			'start' => 'Player command. The first command you have to type in Shadowlamb. Usage: '.$c.'start <race> <gender>.',
			'reset' => 'Player command. Use reset to delete your player and start over. Handle with care!',

			'examine' => 'Player command. Examine your items. Usage: '.$c.'ex <inv_id|'.$eqs.'|itemname>',
			'skills' => 'Player command. View your skills. Known skills: '.implode(', ', SR_Player::$SKILL).'.',
			'attributes' => 'Player command. View your attributes. Known attributes: '.implode(', ', SR_Player::$ATTRIBUTE).'.',
			'cyberware' => 'Player command. View your cyberware. Usage: '.$c.'cy [<cywa_id>].',
			'spell' => 'Player command. View your spells or cast a spell. Usage: '.$c.'sp [<sp_id>] [<target>].',
			'status' => 'Player command. View your status.',
			'party' => 'Player command. View your party status.',
		
			'set_distance' => 'Player command. Usage: '.$c.'sd <meters>. Set your default combat distance.',
			'attack' => 'Player command. Usage: '.$c.'attack [<enemy>]. Select your target to attack with your weapon.',
			'use' => 'Player command. Usage: '.$c.'use <id|name> [<target>]. Use an item. In combat this costs time.',
			'drop' => 'Player command. Usage: '.$c.'drop <item>. Drop an item. Used to save weight.',
			'give' => 'Player command. Usage: '.$c.'give <whom> <i|ny|k|kp|kw> <id|amount|name> [<item_amount>]. Give another player in your location some stuff.',
			'equip' => 'Player command. Usage: '.$c.'equip <itemname|inv_id>. Equip yourself with an item. Will cost time in combat.',
			'unequip' => 'Player command. Usage: '.$c.'unequip <'.$eqs.'>. Unequip a wearing item. Will cost time in combat.',
		
			'join' => 'Player command. Usage '.$c.'join <player>. Join the party of another player.',
			'part' => 'Player command. Usage '.$c.'part. Leave your current party.',
		
			'enter' => 'Leader command. Usage: '.$c.'enter. Enter a '.$b.'location'.$b.'.',
			'exit' => 'Leader command. Usage: '.$c.'exit. Exit a '.$b.'location'.$b.'.',
			'quests' => 'Player command. Usage: '.$c.'quests [<accepted|rejected|done|failed|aborted>] [<id>]. Shows info about your quests.',
			'explore' => 'Leader command. Start to explore the current city.',
			'goto' => "Leader command. Usage: {$c}goto <#kp|location>. Goto another {$b}location{$b} in the {$b}current{$b} city.",
			'hunt' => "Leader command. Usage: {$c}hunt <player>. Hunt another {$b}human{$b} {$b}party{$b}.",
		
			'party_message' => 'Player command. Usage: '.$c.'pm <your message ...>. Send a message to all party members. Useful for cross-server/cross-channel messages.',
		
			'leader' => 'Leader command. Usage: '.$c.'leader <player>. Set a new party leader for your party.',
			'request_leader' => 'Player command. Usage: '.$c.'rl. Request leadership in case the current leader is away.',
		
			'flee' => 'Combat player command. Usage: '.$c.'flee. Flee from the enemy.',
		
			'fight' => 'Leader Command. Fight another party. Usage: '.$c.'fight [<player|party>].',
			'bye' => 'Leader Command. Say goodbye to another party. Usage: '.$c.'bye.',
		 
			'gm' => 'Game Master command. Usage gm <username> <field> <value>',
//			'gmk' => 'Game Master command. Usage gmk <username> <field> <knowledge>',
			'gmi' => 'Game Master command. Usage gmi <username> <itemname>. Example: gmi gizmore LeatherVest_of_strength:1,quickness:4,marm:4,foo:4',
		
			'enable' => 'Player command. Usage: '.$c.'enable <help|notice|privmsg>. Toggle user interface options for your player.',
			'disable' => 'Player command. Usage: '.$c.'enable <help|notice|privmsg>. Toggle user interface options for your player.',
			
			'lvlup' => "Player command. Usage: {$c}lvlup <{$b}skill{$b}|{$b}attribute{$b}|{$b}spell{$b}|{$b}knowledge{$b}>. Increase your {$b}level{$b} for an {$b}attribute{$b},{$b}skill{$b},{$b}spell{$b} or {$b}knowledge{$b} by using {$b}karma{$b}.",
		
			'buy' => 'Player command. Usage: '.$c.'buy <item>. In shops you can buy items with this command. The price depends on your negotiation.',
			'sell' => 'Player command. Usage: '.$c.'sell <item>. In shops you can sell your items with this command. The price depends on your negotiation.',
			'view' => 'Player command. Usage: '.$c.'view [<item>]. In shops you can view the shops items or examine a shop item with this command.',
		
			'break' => 'Player command. Usage: '.$c.'break <item>. Will destroy an item and release it`s runes, which you will receive.',
			'upgrade' => 'Player command. Usage: '.$c.'upgrade <item> <rune>. Apply a rune on your equipment. This may fail or even destroy the item.',
			'simulate' => 'Player command. Usage: '.$c.'simulate <item> <rune>. Simulates an upgrade and prints the odds of fail and destroy.',
		);
	}
	
	###############
	### Trigger ###
	###############
	public static function onTrigger(SR_Player $player, $message)
	{
		if ($player->isFighting())
		{
			$cmd = self::shortcut(Common::substrUntil($message, ' ', $message));
			if (in_array($cmd, self::$CMDS['fight'], true))
			{
				$player->combatPush($message);
				return;
			}
		}
		self::onExecute($player, $message);
	}
	
	############
	### Exec ###
	############
	public static function onExecute(SR_Player $player, $message)
	{
		$bot = Shadowrap::instance($player);
		$c = LambModule_Shadowlamb::SR_SHORTCUT;

		$args = explode(' ', $message);
		$cmd = self::shortcut(array_shift($args));
		$command = self::unshortcut($cmd);
		$commands = self::getCurrentCommands($player);

		if (!in_array($cmd, $commands, true)) {
			$bot->reply('The command is not available in your current location or does not exist. Try '.$c.'c to see all currently available commands.');
			return false;
		}
		
		$function = 'on_'.$command;
		$location = $player->getParty()->getLocationClass('inside');
		if (method_exists(__CLASS__, $function))
		{
			return call_user_func(array(__CLASS__, $function), $player, $args);
		}
		elseif ( ($location !== false) && (method_exists($location, $function)))
		{
			return call_user_func(array($location, $function), $player, $args);
		}
		elseif ( ($location !== false) && ($location->hasTalkCommand($player, $command)) )
		{
			return call_user_func(array($location, $command), $player, $args);
		}
		else
		{
			$bot->reply("Error: The function $function does not exist.");
			return false;
		}
	}
	
	################
	### Commands ###
	################
	public static function on_commands(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$commands = self::getCurrentCommands($player, false);
		$bot->reply(sprintf('Cmds: %s.', implode(',', $commands)));
		return true;
	}
	public static function on_help(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$help = Shadowhelp::getHelp($player, isset($args[0])?$args[0]:'');
		$bot->reply($help);
		return true;
	}
	public static function on_helo(SR_Player $player, array $args)
	{
		$player->message(sprintf('Welcome back to Shadowlamb, %s!', $player->getName()));
		return true;
	}
	
	#############
	### Start ###
	#############
	public static function on_start(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		$b = chr(2);
		if ($player->isCreated()) {
			return $bot->reply('Your character has been created already. You can type '.$c.'reset to start over.');
		}
		
		$races = implode(', ', array_keys(SR_Player::$RACE));
		$genders = implode(', ', array_keys(SR_Player::$GENDER));
		
		if (count($args) !== 2)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'start'));
			return $bot->reply(sprintf('Known races: %s. Known genders: %s.', $races, $genders));
		}
		
		$race = $args[0];
		if (!SR_Player::isValidRace($race)) {
			return $bot->reply('Your race is unknown. Valid races: '.$races.'.');
		}

		$gender = $args[1];
		if (!SR_Player::isValidGender($gender)) {
			return $bot->reply('Your gender is unknown. Valid genders: '.$genders.'.');
		}
		
		$player->saveOption(SR_Player::CREATED, true);

		$player->saveVars(array('sr4pl_race'=>$race,'sr4pl_gender'=>$gender));
		$player->initRaceGender();
		$player->healHP(10000);
		$player->healMP(10000);
		
		$player->message('You wake up in a bright room... it seems like it is past noon...looks like you are in a hotel room.');
		$player->message('What happened... you can`t remember anything.... Gosh, you even forgot your name.');
		$player->message("You check your {$b}{$c}inventory{$b} and find a pen from 'Renraku Inc.'. You leave your room and walk to the counter. Use {$b}{$c}talk{$b} to talk with the hotelier.");
		$player->help("Use {$b}{$c}c{$b} to see all available commands. Check {$b}{$c}help{$b} to browse the Shadowlamb help files.");
	
		$player->giveItems(SR_Item::createByName('Pen'));
		$player->giveKnowledge('words', 'Renraku');
		$player->giveKnowledge('places', 'Redmond_Hotel');
		
		$player->modify();
		return true;
	}
	
	/**
	 * Delete a character.
	 */
	public static function on_reset(SR_Player $player, array $args)
	{
		static $confirm = array();

		$bot = Shadowrap::instance($player);
		$c = LambModule_Shadowlamb::SR_SHORTCUT;
		
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		
		$pid = $player->getID();
		if (!isset($confirm[$pid]))
		{
			$confirm[$pid] = true;
			$bot->reply(sprintf('This will completely delete your character. Type %sreset again to confirm.', $c));
		}
		else
		{
			$player->message(sprintf('Your character has been deleted. You may issue %sstart again.', $c));
			$player->deletePlayer();
			unset($confirm[$pid]);
		}
		return true;
	}
	
	#############
	### Stats ###
	#############
	public static function on_status(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply(Shadowfunc::getStatus($player));
		return true;
	}
	
	public static function on_equipment(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply('Your equipment: '.Shadowfunc::getEquipment($player).'.');
		return true;
	}

	public static function on_attributes(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply(sprintf('Your attributes: %s.', Shadowfunc::getAttributes($player)));
		return true;
	}
	
	public static function on_skills(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply(sprintf('Your skills: %s.', Shadowfunc::getSkills($player)));
		return true;
	}
	
	public static function on_party(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply(Shadowfunc::getPartyStatus($player));
		return true;
	}
	
	public static function on_effects(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply(sprintf('Your effects: %s.', Shadowfunc::getEffects($player)));
		return true;
	}
	
	public static function on_inventory(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply('Your inventory: '.Shadowfunc::getInventory($player));
		return true;
	}
	
	public static function on_cyberware(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply('Your cyberware: '.Shadowfunc::getCyberware($player));
		return true;
	}
	
	public static function on_examine(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'examine'));
			return false;
		}
		
		if (false === ($item = $player->getItem($args[0]))) {
			$bot->reply('You don`t have that item.');
			return false;
		}
		
		$bot->reply($item->getItemInfo($player));
		return true;
	}

	public static function on_quests(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		
		$quest = false;
		switch (count($args))
		{
			case 2:
				$id = $args[1];
				if (!is_numeric($id)) {
					$bot->reply(Shadowhelp::getHelp($player, 'quests'));
					return false;
				}
				else {
					if (false === ($quest = SR_Quest::getByID($player, $args[0], $id))) {
						$bot->reply('This quest-id is unknown.');
						return false;
					} 
				}
			case 1:
				$section = $args[0];
				if (is_numeric($section)) {
					if (false === ($quest = SR_Quest::getByID($player, 'accepted', $section))) {
						$bot->reply('This quest-id is unknown.');
						return false;
					}
					$section = 'accepted';
				}
				break;
				
			case 0:
				$section = 'accepted';
				break;
				
			default: $bot->reply(Shadowhelp::getHelp($player, 'quests')); return false;
				
		}
		
		# Display info
		if ($quest === false)
		{
			if (false === ($message = Shadowfunc::getQuests($player, $section))) {
				$bot->reply(Shadowhelp::getHelp($player, 'quests'));
				return false;
			}
			$bot->reply(sprintf('Your %s quests: %s.', $section, $message));
			return true;
		}
		else
		{
			$bot->reply($quest->displayQuest());
			return true;
		}
	}
	
	public static function on_known_places(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$party = $player->getParty();
		$city = false;
		if (count($args) === 1) {
			$city = Shadowrun4::getCity($args[0]);
		}
		if ($city === false) {
			$city = $party->getCityClass();
		}
		$cityname = $city->getName();
		$bot->reply(sprintf('Known Locations in %s: %s.', $cityname, Shadowfunc::getKnownPlaces($player, $cityname)));
		return true;
	}
	
	public static function on_known_spells(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (count($args) === 1)
		{
			if (false === ($spell = SR_Spell::getSpell($args[0]))) {
				$bot->reply(sprintf('The spell %s is unknown.', $args[0]));
				return false;
			}
			else {
				$bot->reply(sprintf('%s level %s: %s', $spell->getName(), $spell->getLevel($player), $spell->getHelp($player)));
			}
		}
		else
		{
			$bot->reply(sprintf('Known spells: %s.', Shadowfunc::getSpells($player)));
		}
		return true;
	}

	public static function on_karma(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$party = $player->getParty();
		$members = $party->getMembers();
		$total = 0;
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$karma = $member->getBase('karma');
			$total += $karma;
			$back .= sprintf(', %s(%s)', $member->getName(), $karma);
		}
		$bot->reply(sprintf('Your party has %s karma: %s.', $total, substr($back, 2)));
		return true;
	}
	
	public static function on_nuyen(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$party = $player->getParty();
		$members = $party->getMembers();
		$total = 0;
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$ny = $member->getBase('nuyen');
			$total += $ny;
			$back .= sprintf(', %s(%s)', $member->getName(), Shadowfunc::displayPrice($ny));
		}
		$bot->reply(sprintf('Your party has %s: %s.', Shadowfunc::displayPrice($total), substr($back, 2)));
		return true;
	}
	
	public static function on_weight(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$party = $player->getParty();
		$members = $party->getMembers();
		$total = 0;
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$we = $member->get('weight');
			$mw = $member->get('max_weight');
			$total += $we;
			$back .= sprintf(', %s(%s/%s)', $member->getName(), Shadowfunc::displayWeight($we), Shadowfunc::displayWeight($mw));
		}
		$bot->reply(sprintf('Your party carries %s: %s.', Shadowfunc::displayWeight($total), substr($back, 2)));
		return true;
		
	}

	public static function onModded()
	{
		
	}
	
	public static function on_hp(SR_Player $player, array $args)
	{
		return self::onHPMP($player, 'hp', 'HP');
	}
	public static function on_mp(SR_Player $player, array $args)
	{
		return self::onHPMP($player, 'mp', 'MP');
	}
	public static function onHPMP(SR_Player $player, $what, $text)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$party = $player->getParty();
		$members = $party->getMembers();
		$back = '';
		foreach ($members as $member)
		{
			$member instanceof SR_Player;
			$hpmp = $member->getBase($what);
			$hpmmpm = $member->get('max_'.$what);
			$back .= sprintf(', %s(%s/%s)', $member->getName(), $hpmp, $hpmmpm);
		}
		$bot->reply(sprintf('Your parties %s: %s.', $text, substr($back, 2)));
		return true;
	}
	
	######################
	### Party Movement ###
	######################
	public static function on_exit(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkLeader($player))) {
			$bot->reply($error);
			return false;
		}
		$party = $player->getParty();
		if (false !== ($error = self::checkMove($party))) {
			$bot->reply($error);
			return false;
		}
		$a = SR_Party::ACTION_OUTSIDE;
		$party->pushAction($a);
		$bot->reply(sprintf('You exit the %s.', $party->getLocation($a)));
		return true;
	}
	
	public static function on_goto(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkLeader($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'goto'));
			return false;
		}
		
		$party = $player->getParty();
		$cityname = $party->getCity();
		$cityclass = $party->getCityClass();
		
		if (false !== ($error = self::checkMove($party))) {
			$bot->reply($error);
			return false;
		}
		
		$tlc = $args[0];
		
		if (is_numeric($tlc))
		{
			$tlc = $player->getKnowledgeByID('places', $tlc);
		}
		if (false === ($target = $cityclass->getLocation($tlc)))
		{
			$bot->reply(sprintf('The location %s does not exist in %s.', $tlc, $cityname));
			return false;
		}
		
		$tlc = $target->getName();
		if (!$player->hasKnowledge('places', $tlc)) {
			$bot->reply(sprintf('You don`t know where the %s is.', $tlc));
			return false;
		}
		
		if ($party->getLocation('inside') === $tlc) {
			$bot->reply(sprintf('You are already in %s.', $tlc));
			return false;
		}
		
		if ($party->getLocation('outside') === $tlc) {
			$target->onEnter($player);
			return true;
		}

		$cityclass = $party->getCityClass();
		$party->pushAction(SR_Party::ACTION_GOTO, $tlc, $cityclass->getGotoETA());
		$party->setContactEta(rand(10,20));
		$party->notice(sprintf('You are going to %s.', $tlc));
		return true;
	}
	
	public static function on_explore(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkLeader($player))) {
			$bot->reply($error);
			return false;
		}
		
		$party = $player->getParty();
		if (false !== ($error = self::checkMove($party))) {
			$bot->reply($error);
			return false;
		}
		$city = $party->getCityClass();
		$cityname = $city->getName();
		$eta = $city->getExploreETA($party);
		$party->pushAction('explore', $cityname, $eta);
		$party->setContactEta(rand(10,20));
		$party->notice(sprintf('You start to explore %s. ETA: %s', $cityname, GWF_Time::humanDurationEN($eta, 2)));
		return true;
	}

	############
	### Give ###
	############
	public static function on_give(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if ( (count($args) < 3) || (count($args) > 4) )
		{
			$player->message(Shadowhelp::getHelp($player, 'give'));
			return false;
		}
		
		if (false === ($target = Shadowfunc::getPlayerInLocationB($player, $args[0]))) {
			$player->message(sprintf('%s is not here.', $args[0]));
			return false;
		}
		
		if ($target->isNPC()) {
			$player->message(sprintf('You can not give stuff to NPC.'));
			return false;
		}

		switch ($args[1])
		{
			case 'i': return self::giveItem($player, $target, $args[2], (isset($args[3])?intval($args[3]):1) );
			case 'ny': return self::giveNyKa($player, $target, 'nuyen', $args[2]);
			case 'ka': return self::giveNyKa($player, $target, 'karma', $args[2]);
			case 'kw': return self::giveKnow($player, $target, 'words', $args[2]);
			case 'kp': return self::giveKnow($player, $target, 'places', $args[2]);
			default: $player->message(Shadowhelp::getHelp($player, 'give')); return false;
		}
	}
	
	private static function giveItem(SR_Player $player, SR_Player $target, $id, $amt=1)
	{
		if (false === ($item = $player->getInvItem($id))) {
			$player->message('You don`t have that item.');
			return false;
		}

		if ($item->isItemStackable())
		{
			if ($amt > $item->getAmount())
			{
				$player->message(sprintf('You only have %d %s.', $item->getAmount(), $item->getName()));
				return false;
			}
			$giveItem = SR_Item::createByName($item->getName(), $amt, true);
			$item->useAmount($player, $amt);
		}
		else
		{
			$player->removeFromInventory($item);
			$giveItem = $item;
		}
		
		$target->giveItems($giveItem);
		
		if ($player->isFighting()) {
			$busy = $player->busy(60);
			$busymsg = sprintf(' %d seconds busy.', $busy);
		} else {
			$busymsg = '';
		}
		
		$player->message(sprintf('You gave %d %s to %s.%s', $amt, $giveItem->getName(), $target->getName(), $busymsg));
		return true;
	}
	
	private static function giveNyKa(SR_Player $player, SR_Player $target, $what, $amt)
	{
		if ($player->isFighting()) {
			$player->message(sprintf('You can not give away %s during combat.', $what));
			return false;
		}
		if ($amt <= 0) {
			$player->message(sprintf('You can only give away a positive amount of %s.', $what));
			return false;
		}
		
		$have = $player->getBase($what);
		if ($amt > $have) {
			$player->message(sprintf('You only have %s %s.', $have, $what));
			return false;
		}
		
		if (false === $target->alterField($what, $amt)) {
			$player->message('Database error in giveNyKa()... :(');
			return false;
		}
		if (false === $player->alterField($what, -$amt)) {
			$player->message('Database error II in giveNyKa()... :(');
			return false;
		}
		
		$target->message(sprintf('Your received %s %s from %s.', $amt, $what, $player->getName()));
		$player->message(sprintf('Your gave %s %s %s.', $target->getName(), $amt, $what));
		return true;
	}
	
	private static function giveKnow(SR_Player $player, SR_Player $target, $what, $which)
	{
		if ($player->isFighting()) {
			$player->message(sprintf('You can not share knowledge during combat.'));
			return false;
		}

		if (is_numeric($which)) {
			if (false === ($which = $player->getKnowledgeByID($what, $which))) {
				$player->message(sprintf('You don`t have this knowledge.'));
				return false;
			}
		}
		elseif (!$player->hasKnowledge($what, $which)) {
			$player->message(sprintf('You don`t have this knowledge.'));
			return false;
		}

		if ($target->hasKnowledge($what, $which)) {
			return true;
		}
		$target->giveKnowledge($what, $which);
		$player->message(sprintf('You told %s about %s.', $target->getName(), $which));
		return true;
	}
	
	##################
	### Item usage ###
	##################
	public static function on_equip(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'equip'));
			return false;
		}

		$itemname = array_shift($args);
		if (false === ($item = $player->getItem($itemname))) {
			$player->message(sprintf('You don`t have that item.'));
			return false;
		}
		
		return $item->onItemEquip($player);
	}
	
	public static function on_unequip(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}

		if (false === ($item = $player->getItem($args[0]))) {
			$player->message(sprintf('You don`t have that item.'));
			return false;
		}
		
		if (false === $item->isEquipped($player)) {
			$player->message(sprintf('You don`t have %s equipped.', $item->getItemName()));
			return false;
		}
		
		if (false === $item->onItemUnequip($player)) {
			return false;
		}
		
		return true;
	}
	
	public static function on_use(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if ( (count($args) < 1) || (count($args) > 2) ) {
			$bot->reply(Shadowhelp::getHelp($player, 'use'));
			return false;
		}
		
		$itemname = array_shift($args);
		if (false === ($item = $player->getItem($itemname))) {
			$player->message(sprintf('You don`t have that item.'));
			return false;
		}
		
		return $item->onItemUse($player, $args);
	}
	
	public static function on_reload(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		return $player->getWeapon()->onReload($player);
	}
	
	public static function on_attack(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		return $player->getWeapon()->onAttack($player, isset($args[0])?$args[0]:'');
	}
	
	public static function on_known_words(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$bot->reply(sprintf('Known Words: %s.', Shadowfunc::getKnownWords($player)));
		return true;
	}
	
	############
	### Talk ###
	############
	public static function on_say(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		$msg = sprintf('says: "%s"', implode(' ', $args));
		$p->message($player, $msg);
		$ep->message($player, $msg);
		$p->setContactEta(60);
		$ep->setContactEta(60);
		$el = $ep->getLeader();
		if ($el->isNPC())
		{
			$el->onNPCTalkA($player, isset($args[0])?$args[0]:'hello');
		}
		return true;
	}
	public static function on_fight(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		$p->popAction();
		$ep->popAction();
		$p->fight($ep, true);
		return true;
	}
	public static function on_bye(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		$p->popAction(true);
		$ep->popAction(true);
		$p->setContactEta(rand(10, 20));
		$ep->setContactEta(rand(10, 20));
		return true;
	}

	###############
	### Options ###
	###############
	private static function onEnable(SR_Player $player, $bit, $bool, $name)
	{
		$text = $bool === true ? 'enabled' : 'disabled';
		
		$old = $player->isOptionEnabled($bit);
		if ($bool === $old) {
			$player->message(sprintf('%s has been already %s.', $name, $text));
			return true;
		}
		if (false === $player->saveOption($bit, $bool)) {
			return false;
		}
		$player->message(sprintf('%s has been %s for your character.', $name, $text));
		return true;
	}
	
	private static function onToggleMessageType(SR_Player $player, $msgtype)
	{
		static $typetext = array(
			SR_Player::NOTICE => 'NOTICE',
			SR_Player::PRIVMSG => 'PRIVMSG',
		);
		$bits = SR_Player::NOTICE|SR_Player::PRIVMSG;
		if (($player->getOptions()&$bits) === $msgtype) {
			Lamb::instance()->reply('Your Shadowlamb message type was already set to '.$typetext[$msgtype].'.');
			return true;
		}
		$player->saveOption($bits, false);
		$player->saveOption($msgtype, true);
		Lamb::instance()->reply('Your Shadowlamb message type has been set to: '.$typetext[$msgtype].'.');
		$player->message('This is a test.');
		return true;
	}
	
	public static function on_enable(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'enable'));
			return false;
		}
		
		switch ($args[0])
		{
			case 'help': return self::onEnable($player, SR_Player::HELP, true, 'Help'); break;
			case 'notice': return self::onToggleMessageType($player, SR_Player::NOTICE); break;
			case 'privmsg': return self::onToggleMessageType($player, SR_Player::PRIVMSG); break;
			default: $bot->reply(Shadowhelp::getHelp($player, 'enable'));
		}
		return false;
	}
	
	public static function on_disable(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'disable'));
			return false;
		}
		switch ($args[0])
		{
			case 'help': return self::onEnable($player, SR_Player::HELP, false, 'Help'); break;
			case 'notice': return self::onToggleMessageType($player, SR_Player::PRIVMSG); break;
			case 'privmsg': return self::onToggleMessageType($player, SR_Player::NOTICE); break;				
			default: $bot->reply(Shadowhelp::getHelp($player, 'disable'));
		}
		return false;
	}
	
	##########
	### GM ###
	##########
	public static function on_gm(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 3) {
			$bot->reply(Shadowhelp::getHelp($player, 'gm'));
			return false;
		}
		
		$server = $player->getUser()->getServer();
		
		if (false === ($user = $server->getUserByNickname($args[0]))) {
			$bot->reply(sprintf('The user %s is unknown.', $args[0]));
			return false;
		}
		
		if (false === ($target = Shadowrun4::getPlayerForUser($user))) {
			$bot->reply(sprintf('The player %s is unknown.', $args[0]));
			return false;
		}

		if (false !== ($error = self::checkCreated($target))) {
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		$var = $args[1];
		if (!$target->hasVar('sr4pl_'.$var)) {
			$bot->reply(sprintf('The var %s does not exist.', $var));
			return false;
		}
		
		$old = $target->getVar('sr4pl_'.$var);
		$new = $args[2];
		
		$target->updateField($var, $new);
		$target->modify();
		$bot->reply(sprintf('Set %s`s %s from %s to %s.', $target->getUser()->getName(), $var, $old, $new));
		return true;
	}
	
	public static function on_gmi(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 2) || (count($args) > 3) ) {
			$bot->reply(Shadowhelp::getHelp($player, 'gmi'));
			return false;
		}
		
		$server = $player->getUser()->getServer();
		
		if (false === ($user = $server->getUserByNickname($args[0]))) {
			$bot->reply(sprintf('The user %s is unknown.', $args[0]));
			return false;
		}
		
		if (false === ($target = Shadowrun4::getPlayerForUser($user))) {
			$bot->reply(sprintf('The player %s is unknown.', $args[0]));
			return false;
		}

		if (false !== ($error = self::checkCreated($target))) {
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		if (false === ($item = SR_Item::createByName($args[1]))) {
			$bot->reply(sprintf('The item %s could not be created.', $args[1]));
			return false;
		} 
		
		if (isset($args[2]))
		{
			$item->saveVar('sr4it_amount', intval($args[2]));
		}
		
		$target->giveItems($item);
		
		return true;
	}
	
	#############
	### Group ###
	#############
	public static function on_join(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'join'));
			return false;
		}

		if (false === ($target = Shadowfunc::getPlayerInLocationB($player, $args[0]))) {
			$bot->reply(sprintf('%s is not here.', $args[0]));
			return false;
		}
		
		if ($target->getID() === $player->getID()) {
			$bot->reply('You cannot join yourself.');
			return false;
		}
		
		$p = $player->getParty();
		$ep = $target->getParty();
		if ($ep->hasBanned($player)) {
			$bot->reply(sprintf('The party does not want you to join.'));
			return false;
		}
		
		$p->kickUser($player, true);
		$ep->addUser($player, true);
		$p->notice(sprintf('%s left the party.', $player->getName()));
		$ep->notice(sprintf('%s joined the party.', $player->getName()));
		return true;
	}

	public static function on_kick(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'kick'));
			return false;
		}
		
		$p = $player->getParty();
		if (false === ($target = Shadowfunc::getFriendlyTarget($player, $args[0]))) {
			$bot->reply('This player is not in your party.');
			return false;
		}
		
		if ($target->getID() === $player->getID()) {
			$bot->reply('You can not kick yourself.');
			return false;
		}
		
		$p->notice(sprintf('%s has been kicked off the party.', $target->getName()));
		
		$p->kickUser($target, true);
		$np = SR_Party::createParty();
		$np->addUser($target, true);
		$np->cloneAction($p);
		return true;
	}
	
	public static function on_part(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (count($args) !== 0) {
			$bot->reply(Shadowhelp::getHelp($player, 'part'));
			return false;
		}
		$p = $player->getParty();
		if ($p->getMemberCount() === 1) {
			$bot->reply('You are not in a party.');
			return false;
		}
		
		$p->notice(sprintf('%s has left the party.', $player->getName()));
		$p->kickUser($player, true);
		$np = SR_Party::createParty();
		$np->addUser($player, true);
		$np->cloneAction($p);
		return true;
	}

	public static function on_ban(SR_Player $player, array $args) { self::onBan($player, $args, true); }
	public static function on_unban(SR_Player $player, array $args) { self::onBan($player, $args, false); }
	private static function onBan(SR_Player $player, array $args, $bool)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (count($args) > 1) {
			$bot->reply(Shadowhelp::getHelp($player, $bool===true?'ban':'unban'));
			return false;
		}
		
		$p = $player->getParty();
		if (count($args) === 0)
		{
			$p->banAll($bool);
			if ($bool === true) {
				$msg = 'Your party does not accept new members anymore.';
			} else {
				$msg = 'Your party does accept new members again.';
			}
			$bot->reply($msg);
			return true;
		}
		
		if (false === ($target = Shadowrun4::getPlayerByName($args[0]))) {
			$bot->reply('This player is unknown or not in memory.');
			return false;
		}
		
		if ($bool === true)
		{
			$p->ban($target);
			$bot->reply(sprintf('%s has been banned from the party.', $target->getName()));
		}
		else
		{
			$p->unban($target);
			$bot->reply(sprintf('%s may now join your party.', $target->getName()));
		}
		return true;
	}
	
	################
	### Distance ###
	################
	public static function on_set_distance(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if ( (count($args) !== 1) || (!is_numeric($args[0])) ) {
			$bot->reply(Shadowhelp::getHelp($player, 'set_distance'));
			return false;
		}
		$d = round(floatval($args[0]), 1);
		if ($d < 0 || $d > SR_Player::MAX_RANGE) {
			$bot->reply(Shadowhelp::getHelp($player, 'set_distance'));
			return false;
		}
		$player->updateField('distance', $d);
		$player->message(sprintf("Your default combat distance has been set to %.01f meters.", $d));
		return true;
	}
	
//	public static function on_forward(SR_Player $player, array $args)
//	{
//		$p = $player->getParty();
//		$p->forward($player);
//	}
//	
//	public static function on_backward(SR_Player $player, array $args)
//	{
//		$p = $player->getParty();
//		$p->backward($player);
//	}
	
	#############
	### Lvlup ###
	#############
	public static function on_lvlup(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'lvlup'));
			return false;
		}
		$f = $args[0];

		# Shortcuts
		if (isset(SR_Player::$SKILL[$f])) { $f = SR_Player::$SKILL[$f]; }
		if (isset(SR_Player::$ATTRIBUTE[$f])) { $f = SR_Player::$ATTRIBUTE[$f]; }
		if (isset(SR_Player::$KNOWLEDGE[$f])) { $f = SR_Player::$KNOWLEDGE[$f]; }
		if ($f === 'essence') { $bot->reply('You can not levelup your essence.'); return false; }
		
		$is_spell = false;
		
		if (in_array($f, SR_Player::$SKILL)) {
			$level = $player->getBase($f);
			$cost = 3;
			$max = 24;
		}
		elseif (in_array($f, SR_Player::$ATTRIBUTE)) {
			$level = $player->getBase($f);
			$cost = 2;
			$max = 12;
		}
		elseif (in_array($f, SR_Player::$KNOWLEDGE)) {
			$level = $player->getBase($f);
			$cost = 2;
			$max = 12;
		}
		elseif (false !== ($spell = SR_Spell::getSpell($f))) {
			$level = $spell->getBaseLevel($player);
			$cost = 2;
			$is_spell = true;
			$max = 12;
		}
		else {
			$bot->reply('You can only levelup attributes, skills, knowledge and spells.');
			return false;
		}
		
		if ($level < 0) {
			$bot->reply(sprintf('You need to learn %s first.', $f));
			return false;
		}
		
		if ($level >= $max) {
			$bot->reply(sprintf('You already have reached the max level of %d for %s.', $max, $f));
			return false;
		}
		
		$need = ($level+1) * $cost;
		$have = $player->getBase('karma');
		if ($need > $have) {
			$bot->reply(sprintf('You need %d karma to increase your base level for %s from %d to %d, but you only have %d karma.', $need, $f, $level, $level+1, $have));
			return false;
		}
		
		$player->alterField('karma', -$need);
		if ($is_spell === true) {
			$player->levelupSpell($f, 1);
		} else {
			$player->alterField($f, 1);
		}
		$player->modify();
		
		$bot->reply(sprintf('You used %d karma and leveled up your %s by 1 to %d.', $need, $f, $level+1));
		return true;
	}
	
	public static function on_drop(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'drop'));
			return false;
		}
	
		if (false === ($item = $player->getInvItem($args[0]))) {
			$bot->reply('You don`t have that item.');
			return false;
		}
		
		if (!$item->isItemDropable()) {
			$bot->reply('You should not drop that item.');
			return false;
		}
		
		if (false === $item->useAmount($player, 1)) {
			$bot->reply('Database error 9.');
			return false;
		}
		
		$bot->reply(sprintf('You got rid of one %s.', $item->getItemName()));
		return true;
	}
	
	public static function on_look(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$p = $player->getParty();
		$pid = $player->getPartyID();
		
		$back = '';
		foreach (Shadowrun4::getParties() as $party)
		{
			$party instanceof SR_Party;
			if ($party->getID() === $pid) {
				continue;
			}
			if (!$party->sharesLocation($p)) {
				continue;
			}
			
			foreach ($party->getMembers() as $member)
			{
				$member instanceof SR_Player;
				if ($member->isHuman())
				{
					$back .= sprintf(', %s', $member->getName());
				}
			}
		}
		
		if ($back === '') {
			$bot->reply('You see no other players.');
		}
		else {
			$player->setOption(SR_Player::RESPONSE_PLAYERS);
			$bot->reply(sprintf('You see these players: %s.', substr($back, 2)));
		}
		
		return true;
	}
	
	public static function on_party_message(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$message = sprintf('%s says: "%s"', $player->getName(), implode(' ', $args));
		$player->getParty()->notice($message);
		return true;
	}
	
	public static function on_spell(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if ( (count($args) === 0) || (count($args) > 2) ) {
			$player->message(sprintf('Known spells: %s.', Shadowfunc::getSpells($player)));
			return false;
		}
		
		$sn = array_shift($args);
		
		if (false === ($spell = SR_Spell::getSpell($sn))) {
			$player->message(sprintf('The spell %s is unknown.', $sn));
			return false;
		}
		if (0 >= ($level = $player->getSpellBaseLevel($sn))) {
			$player->message(sprintf('You need to learn the spell %s first.', $sn));
			return false;
		}
		
		return $spell->onCast($player, $args);
	}
	
	public static function on_leader(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'leader'));
			return false;
		}
		
		$party = $player->getParty();
		if (false === ($target = $party->getMemberByName($args[0]))) {
			$bot->reply(sprintf('%s is not in your party.', $args[0]));
			return false;
		}
		
		if ($target->isLeader()) {
			$bot->reply(sprintf('%s is already the party leader.', $target->getName()));
			return false;
		}
		
		if ($target->isNPC()) {
			$bot->reply(sprintf('You can not give leadership to NPCs.'));
			return false;
		}
		
		if (false === $party->setLeader($target)) {
			$bot->reply('Error.');
			return false;
		}
		$party->notice(sprintf('%s is the new party leader.', $target->getName()));
		return true;
	}
	
	public static function on_request_leader(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		
		if ($player->isLeader()) {
			$bot->reply('You are already leader of your party.');
			return false;
		}

		$party = $player->getParty();
		$leader = $party->getLeader();
		$user = $leader->getUser();
		$last = $user->getVar('lusr_timestamp');
		$wait = ($last+self::RL_TIME) - time();
		if ($wait > 0) {
			$bot->reply(sprintf('Please wait %s and try again.', GWF_Time::humanDurationEN($wait)));
			return true;
		}
		
		if (false === $party->setLeader($player)) {
			$bot->reply('Error.');
			return false;
		}
		$party->notice(sprintf('%s is the new party leader.', $player->getName()));
		return true;
	}
	
	public static function on_flee(SR_Player $player, array $args)
	{
		$party = $player->getParty();
		if ($party->flee($player) === true) {
			$party->notice(sprintf('%s has fled from the enemy.', $player->getName()));
			$party->getEnemyParty()->notice(sprintf('%s has fled from combat.', $player->getName()));
			$party->kickUser($player, true);
			$np = SR_Party::createParty();
			$np->addUser($player, true);
			$np->cloneAction($party);
			$np->clonePreviousAction($party);
			$np->popAction(true);
		}
		return true;
	}
	
	public static function on_gmstats(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		if (false === ($npc = Shadowrun4::getPlayerByPID($args[0]))) {
			$bot->reply(sprintf('This NPC is not there.'));
			return false;
		}
		$bot->reply(sprintf('Status for %s: %s', $npc->getName(), Shadowfunc::getStatus($npc)));
		return true;
	}
	
	public static function on_enter(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkCreated($player))) {
			$bot->reply($error);
			return false;
		}
		$party = $player->getParty();
		if (false === ($location = $party->getLocationClass('outside'))) {
			$bot->reply('You are not outside of a location.');
			return false;
		}
		return self::on_goto($player, array($location->getName()));
	}
}