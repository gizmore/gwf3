<?php
/**
 * Basic command class that can execute stuff and manage commands.
 * @author gizmore
 * @version 3.0
 * @since 1.0
 */
class Shadowcmd
{
	#################
	### Shortcuts ###
	#################
	public static $CMD_SHORTCUTS = array(
		'#' => 'attack',
		'a' => 'attributes',
		'bw' => 'backward',
		'c' => 'commands',
		'ca' => 'spell',
		'cast' => 'spell',
		'cc' => 'ccommands',
		'cmp' => 'compare',
		'cy' => 'cyberware',
		'ef' => 'effects',
		'en' => 'enter',
		'eq' => 'equip',
		'ex' => 'examine',
		'exp' => 'explore',
		'fl' => 'flee',
		'fw' => 'forward',
		'g' => 'goto',
		'gi' => 'give',
		'gp' => 'givekp',
		'gw' => 'givekw',
		'gy' => 'giveny',
		'i' => 'inventory',
		'j' => 'join',
		'ka' => 'karma',
		'kk' => 'known_knowledge',
		'kp' => 'known_places',
		'ks' => 'known_spells',
		'kw' => 'known_words',
		'l' => 'lvlup',
		'le' => 'leader',
		'mo' => 'mount',
		'ny' => 'nuyen',
		'p' => 'party',
		'pl' => 'party_loot',
		'pm' => 'party_message',
		'q' => 'equipment',
		'qu' => 'quests',
		'r' => 'reload',
		'rl' => 'request_leader',
		'rm' => 'running_mode',
		's' => 'status',
		'sd' => 'set_distance',
		'sh' => 'shout',
		'sk' => 'skills',
		'sp' => 'spell',
		'spells' => 'known_spells',
		'sw' => 'swap',
		'u' => 'use',
		'uq' => 'unequip',
		'w' => 'whisper',
		'wb' => 'whisper_back',
		'we' => 'weight',
		'x' => 'flee',
	);
	private static function unshortcut($cmd) { return Shadowfunc::unshortcut($cmd, self::$CMD_SHORTCUTS); }
	private static function shortcut($cmd) { return Shadowfunc::shortcut($cmd, self::$CMD_SHORTCUTS); }
	
	################
	### Triggers ###
	################
	public static $CMDS_ALWAYS_CREATE = array('helo','ehlo','time','start','help','enable','disable','stats','players','parties','world','motd');
	public static $CMDS_GM = array('gm','gmb','gmc','gmd','gmi','gml','gmload','gmm','gms','gmsp','gmt','gmns','gmx');
	public static $CMDS_ALWAYS = array('cc','s','a','sk','q','p','pl','i','cy','l','ef','ex','cmp','kk','kp','ks','kw','qu','r','say','sw');
	public static $CMDS_ALWAYS_HIDDEN = array('c','reset','redmond','bounty','bounties','asl','aslset','ny','ka','hp','mp','we','rm','level','gp','gw','gy','dropkp','mo','mounts','sh','w','wb','sd','pm','rl');
	public static $CMDS = array(
		'delete' => array(),
		'sleep' => array(),
		'talk' => array('u','r','eq','uq','j','part','gi','drop','ca','say'),
		'fight' => array('fl','eq','uq','gi','fw','bw','u','ca','#'),
		'inside' => array('j','part','u','ca','eq','uq','gi','drop','look','info'),
		'outside' => array('j','part','u','ca','eq','uq','gi','drop','look','info'),
		'explore' => array('u','ca','eq','uq','part','gi','drop'),
		'goto' => array('u','ca','eq','uq','gi','drop','part'),
		'hunt' => array('u','ca','eq','uq','gi','drop','part'),
		'travel' => array('u','ca','eq','uq','gi','drop'),
		'hijack' => array('u','ca','eq','uq','gi','drop','part'),
	);
	public static $CMDS_LEADER_ALWAYS = array('le','npc','ban','unban');
	public static $CMDS_LEADER = array(
		'delete' => array(),
		'sleep' => array('stop'),
		'talk' => array('kick','fight','bye'),
		'fight' => array(),
		'inside' => array('g','exp','hunt','kick'),
		'outside' => array('g','exp','hunt','kick','en'),
		'explore' => array('g','exp','hunt','kick','stop'),
		'goto' => array('g','exp','hunt','kick','stop'),
		'hunt' => array('g','exp','hunt','kick','stop'), 
		'travel' => array(),
		'hijack' => array('g','exp','hunt','en','stop'),
	);
	
