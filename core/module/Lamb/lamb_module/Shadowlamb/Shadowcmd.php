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
	private static function unshortcut($cmd)
	{
		return Shadowfunc::unshortcut(strtolower($cmd), self::$LANG_CMDS->getTrans(self::$CURRENT_PLAYER->getLangISO()));
	}
	
	private static function shortcut($cmd)
	{
		return Shadowfunc::shortcut(strtolower($cmd), self::$LANG_CMDS->getTrans(self::$CURRENT_PLAYER->getLangISO()));
	}
	
	public static function translate($cmd)
	{
		return Shadowfunc::unshortcut(strtolower($cmd), self::$LANG_COMMANDS->getTrans(self::$CURRENT_PLAYER->getLangISO()));
	}
	
	public static function untranslate($cmd)
	{
		return Shadowfunc::shortcut(strtolower($cmd), self::$LANG_COMMANDS->getTrans(self::$CURRENT_PLAYER->getLangISO()));
	}
	
	################
	### Triggers ###
	################
	public static $REALLY_HIDDEN = array('helo','ehlo','exx','redmond','aslset','dropkp','mounts','uid');
	public static $CMDS_ALWAYS_CREATE = array('helo','ehlo','time','start','help','enable','disable','stats','players','parties','world','motd');
	public static $CMDS_GM = array('gm','gmb','gmc','gmd','gmi','gml','gmlangfiles','gmload','gmm','gmn','gmq','gms','gmsp','gmt','gmul','gmns','gmx');
	public static $CMDS_ALWAYS = array('ccommands','status','attributes','skills','equipment','party','party_loot','inventory','cyberware','lvlup','effects','examine','exx','show','compare','known_knowledge','known_places','known_spells','known_words','quests','say','swap','swapkp');
	public static $CMDS_ALWAYS_HIDDEN = array('uid','commands','reset','redmond','bounty','bounties','clan','sets','asl','aslset','nuyen','xp','karma','hp','mp','weight','set_distance','running_mode','level','givekp','givekw','giveny','dropkp','mount','mounts','shout','whisper','whisper_back','clan_message','party_message','request_leader');
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
	public static $CMDS_LEADER_ALWAYS = array('leader','party_order','npc','ban','unban');
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
	public static function getCurrentCommands(SR_Player $player, $show_hidden=true, $boldify=false, $long_versions=true, $translate=false, $filter_hidden=false, $hidden_only=false)
	{
		if ($player->isOptionEnabled(SR_Player::DEAD))
		{
			return array_merge(self::$CMDS_ALWAYS_CREATE, array('reset'));
		}
		
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
		
		$commands = array();
		
		# Allways commands
		if (!$hidden_only)
		{
			$commands = array_merge($commands, self::$CMDS_ALWAYS);
		}
		
		# Always
		if ($show_hidden)
		{
			$commands = array_merge($commands, self::$CMDS_ALWAYS_CREATE);
		}
		
		# GM commands
		if ($show_hidden && $player->isGM())
		{
			$commands = array_merge($commands, self::$CMDS_GM);
		}
		
		# Hidden commands
		if ($show_hidden)
		{
			$commands = array_merge($commands, self::$CMDS_ALWAYS_HIDDEN);
		}
		
		# Player actions
		if (!$hidden_only)
		{
			$commands = array_merge($commands, self::$CMDS[$action]);
			if (false !== ($scanner = $player->getInvItemByName('Scanner_v6', false)))
			{
				$commands[] = 'spy';
			}
			if ($player->getBase('alchemy') >= 0)
			{
				$commands[] = 'brew';
			}
		}
		
		# Leader actions
		if ($leader)
		{
			if ($show_hidden)
			{
				$commands = array_merge($commands, self::$CMDS_LEADER_ALWAYS);
			}
			
			if (!$hidden_only)
			{
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
		}
		
		# Location commands
		if (!$hidden_only)
		{
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
			elseif (false !== ($location = $party->getLocationClass('outside')))
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
		}

// 		if ($long_versions === false)
// 		{
// 			$commands = array_map(array(__CLASS__, 'shortcut'), $commands);
// 		}
// 		if ($long_versions === true)
// 		{
// 			$commands = array_map(array(__CLASS__, 'unshortcut'), $commands);
// 		}

		##############
		### FORMAT ###
		##############
		if ($filter_hidden)
		{
			$commands = array_values(array_diff($commands, self::$REALLY_HIDDEN));
		}
		
		if ($boldify)
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
		
		# Shortcut
		if (!$long_versions)
		{
			$commands = array_map(array(__CLASS__, 'shortcut_bolded'), $commands);
		}
		
		# Translate
		if ($translate)
		{
			$commands = array_map(array(__CLASS__, 'translate_bolded'), $commands);
		}

		# \o/
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
		return self::onLoadLanguage();
	}
	
	public static function onLoadLanguage()
	{
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
		$args = explode(' ', $message);

		$command = self::unshortcut(array_shift($args));
		$command = self::untranslate($command);
		
		$commands = self::getCurrentCommands($player);

		if (false === in_array($command, $commands, true))
		{
			if (!$player->isCreated())
			{
				self::rply($player, '0000');
// 				Shadowrun4::removePlayer($player);
			}
			elseif ($player->isOptionEnabled(SR_Player::DEAD))
			{
				self::rply($player, '5256'); # You played #running_mode and got killed by an NPC or other #rm player. You are dead. Use #reset to start over.
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
	public static function rply(SR_Player $player, $key, $args=NULL)
	{
		return self::reply($player, $player->lang($key, $args));
	}
	
	public static function reply(SR_Player $player, $message)
	{
		return (self::isCombatCommand() && $player->isFighting()) ?
			$player->message($message) :
			Shadowrap::instance($player)->reply($message);
	}
}
?>
