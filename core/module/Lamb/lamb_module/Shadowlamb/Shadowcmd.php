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
		'ac' => 'accept',
		'br' => 'brew',
		'bk' => 'break',
		'bu' => 'buy',
		'bw' => 'backward',
		'c' => 'commands',
		'ca' => 'cast',
		'cc' => 'ccommands',
		'cl' => 'clan',
		'cm' => 'clan_message',
		'cmp' => 'compare',
		'cy' => 'cyberware',
		'dr' => 'drop',
		'ef' => 'effects',
		'en' => 'enter',
		'eq' => 'equip',
		'ex' => 'examine',
		'exp' => 'explore',
		'fi' => 'fight',
		'fl' => 'flee',
		'fw' => 'forward',
		'g' => 'goto',
		'gi' => 'give',
		'gp' => 'givekp',
		'gw' => 'givekw',
		'gy' => 'giveny',
		'h' => 'hunt',
		'i' => 'inventory',
		'in' => 'info',
		'j' => 'join',
		'ka' => 'karma',
		'ki' => 'kick',
		'kk' => 'known_knowledge',
		'kp' => 'known_places',
		'ks' => 'known_spells',
		'kw' => 'known_words',
		'l' => 'lvlup',
		'le' => 'leader',
		'lo' => 'look',
		'ma' => 'manage',
		'mo' => 'mount',
		'mos' => 'mounts',
		'ny' => 'nuyen',
		'p' => 'party',
		'pa' => 'part',
		'pl' => 'party_loot',
		'pm' => 'party_message',
		'q' => 'equipment',
		'qu' => 'quests',
		'r' => 'reload',
		're' => 'request',
		'rl' => 'request_leader',
		'rm' => 'running_mode',
		's' => 'status',
		'sd' => 'set_distance',
		'se' => 'sell',
		'st' => 'steal',
		'sh' => 'shout',
		'sk' => 'skills',
		'sw' => 'swap',
		't' => 'travel',
		'u' => 'use',
		'uq' => 'unequip',
		'up' => 'upgrade',
		'v' => 'view',
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
	public static $CMDS_GM = array('gm','gmb','gmc','gmd','gmi','gml','gmload','gmm','gmn','gmq','gms','gmsp','gmt','gmns','gmx');
	public static $CMDS_ALWAYS = array('cc','s','a','sk','q','p','pl','i','cy','l','ef','ex','show','cmp','kk','kp','ks','kw','qu','say','sw','swapkp');
	public static $CMDS_ALWAYS_HIDDEN = array('c','reset','redmond','bounty','bounties','cl','asl','aslset','ny','ka','hp','mp','we','rm','level','gp','gw','gy','dropkp','mo','mounts','sh','w','wb','sd','cm','pm','rl');
	public static $CMDS = array(
		'delete' => array(),
		'sleep' => array(),
		'talk' => array('u','r','eq','uq','j','pa','gi','dr','ca','say'),
		'fight' => array('fl','eq','uq','gi','fw','bw','u','r','ca','#'),
		'inside' => array('j','pa','u','r','ca','eq','uq','gi','dr','lo','in'),
		'outside' => array('j','pa','u','r','ca','eq','uq','gi','dr','lo','in'),
		'explore' => array('u','r','ca','eq','uq','pa','gi','dr'),
		'goto' => array('u','r','ca','eq','uq','gi','dr','pa'),
		'hunt' => array('u','r','ca','eq','uq','gi','dr','pa'),
		'travel' => array('u','r','ca','eq','uq','gi','dr'),
// 		'hijack' => array('u','r','ca','eq','uq','gi','dr','pa'),
		'hijack' => array(),
	);
	public static $CMDS_LEADER_ALWAYS = array('le','npc','ban','unban');
	public static $CMDS_LEADER = array(
		'delete' => array(),
		'sleep' => array('stop'),
		'talk' => array('ki','fi','bye'),
		'fight' => array(),
		'inside' => array('kick'),
		'outside' => array('g','exp','h','ki'),
		'explore' => array('g','exp','h','ki','stop'),
		'goto' => array('g','exp','h','ki','stop'),
		'hunt' => array('g','exp','h','ki','stop'), 
		'travel' => array(),
		'hijack' => array(),
	);
	
	# Bold overrides
	private static $BOLD = array();
	private static $NON_BOLD = array('exit');
	
	private static $CURRENT_PLAYER = NULL;
	
	##########################
	### Get valid commands ###
	##########################
	public static function getCurrentCommands(SR_Player $player, $show_hidden=true, $boldify=false, $long_versions=false)
	{
		if (false !== ($error = self::checkCreated($player)))
		{
			return self::$CMDS_ALWAYS_CREATE;
		}
		
		if (false === ($party = $player->getParty()))
		{
			return array();
		}
		$action = $party->getAction();
		$leader = $player->isLeader();
		
		# Allways commands
		$commands = self::$CMDS_ALWAYS;
		
		# Always
		if ($show_hidden === true)
		{
			$commands = array_merge($commands, self::$CMDS_ALWAYS_CREATE);
		}
		
		# GM commands
		if ($player->isGM())
		{
			if ($show_hidden === true)
			{
				$commands = array_merge($commands, self::$CMDS_GM);
			}
		}
		
		# Hidden commands
		if ($show_hidden === true)
		{
			$commands = array_merge($commands, self::$CMDS_ALWAYS_HIDDEN);
		}
		
		# Player actions
		$commands = array_merge($commands, self::$CMDS[$action]);
		if (false !== $scanner = $player->getInvItemByName('Scanner_v6'))
		{
			$commands = array_merge(array('spy'), $commands);
		}
		if ($player->get('alchemy') >= 0)
		{
			$commands = array_merge(array('br'), $commands);
		}
		
		# Leader actions
		if ($leader === true)
		{
			if ($show_hidden === true)
			{
				$commands = array_merge($commands, self::$CMDS_LEADER_ALWAYS);
			}
			
			# Outside location?
			if (false !== ($location = $party->getLocationClass('outside')))
			{
				if ($location->isEnterAllowed($player))
				{
					# We can enter
					$commands[] = 'en';
				}
			}
			
			# Action
			$commands = array_merge($commands, self::$CMDS_LEADER[$action]);
		}
		
		# Location commands
		if (false !== ($location = $party->getLocationClass('inside')))
		{
			# Leader
			if ($leader === true)
			{
				$commands = array_merge($commands, self::shortcutArray($location->getLeaderCommands($player)));
				if ($location->isPVP())
				{
					$commands[] = 'fi';
				}
			}
			# Talk
			$commands = array_merge($commands, $location->getNPCTalkCommands($player));
			# Special
			$commands = array_merge($commands, self::shortcutArray($location->getCommands($player)));
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
		
		if ($long_versions === true)
		{
			$commands = array_map(array(__CLASS__, 'unshortcut'), $commands);
		}
		
		if ($boldify === true)
		{
			$commands = array_map(array(__CLASS__, 'boldify'), $commands);
		}
		
		return $commands;
	}
	
	public static function boldify($cmd)
	{
		if (!in_array($cmd, self::$BOLD, true) === true)
		{
			# Defaults do not bold.
			if (   (in_array($cmd, self::$CMDS_ALWAYS_CREATE, true) === true)
				|| (in_array($cmd, self::$CMDS_GM, true) === true)
				|| (in_array($cmd, self::$CMDS_ALWAYS, true) === true)
				|| (in_array($cmd, self::$CMDS_ALWAYS_HIDDEN) === true)
				|| (in_array($cmd, self::$CMDS_LEADER_ALWAYS, true) === true)
				|| (in_array($cmd, self::$NON_BOLD, true) === true)
			)
			{
				return $cmd; 
			}
			# Default actions do not bold either.
			foreach (self::$CMDS as $action => $cmds)
			{
				if (in_array($cmd, $cmds, true) === true)
				{
					return $cmd;
				}
			}
			foreach (self::$CMDS_LEADER as $action => $cmds)
			{
				if (in_array($cmd, $cmds, true) === true)
				{
					return $cmd;
				}
			}
		}
		
		# Here we have location commands ... and
		# Bold it
		return "\X02{$cmd}\X02";
	}
	
	private static function shortcutArray(array $cmds)
	{
		return array_map(array(__CLASS__, 'shortcut'), $cmds);
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
	public static function checkLeader(SR_Player $player)
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
	public static function checkMove(SR_Party $party)
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
		self::$CURRENT_PLAYER = $player;
		
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
		
		if ($player->isOptionEnabled(SR_Player::DEAD))
		{
			$player->message('You played #running_mode and got killed by an NPC or other #rm player. You are dead. Use #reset to start over.');
			return false;
		}
		
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
				$bot->reply('The command is not available for your current action or location. Try '.$c.'c [<l|long>] to see all currently available commands.');
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
