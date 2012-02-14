<?php
/**
 * Basic command class that can execute stuff and manage commands.
 * @author gizmore
 * @version 3.1
 * @since 1.0
 */
class Shadowcmd
{
	public static function isCombatCommand() { return false; }
	
	#################
	### Shortcuts ###
	#################
/*	public static $CMD_SHORTCUTS = array(
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
		'po' => 'party_order',
		'pm' => 'party_message',
		'q' => 'equipment',
		'qu' => 'quests',
		'r' => 'reload',
		're' => 'request',
		'rl' => 'request_leader',
		'rm' => 'running_mode',
		's' => 'status',
		'sd' => 'set_distance',
// 		'se' => 'sell',
		'st' => 'steal',
		'sh' => 'shout',
		'sk' => 'skills',
		'sw' => 'swap',
		't' => 'travel',
		'u' => 'use',
		'uq' => 'unequip',
// 		'up' => 'upgrade',
		'v' => 'view',
		'w' => 'whisper',
		'wb' => 'whisper_back',
		'we' => 'weight',
		'x' => 'flee',
	);*/
	
	private static function unshortcut($cmd)
	{
		return Shadowfunc::unshortcut($cmd, self::$LANG_CMDS->getTrans(self::$CURRENT_PLAYER->getLangISO()));
// 		return Shadowfunc::unshortcut($cmd, self::$CMD_SHORTCUTS);
	}
	
	private static function shortcut($cmd)
	{
		return Shadowfunc::shortcut($cmd, self::$LANG_CMDS->getTrans(self::$CURRENT_PLAYER->getLangISO()));
// 		return Shadowfunc::shortcut($cmd, self::$CMD_SHORTCUTS);
	}
	
	public static function translate($cmd)
	{
		return Shadowfunc::unshortcut($cmd, self::$LANG_COMMANDS->getTrans(self::$CURRENT_PLAYER->getLangISO()));
	}
	
	public static function untranslate($cmd)
	{
		return Shadowfunc::shortcut($cmd, self::$LANG_COMMANDS->getTrans(self::$CURRENT_PLAYER->getLangISO()));
	}
	