	##########################
	### Get valid commands ###
	##########################
	public static function getCurrentCommands(SR_Player $player, $show_hidden=true)
	{
		if (false !== ($error = self::checkCreated($player)))
		{
			return self::$CMDS_ALWAYS_CREATE;
		}
		
		$party = $player->getParty();
		$action = $party->getAction();
		$leader = $player->isLeader();
		
		# Allways commands
		$commands = self::$CMDS_ALWAYS;
		
		if (false !== $scanner = $player->getInvItemByName('Scanner_v6'))
		{
			$commands = array_merge(array('spy'), $commands);
		}
		
		if ($show_hidden) {
			$commands = array_merge($commands, self::$CMDS_ALWAYS_CREATE);
		}
		
		# GM commands
		if ($player->isGM()) {
			if ($show_hidden) {
				$commands = array_merge($commands, self::$CMDS_GM);
			}
		}
		
		# Hidden commands
		if ($show_hidden) {
			$commands = array_merge($commands, self::$CMDS_ALWAYS_HIDDEN);
		}
		
		# Action commands
		$commands = array_merge($commands, self::$CMDS[$action]);
		if ($leader)
		{
			if ($show_hidden === true)
			{
				$commands = array_merge($commands, self::$CMDS_LEADER_ALWAYS);
			}
			
			# Have location?
			if (false !== ($location = $party->getLocationClass('inside')))
			{
				# Not an exit?
				if (!($location instanceof SR_Exit))
				{
					# We can exit
					$commands[] = 'exit';
				}
			}
			
			$commands = array_merge($commands, self::$CMDS_LEADER[$action]);
		}
		
		# Location commands
		if (false !== ($location = $party->getLocationClass('inside')))
		{
			$commands = array_merge($commands, $location->getNPCTalkCommands($player));
			$commands = array_merge($commands, $location->getCommands($player));
			
			if ($location->isPVP())
			{
				$commands[] = 'fight';
			}
			
			if ($leader === true)
			{
				$commands = array_merge($commands, $location->getLeaderCommands($player));
			}
		}
		
		if (false !== ($location = $party->getLocationClass('outside')))
		{
			if ($location->isHijackable())
			{
				$commands[] = 'hijack';
			}
//			if ($location->isPVP())
//			{
				$commands[] = 'fight';
//			}
		}
		
		return $commands;
	}
	
	################
	### Checkers ###
	################
	/**
	 * Check if the player is created. Return false on success and string on error.
	 * @deprecated
	 * @param SR_Player $player
	 * @return false|string
	 */
	protected static function checkCreated(SR_Player $player)
	{
		if ($player->isCreated())
		{
			return false;
		}
		$c = Shadowrun4::SR_SHORTCUT;
		return 'You did not start the game yet. Type '.$c.'start <race> <gender> to start your journey in Shadowlamb.';
	}
	
	/**
	 * Check if the player is leader of a party. Return false on success and string on error.
	 * @param SR_Player $player
	 * @return false|string
	 */
	protected static function checkLeader(SR_Player $player)
	{
		if (false !== ($error = self::checkCreated($player)))
		{
			return $error;
		}
		if ($player->isLeader())
		{
			return false;
		}
		return 'This command is only available to the party leader.';
	}
	
	/**
	 * Check if the party can move. Return false on success and string on error.
	 * @param SR_Player $player
	 * @return false|string
	 */
	protected static function checkMove(SR_Party $party)
	{
		$b = chr(2);
		$back = '';
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if ($member->isDead())
			{
				$back .= sprintf(', %s is dead', $member->getName());
			}
			elseif ($member->isOverloadedFull())
			{
				$back .= sprintf(', %s is overloaded', $member->getName());
			}
			elseif ($member->getBase('age') <= 0)
			{
				$back .= sprintf(", %s has no {$b}#asl{$b}", $member->getName());
			}
		}
		return $back === '' ? false : 'You cannot move because '.substr($back, 2).'.';
	}
	
	###############
	### Trigger ###
	###############
	public static function onTrigger(SR_Player $player, $message)
	{
		if ($player->isFighting())
		{
			$cmd = Common::substrUntil($message, ' ', $message);
			$cmd = self::shortcut(self::unshortcut($cmd));
			if (in_array($cmd, self::$CMDS['fight'], true))
			{
				$player->combatPush($message);
				return true;
			}
		}
		return self::onExecute($player, $message);
	}
	
	############
	### Exec ###
	############
	public static function onExecute(SR_Player $player, $message)
	{
		$bot = Shadowrap::instance($player);
		$c = Shadowrun4::SR_SHORTCUT;

		$args = explode(' ', $message);
		
		$cmd = array_shift($args);
		$cmd = self::shortcut(self::unshortcut($cmd));
		$command = self::unshortcut($cmd);
		$commands = self::getCurrentCommands($player);

//		var_dump($cmd);
		if (!in_array($cmd, $commands, true))
		{
			if (!$player->isCreated()) {
				$bot->reply('You did not #start the game yet.');
			}
			else {
				$bot->reply('The command is not available for your current action or location. Try '.$c.'c to see all currently available commands.');
			}
			return false;
		}
		
		$p = $player->getParty();
		$p->setTimestamp(time());
		
		$classname = 'Shadowcmd_'.$command;
		if (class_exists($classname))
		{
			return call_user_func(array($classname, 'execute'), $player, $args);
		}

		$function = 'on_'.$command;
		$location = $p->getLocationClass('inside');
		if ( ($location !== false) && (method_exists($location, $function)))
		{
			return call_user_func(array($location, $function), $player, $args);
		}
		
		if ( ($location !== false) && ($location->hasTalkCommand($player, $command)) )
		{
			return call_user_func(array($location, $command), $player, $args);
		}
		
		$bot->reply("Error: The function $function does not exist.");
		return false;
	}
	
	#############
	### Reply ###
	#############
	public static function reply(SR_Player $player, $message)
	{
		if ($player->isFighting())
		{
			return $player->message($message);
		}
		else
		{
			return Shadowrap::instance($player)->reply($message);
		}
	}
}
?>