	################
	### Triggers ###
	################
	public static $CMDS_ALWAYS_CREATE = array('helo','ehlo','time','start','help','enable','disable','stats','players','parties','world','motd');
	public static $CMDS_GM = array('gm','gmb','gmc','gmd','gmi','gml','gmload','gmm','gmn','gmq','gms','gmsp','gmt','gmul','gmns','gmx');
	public static $CMDS_ALWAYS = array('ccommands','status','attributes','skills','equipment','party','party_loot','inventory','cyberware','lvlup','effects','examine','show','compare','known_knowledge','known_places','known_spells','known_words','quests','say','swap','swapkp');
	public static $CMDS_ALWAYS_HIDDEN = array('commands','reset','redmond','bounty','bounties','clan','asl','aslset','nuyen','karma','hp','mp','weight','running_mode','level','givekp','givekw','giveny','dropkp','mount','mounts','shout','whisper','whisper_back','set_distance','clan_message','party_message','request_leader');
// 	public static $CMDS_ALWAYS = array('cc','s','a','sk','q','p','pl','i','cy','l','ef','ex','show','cmp','kk','kp','ks','kw','qu','say','sw','swapkp');
// 	public static $CMDS_ALWAYS_HIDDEN = array('c','reset','redmond','bounty','bounties','cl','asl','aslset','ny','ka','hp','mp','we','rm','level','gp','gw','gy','dropkp','mo','mos','sh','w','wb','sd','cm','pm','rl');
	public static $CMDS = array(
		'delete' => array(),
		'sleep' => array(),
		'talk' => array('use','reload','equip','unequip','join','part','give','drop','cast','say'),
		'fight' => array('flee','equip','unequip','give','idle','forward','backward','use','reload','cast','attack'),
		'inside' => array('join','part','use','reload','cast','equip','unequip','give','drop','look','info'),
		'outside' => array('join','part','use','reload','cast','equip','unequip','give','drop','look','info'),
		'explore' => array('use','reload','cast','equip','unequip','part','give','drop'),
		'goto' => array('use','reload','cast','equip','unequip','give','drop','part'),
		'hunt' => array('use','reload','cast','equip','unequip','give','drop','part'),
		'travel' => array('use','reload','cast','equip','unequip','give','drop'),
		'hijack' => array(),
	);
// 	public static $CMDS = array(
// 		'delete' => array(),
// 		'sleep' => array(),
// 		'talk' => array('u','r','eq','uq','j','pa','gi','dr','ca','say'),
// 		'fight' => array('fl','eq','uq','gi','idle','fw','bw','u','r','ca','#'),
// 		'inside' => array('j','pa','u','r','ca','eq','uq','gi','dr','lo','in'),
// 		'outside' => array('j','pa','u','r','ca','eq','uq','gi','dr','lo','in'),
// 		'explore' => array('u','r','ca','eq','uq','pa','gi','dr'),
// 		'goto' => array('u','r','ca','eq','uq','gi','dr','pa'),
// 		'hunt' => array('u','r','ca','eq','uq','gi','dr','pa'),
// 		'travel' => array('u','r','ca','eq','uq','gi','dr'),
// // 		'hijack' => array('u','r','ca','eq','uq','gi','dr','pa'),
// 		'hijack' => array(),
// 	);
// 	public static $CMDS_LEADER_ALWAYS = array('le','po','npc','ban','unban');
	public static $CMDS_LEADER_ALWAYS = array('leader','party_order','npc','ban','unban');
// 	public static $CMDS_LEADER = array(
// 		'delete' => array(),
// 		'sleep' => array('stop'),
// 		'talk' => array('ki','fi','bye'),
// 		'fight' => array(),
// 		'inside' => array('ki'),
// 		'outside' => array('g','exp','h','ki'),
// 		'explore' => array('g','exp','h','ki','stop'),
// 		'goto' => array('g','exp','h','ki','stop'),
// 		'hunt' => array('g','exp','h','ki','stop'), 
// 		'travel' => array(),
// 		'hijack' => array(),
// 	);
	public static $CMDS_LEADER = array(
		'delete' => array(),
		'sleep' => array('stop'),
		'talk' => array('kick','fight','bye'),
		'fight' => array(),
		'inside' => array('kick'),
		'outside' => array('goto','explore','hunt','kick'),
		'explore' => array('goto','explore','hunt','kick','stop'),
		'goto' => array('goto','explore','hunt','kick','stop'),
		'hunt' => array('goto','explore','hunt','kick','stop'),
		'travel' => array(),
		'hijack' => array(),
	);
	
	
	# Bold overrides
	private static $BOLD = array();
	private static $NON_BOLD = array('exit','brew');
	
	public static $CURRENT_PLAYER = NULL;
	
	# Command lang files
	private static $LANG_CMDS = NULL;
	private static $LANG_COMMANDS = NULL;
	
	public static function getCommandShortcutMap()
	{
		return self::$LANG_CMDS->getTrans(self::$CURRENT_PLAYER->getLangISO());
	}
	
	##########################
	### Get valid commands ###
	##########################
	public static function getCurrentCommands(SR_Player $player, $show_hidden=true, $boldify=false, $long_versions=true, $translate=false)
	{
		if (false === $player->isCreated())
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
		if (false !== ($scanner = $player->getInvItemByName('Scanner_v6')))
		{
			$commands = array_merge(array('spy'), $commands);
		}
		if ($player->getBase('alchemy') >= 0)
		{
			$commands = array_merge(array('brew'), $commands);
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
					$commands[] = 'enter';
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
// 				$commands = array_merge($commands, self::shortcutArray($location->getLeaderCommands($player)));
				$commands = array_merge($commands, $location->getLeaderCommands($player));
				if ($location->isPVP())
				{
					$commands[] = 'fight';
				}
			}
			# Talk
			$commands = array_merge($commands, $location->getNPCTalkCommands($player));
			# Special
// 			$commands = array_merge($commands, self::shortcutArray($location->getCommands($player)));
			$commands = array_merge($commands, $location->getCommands($player));
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
		
// 		if ($long_versions === false)
// 		{
// 			$commands = array_map(array(__CLASS__, 'shortcut'), $commands);
// 		}
// 		if ($long_versions === true)
// 		{
// 			$commands = array_map(array(__CLASS__, 'unshortcut'), $commands);
// 		}
		
		if ($boldify === true)
		{
// 			if ($long_versions === true)
// 			{
// 				$commands = array_map(array(__CLASS__, 'boldify_longs'), $commands);
// 			}
// 			else
// 			{
				$commands = array_map(array(__CLASS__, 'boldify'), $commands);				
// 			}
		}
		
		if ($long_versions === false)
		{
			$commands = array_map(array(__CLASS__, 'shortcut_bolded'), $commands);
		}
		
		if ($translate === true)
		{
			$commands = array_map(array(__CLASS__, 'translate_bolded'), $commands);
		}

		
		return $commands;
	}
	
	public static function translate_bolded($cmd)
	{
		$bold = $cmd[0] === "\X02" ? "\X02" : '';
		$cmd = trim($cmd, "\X02");
		$cmd = self::translate($cmd);
		return $bold.$cmd.$bold;
	}
	
	public static function shortcut_bolded($cmd)
	{
		$bold = $cmd[0] === "\X02" ? "\X02" : '';
		$cmd = trim($cmd, "\X02");
		$cmd = self::shortcut($cmd);
		return $bold.$cmd.$bold;
	}
	
// 	public static function boldify_longs($cmd)
// 	{
// 		$short = self::untranslate($cmd);
// // 		$short = self::shortcut($cmd);
// 		if ($short === self::boldify($short))
// 		{
// 			return $cmd;
// 		}
// 		return "\X02{$cmd}\X02";
// 	}
	
	public static function boldify($cmd)
	{
// 		$cmd_trans = $cmd;
// 		$cmd = self::untranslate($cmd);
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
	
// 	private static function shortcutArray(array $cmds)
// 	{
// 		return array_map(array(__CLASS__, 'shortcut'), $cmds);
// 	}
	
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
			return true;
		}
		$player->msg('0000');
		return false;
// 		$c = Shadowrun4::SR_SHORTCUT;
// 		return 'You did not start the game yet. Type '.$c.'start <race> <gender> to start your journey in Shadowlamb.';
	}
	
	/**
	 * Check if the player is leader of a party. Return false on success and string on error.
	 * @param SR_Player $player
	 * @return false|string
	 */
	public static function checkLeader(SR_Player $player)
	{
// 		if (false === self::checkCreated($player))
// 		{
// 			return false;
// 		}
		if ($player->isLeader())
		{
			return true;
		}
		$player->msg('1032'); # 'This command is only available to the party leader.';
		return false;
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
				$party->ntice('1080', array($member->getName()));
				return false;
// 				$back .= sprintf(', %s is dead', $member->getName());
			}
			elseif ($member->isOverloadedFull())
			{
				$party->ntice('1081', array($member->getName()));
				return false;
// 				$back .= sprintf(', %s is overloaded', $member->getName());
			}
// 			elseif ($member->getBase('age') <= 0)
// 			{
// 				$party->ntice('1082', array($member->getName()));
// 				return false;
// // 				$back .= sprintf(", %s has no {$b}#asl{$b}", $member->getName());
// 			}
		}
		return true;
// 		if ($back === '')
// 		{
// 			return true;
// 		}
		
// 		$party->ntice('', array(substr($back, 2)));
// 		return false;
// 		return $back === '' ? false : 'You cannot move because '.substr($back, 2).'.';
	}
	
	############
	### Init ###
	############
	public static function init()
	{
// 		Lamb_Log::logDebug(__METHOD__);
		$dir = Shadowrun4::getShadowDir();
		self::$LANG_CMDS = new GWF_LangTrans($dir.'lang/cmds/cmds');
		self::$LANG_COMMANDS = new GWF_LangTrans($dir.'lang/commands/commands');
		return true;
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
			$cmd = self::unshortcut($cmd);
			$cmd = self::untranslate($cmd);
			if (true === in_array($cmd, self::$CMDS['fight'], true))
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
/*  DELETE THIS UNUSED CODE for langfile generation.
	private static $ALLCMDS = array();
	private static function writeAllCommandsLangFile(SR_Player $player, $message)
	{
		$path = sprintf('%scmd', Shadowrun4::getShadowDir());
		GWF_File::filewalker($path, array(__CLASS__, 'writeAllCommandsB'), true, true);
		
		foreach (Shadowrun4::getCities() as $city)
		{
			$city instanceof SR_City;
			foreach ($city->getLocations() as $loc)
			{
				$loc instanceof SR_Location;
				foreach ($loc->getCommands($player) as $cmd)
				{
					if (false === in_array($cmd, self::$ALLCMDS))
					{
						self::$ALLCMDS[] = $cmd;
					}
				}
				foreach ($loc->getNPCTalkCommands($player) as $cmd)
				{
					if (false === in_array($cmd, self::$ALLCMDS))
					{
						self::$ALLCMDS[] = $cmd;
					}
				}
			}
		}
		
		sort(self::$ALLCMDS);

		# Short
		$data = '<?php'.PHP_EOL;
		$data .= '$lang = array('.PHP_EOL;
		
		$longs = self::$ALLCMDS;
		
		foreach ($longs as $long)
		{
			if (false !== ($short = array_search($long, self::$CMD_SHORTCUTS)))
			{
				$data .= sprintf("\t'%s' => '%s',\n", $short, $long);
				unset($longs[$short]);
			}
		}
		
		$data .= ');'.PHP_EOL;
		$data .= '?>'.PHP_EOL;
		
		$filename = Shadowrun4::getShadowDir().'lang/cmds/cmds_en.php';
		file_put_contents($filename, $data);
		
		
		# Long
		$data = '<?php'.PHP_EOL;
		$data .= '$lang = array('.PHP_EOL;
		
		foreach (self::$ALLCMDS as $long)
		{
			$data .= sprintf("\t'%s' => '%s',\n", $long, $long);
		}
		
		$data .= ');'.PHP_EOL;
		$data .= '?>'.PHP_EOL;
		
		$filename = Shadowrun4::getShadowDir().'lang/commands/commands_en.php';
		file_put_contents($filename, $data);
	}
	public static function writeAllCommandsB($entry, $fullpath, $args=NULL)
	{
		$cmd = substr($entry, 0, -4);
		if (false === in_array($cmd, self::$ALLCMDS))
		{
			self::$ALLCMDS[] = $cmd;
		}
	}
// */

	public static function onExecute(SR_Player $player, $message)
	{
		# Check for dead people.
		if ($player->isOptionEnabled(SR_Player::DEAD))
		{
			$player->msg('5256');
// 			$player->message('You played #running_mode and got killed by an NPC or other #rm player. You are dead. Use #reset to start over.');
			return false;
		}
		
		$args = explode(' ', $message);
		
		echo sprintf("Your command is %s\n", $args[0]);
		
// 		$cmd = array_shift($args);
		$command = self::unshortcut(array_shift($args));
		$command = self::untranslate($command);
		
		echo "Command got untranslated to $command\n";
		
// 		$cmd = self::shortcut(self::unshortcut($cmd));
// 		$command = self::unshortcut($cmd);
		$commands = self::getCurrentCommands($player);

		if (false === in_array($command, $commands, true))
		{
			if (!$player->isCreated())
			{
				self::rply($player, '0000');
// 				Shadowrun4::removePlayer($player);
			}
			else
			{
				self::rply($player, '1174');
// 				$bot->reply('The command is not available for your current action or location. Try '.$c.'c [<l|long>] to see all currently available commands.');
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
		
		self::reply($player, "Error: The function $function does not exist.");
		return false;
	}
	
	#############
	### Reply ###
	#############
	public static function reply(SR_Player $player, $message)
	{
		return (self::isCombatCommand() && $player->isFighting()) ?
			$player->message($message) :
			Shadowrap::instance($player)->reply($message);
	}

	public static function rply(SR_Player $player, $key, $args=NULL)
	{
		return (self::isCombatCommand() && $player->isFighting()) ?
			$player->msg($key, $args) :
			Shadowrap::instance($player)->reply(Shadowrun4::lang($key, $args));
	}
}
?>
