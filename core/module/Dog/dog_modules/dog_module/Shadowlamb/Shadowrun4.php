<?php
require_once 'Shadowcmd.php';
require_once 'Shadowfunc.php';
require_once 'Shadowhelp.php';
require_once 'Shadowlang.php';
require_once 'Shadowrap.php';
require_once 'Shadowshout.php';
require_once 'Shadowcleanup.php';
require_once 'secret.php';

// define('SL4_REALS', true);

final class Shadowrun4
{
	const SR_SHORTCUT = '#';
	const KICK_IDLE_TIMEOUT = 1800; # 30min
	const TICKLEN = 1.0; # 1.0 real second == 1 gametick
	const SECONDS_PER_TICK = 1; # N game second per gametick (you may want to raise during developement, only full int)
	public static $CITIES = array('Redmond', 'Seattle', 'Delaware', 'Chicago', 'Vegas', 'WestVegas');
	
	################
	### Language ###
	################
	public static function lang($key, $args=NULL)
	{
		return self::langPlayer(self::getCurrentPlayer(), $key, $args);
// 		return DOGMOD_Shadowlamb::instance()->lang($key, $args).(Shadowrun4::getCurrentPlayer()->getLangISO()==='bot'?'X':'');
	}
	public static function langPlayer(SR_Player $player, $key, $args=NULL)
	{
		$iso = $player->getLangISO();
		$x = is_numeric($key) && ($iso === 'bot') ? 'X' : '';
		return DOGMOD_Shadowlamb::instance()->langISO($iso, $key, $args).$x;
	}
	public static function hasLang($key)
	{
		return array_key_exists($key, DOGMOD_Shadowlamb::instance()->getLang()->getTrans('en'));
	}
	
	####################
	### Game Masters ###
	####################
	private static $GMS = NULL;
	public static function isGM(SR_Player $player)
	{
		if (NULL === self::$GMS)
		{
			/**
			 * @Example GameMasters.php in this directory:
			 *
			 * <? return array('gizmore{14}'); ?>
			 */
			if (false === (self::$GMS = @include_once('GameMasters.php')))
			{
				Dog_Log::warn('No game masters set for Shadowlamb!');
				self::$GMS = array();
			}
		}
		
		if (false === ($user = $player->getUser()))
		{
			return false;
		}
		
		if (!$user->isLoggedIn())
		{
			return false;
		}
		
		return in_array($player->getName(), self::$GMS, true);
	}

	#################
	### Game Data ###
	#################
	private static $cities = array();
	private static $parties = array();
	private static $players = array();
	
	public static function getCities() { return self::$cities; }
	public static function getParties() { return self::$parties; }
	public static function getPlayers() { return self::$players; }
	public static function getCityCount() { return count(self::$cities); }
	
	/**
	 * @return SR_Player
	 */
	public static function getCurrentPlayer() { return Shadowcmd::$CURRENT_PLAYER; }
	
	/**
	 * @return SR_Player
	 */
	public static function getDummyPlayer()
	{
		static $DUMMY;
		if (!isset($DUMMY))
		{
			echo "Creating Dummy!\n";
			$DUMMY = new SR_DummyPlayer(array());
			Shadowcmd::$CURRENT_PLAYER = $DUMMY;
			$DUMMY = SR_Player::getRealNPCByName('Redmond_dloser');
			Shadowcmd::$CURRENT_PLAYER = $DUMMY;
		}
		return $DUMMY;
	}
	
	public static function getHumanPlayers()
	{
		$humans = array();
		foreach (self::$players as $player)
		{
			if (!($player instanceof SR_NPC))
			{
				$humans[] = $player;
			}
		}
		return $humans;
	}
	
	/**
	 * @param string $name
	 * @return SR_Dungeon
	 */
	public static function getCity($name)
	{
		$name = strtolower($name);
		if (!isset(self::$cities[$name]))
		{
			return false;
		}
		return self::$cities[$name];
	}
	
	/**
	 * Get a city by ID.
	 * @param int $id
	 * @return SR_City
	 */
	public static function getCityByID($id)
	{
		$id = (int)$id;
		$back = array_slice(self::$cities, $id-1, 1);
		$back = array_pop($back);
		return $back === NULL ? false : $back;
	}
	
	/**
	 * @return SR_City
	 */
	public static function getCityByAbbrev($name)
	{
		$back = array();
		$name = strtolower($name);
		
		foreach (self::$cities as $cn => $city)
		{
			$city instanceof SR_City;
			
			if ($name === $cn)
			{
				return $city;
			}
			
			if (strpos($cn, $name) !== false)
			{
				$back[] = $city;
			}
		}
		
		return count($back) === 1 ? $back[0] : false;
	}
	
	public static function addParty(SR_Party $party)
	{
		$pid = $party->getID();
		if (!isset(self::$parties[$pid]))
		{
			$party->setTimestamp(self::getTime());
			self::$parties[$pid] = $party;
		}
	}
	
	public static function getLocationByTarget($target)
	{
		if (false === ($city = self::getCity(Common::substrUntil($target, '_'))))
		{
			return false;
		}
		return $city->getLocation(Common::substrFrom($target, '_', ''));
	}
	
	/**
	 * Get or reload a party from/into memory.
	 * @param int $partyid
	 * @return SR_Party
	 */
	public static function getParty($partyid, $events=true)
	{
		if (0 === ($partyid = (int)$partyid))
		{
			return false;
		}
		
		if (false === isset(self::$parties[$partyid]))
		{
			if (false === ($party = SR_Party::getByID($partyid, $events)))
			{
				return false;
			}
			self::$parties[$partyid] = $party;
		}
		return self::$parties[$partyid];
	}
	
	/**
	 * Remove a party from memory.
	 * @param SR_Party $party
	 */
	public static function removeParty(SR_Party $party)
	{
		$partyid = $party->getID();
		foreach ($party->getMembers() as $member)
		{
			self::removePlayer($member);
		}
		unset(self::$parties[$partyid]);
	}
	
	/**
	 * Remove a human player from memory.
	 * @param SR_Player $player
	 */
	public static function removePlayer(SR_Player $player)
	{
		unset(self::$players[$player->getID()]);
	}
	
	/**
	 * Add a player to memory.
	 * @param SR_Player $player
	 */
	public static function addPlayer(SR_Player $player)
	{
		self::$players[$player->getID()] = $player;
	}
	
	/**
	 * Get or load a player.
	 * @param int $playerid
	 * @return SR_Player
	 */
	public static function getPlayerByPID($playerid)
	{
		$playerid = (int)$playerid;
		# Cached
		if (true === isset(self::$players[$playerid]))
		{
			return self::$players[$playerid];
		}
		# Load?
		if (false === ($player = SR_Player::getByID($playerid)))
		{
			return false;
		}
		# Cache (if real player, not NPC)
		if (true === $player->isHuman())
		{
			self::addPlayer($player);
		}
		return $player;
	}

	/**
	 * Get a player by lamb userid from memory.
	 * @param int $uid
	 */
	public static function getPlayerByUID($uid)
	{
		foreach (self::$players as $player)
		{
			$player instanceof SR_Player;
			if (false !== ($user = $player->getUser()))
			{
				if ($uid == $user->getID())
				{
					return $player;
				}
			}
		}
		return false;
	}
	
	/**
	 * Get a player by full name, including {server}.
	 * @param string $name
	 * @return SR_Player
	 */
	public static function getPlayerByName($name)
	{
		$name = strtolower($name);
		foreach (self::$players as $pid => $player)
		{
			$player instanceof SR_Player;
			if (strtolower($player->getName()) === $name)
			{
				return self::$players[$pid];
			}
		}
		return false;
	}
	
	/**
	 * Load a player by name. Usually this username{serverid}
	 * @param string $username
	 */
	public static function loadPlayerByName($username)
	{
		if (false === ($player = self::getPlayerByName($username)))
		{
			return SR_Player::getByLongName($username);
		}
		return $player;
	}
	
	/**
	 * Get a player By Shortname from memory. Returns false when not found. Returns -1 when ambigious.
	 * @param string $name
	 * @return SR_Player|false|-1
	 */
	public static function getPlayerByShortName($name)
	{
		$name = strtolower($name);
		$byshort = array();
		foreach (self::$players as $pid => $player)
		{
			$player instanceof SR_Player;
			if ( ($player->isHuman()) && (strtolower($player->getShortName()) === $name) )
			{
				$byshort[] = $pid;
			}
		}
		switch (count($byshort))
		{
			case 0: return self::getPlayerByName($name);
			case 1: return self::$players[$byshort[0]];
			default: return -1;
		}
	}
	
	/**
	 * @param Dog_User $user
	 * @return SR_Player
	 */
	public static function getPlayerForUser(Dog_User $user, $create=true)
	{ 
		foreach (self::$players as $pid => $player)
		{
			$player instanceof SR_Player;
			if ($player->isHuman())
			{
				$u = $player->getUser();
				if ($u instanceof Dog_User)
				{
					if ($user->getID() === $u->getID())
					{
						return $player;
					}
				}
			}
		}
		
		if (false === ($player = SR_Player::getByUID($user->getID())))
		{
			if ($create === false)
			{
				return false;
			}
			if (false === ($player = SR_Player::createHuman($user)))
			{
				return false;
			}
		}
		
// 		$player->setVar('sr4pl_uid', $user);
		
		self::addPlayer($player);
		
		return $player;
	}
	
	/**
	 * Get an NPC by name.
	 * @param string $name
	 * @return SR_NPC
	 */
	public static function getNPC($name)
	{
		if (false === ($cityname = Common::substrUntil($name, '_', false)))
		{
			return Dog_Log::error(sprintf('Shadowrun4::getNPC(%s) failed no cityname.', $name));
		}
		if (false === ($city = self::getCity($cityname)))
		{
			return Dog_Log::error(sprintf('Shadowrun4::getNPC(%s) failed no city.', $name));
		}
		if (false === ($npc = $city->getNPC($name)))
		{
			return Dog_Log::error(sprintf('Shadowrun4::getNPC(%s) failed no such NPC.', $name));
		}
		return $npc;
	}
	
	/**
	 * Get an NPC by shortcut.
	 * @param string $name
	 * @return SR_NPC
	 */
	public static function getNPCByAbbrev(SR_Player $player, $name)
	{
// 		echo "Testing ".$name."\n";
		$candidates = array();
		foreach (self::$cities as $city)
		{
			$city instanceof SR_City;
			foreach ($city->getNPCs() as $npc)
			{
				$npc instanceof SR_NPC;
				$npc->setChatPartner($player);
				$classname = $npc->getNPCClassName();
				
				if ($name === $classname)
				{
					return $npc;
				}
				
				elseif ( (stripos($classname, $name) !== false)
				   ||(stripos($npc->getName(), $name) !== false) )
				{
// 					echo "Testing ".$npc->getNPCClassName()."\n";
// 					echo "Testing ".$npc->getName()."\n";
					$candidates[$classname] = $npc;
				}
			}
		}
		return count($candidates) === 1 ? array_pop($candidates) : false;
	}
	
	/**
	 * Get all NPCs.
	 * @return array
	 */
	public static function getAllNPCs()
	{
		$npcs = array();
		foreach (self::$cities as $city)
		{
			$city instanceof SR_City;
			$npcs = array_merge($npcs, array_values($city->getNPCs()));
		}
		return $npcs;
	}
	
	############
	### Init ###
	############
	public static function includeFile($filename, $fullpath) { require_once $fullpath; }
	public static function init()
	{
		Dog_Log::debug(__METHOD__);
		
		static $inited = false;
		if ($inited === false)
		{
			$inited = true;
			Shadowlang::onLoadLanguage();
			
			Shadowrap::init();
			self::$sr_timestamp = GWF_CachedCounter::getCount('SR4_TIME');
			$path = self::getShadowDir();
			self::initCore($path);
			self::initCmds($path);
			Shadowcmd::init();
			self::initItems($path);
// 			self::initQuests($path);
			self::initCityBases($path);
			self::initSpells($path);
			self::initCityQuests($path);
			self::initCityNPCs($path);
			self::initCityLocations($path);
// 			self::initCities($path);
			self::initCityAfter();
			SR_Player::init();
// 			require_once DOG_PATH.'Lamb_IRCFrom.php';
// 			require_once DOG_PATH.'Lamb_IRCTo.php';
			
			if (defined('SL4_REALS'))
			{
				self::initRealNPCs();
			}
			
			Shadowcleanup::cleanup();
		}
	}
	
	public static function initTimers()
	{
		echo "Shadowrun4::initTimers()\n";
		self::reloadParties();
		self::callRealNPCFunc('init');
		if (defined('SL4_REALS'))
		{
			Dog_Timer::addTimer(array(__CLASS__, 'shadowTimerItems'), NULL, 300);
			Dog_Timer::addTimer(array(__CLASS__, 'shadowTimerHunger'), NULL, 10); // SR_Feelings::HUNGER_TIMER
		}
		Dog_Timer::addTimer(array(__CLASS__, 'shadowTimerRefreshHP'), NULL, SR_Player::HP_REFRESH_TIMER);
		Dog_Timer::addTimer(array(__CLASS__, 'shadowTimerRefreshMP'), NULL, SR_Player::MP_REFRESH_TIMER);
		Dog_Timer::addTimer(array(__CLASS__, 'shadowTimer'), NULL, self::TICKLEN, false);
	}
	
	public static function getShadowDir() { return DOG_PATH.'dog_modules/dog_module/Shadowlamb/'; }
	public static function initCmds($dir='') { GWF_File::filewalker($dir.'cmd', array(__CLASS__, 'includeFile')); }
	public static function initCore($dir='') { GWF_File::filewalker($dir.'core', array(__CLASS__, 'includeFile')); }
	public static function initItems($dir='') { GWF_File::filewalker($dir.'item', array('SR_Item', 'includeItem')); SR_SetItems::validateSets(); }
	public static function initSpells($dir='') { GWF_File::filewalker($dir.'spell', array('SR_Spell', 'includeSpell')); }
	private static function initCityAfter() { foreach (self::$cities as $city) { $city instanceof SR_City; $city->onInit(); } }

	private static function reloadParties()
	{
		$table = GWF_TABLE_PREFIX.'sr4_party';
		$query = "SELECT * FROM $table WHERE sr4pa_action='talk' OR sr4pa_action='fight' OR sr4pa_action='sleep' OR sr4pa_action='travel' OR sr4pa_action='explore' OR sr4pa_action='goto' OR sr4pa_action='hunt'";
		$db = gdo_db();
		if (false === ($result = $db->queryRead($query))) {
			return false;
		}
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			$pid = (int) $row['sr4pa_id'];
			$party = new SR_Party($row);
			if (true === $party->initMembers())
			{
				self::$parties[$pid] = $party;
			}
		}
		$db->free($result);
		return true;
	}
	
	/**
	 * Init all cities in chronological order.
	 * @param string $dir
	 */
	private static function initCityBases($dir)
	{
// 		Dog_Log::debug('Init all Areas in chronological order...');
		$cities = array(
			'Redmond', 'Hideout', 'OrkHQ',
			'Seattle', 'Harbor', 'Renraku',
			'Delaware', 'Troll', 'Prison', 'NySoft',
			'Chicago', # :(
			'Vegas',
			'Amerindian',
		);
		foreach ($cities as $city)
		{
			GWF_File::filewalker($dir.'city', false, array(__CLASS__, 'initCityBase'), false, $city);
		}
		
		# And the rest for backwards compatible
// 		Dog_Log::debug('Init remaining / new areas...');
		GWF_File::filewalker($dir.'city', false, array(__CLASS__, 'initCityBase'), false, NULL);
	}
	
	
	public static function initCityBase($entry, $fullpath, $cityname)
	{
		# Already inited
		if (false !== self::getCity($entry))
		{
			return;
		}
		
		# Init later
		if ( (is_string($cityname)) && (strpos($entry, $cityname) !== 0) )
		{
			return;
		}
		
		# Announce loading
// 		Dog_Log::debug(sprintf('Shadowrun4::initCityBase(%s)', $entry));
		require_once "{$fullpath}/{$entry}.php";
		self::$cities[strtolower($entry)] = new $entry($entry);
		self::$cities[strtolower($entry)]->onLoadLanguage();
	}
	
	public static function initCityNPCs()
	{
		foreach (self::$cities as $city)
		{
			$city instanceof SR_City;
			$fullpath = self::getShadowDir().'city/'.$city->getName().'/npc';
			if (Common::isDir($fullpath))
			{
				GWF_File::filewalker($fullpath, array($city, 'initNPCS'));				
			}
		}
	}
	
	private static function initRealNPCs()
	{
		foreach (self::$cities as $city)
		{
			$city instanceof SR_City;
			
			foreach ($city->getLocations() as $location)
			{
				$location instanceof SR_Location;
				
				foreach ($location->getRealNPCS() as $classname)
				{
					if (false === ($npc = SR_Player::getRealNPCByName($classname)))
					{
						GWF_Log::logCritical('Cannot create real npc with classname: '.$classname);
					}

					$party = $npc->getParty(false);
					
					if (!$party->isAtLocation() && !$party->isMoving())
					{
						$party->saveVars(array(
							'sr4pa_action' => SR_Party::ACTION_INSIDE,
							'sr4pa_target' => $location->getName(),
							'sr4pa_eta' => 0,
							'sr4pa_last_action' => SR_Party::ACTION_OUTSIDE,
							'sr4pa_last_target' => $location->getName(),
							'sr4pa_last_eta' => 0,
						));
					}

					$npc = $party->getLeader();
					
					self::addPlayer($npc);
					self::addParty($party);
					
					$party->setTimestamp(time()+GWF_Time::ONE_MONTH);
				}
			}
			
		}
	}
	
	
	public static function initCityLocations()
	{
		foreach (self::$cities as $city)
		{
			$city instanceof SR_City;
			$fullpath = self::getShadowDir().'city/'.$city->getName().'/location';
			if (Common::isDir($fullpath))
			{
				GWF_File::filewalker($fullpath, array($city, 'initLocations'));				
			}
		}
		self::validateCityLocations();
	}
	
	public static function validateCityLocations()
	{
		foreach (self::$cities as $city)
		{
			$city instanceof SR_City;
			$city->validateLocations();
		}
	}
	
	public static function initCityQuests()
	{
		foreach (self::$cities as $city)
		{
			$city instanceof SR_City;
			$fullpath = self::getShadowDir().'city/'.$city->getName().'/quest';
			if (Common::isDir($fullpath))
			{
				GWF_File::filewalker($fullpath, array($city, 'initQuests'));				
			}
		}
	}
	
	###############
	### Trigger ###
	###############
	public static function onTrigger(Dog_User $user, $msg)
	{
		if ($user->isRegistered() && !$user->isLoggedIn())
		{
			if (false !== ($mod_al = Dog_Module::getModule('AutoLogin')))
			{
				$mod_al instanceof DOGMOD_AutoLogin;
				$mod_al->onTryAutoLogin();
			}
			# You need to login to play.
			return Dog::reply( DOGMOD_Shadowlamb::instance()->lang('0001'));
		}
		
		if (false === ($player = self::getPlayerForUser($user)))
		{
			return Dog::reply('Can not get Player for user '.$user->getName().'.');
		}
		
		SR_Tell::onTell($player);
		
		# Do it!
		Shadowcmd::onTrigger($player, $msg);
	}
	
	public static function onQuit(Dog_Server $server, Dog_User $user, $message)
	{
		if (false === ($player = self::getPlayerByUID($user->getID())))
		{
// 			printf('Can not get Player for user '.$user->getName().".\n");
			return;
		}
		$p = $player->getParty();
		# %s just quit his irc server.
		$p->ntice('5000', array($player->displayNameNB()), $player);
	}
	
	#############
	### Timer ###
	#############
	private static $sr_timestamp = 0;
	public static function getTime() { return self::$sr_timestamp; }
	public static function getRealTime() { return self::$sr_timestamp * SR_Feelings::REAL_SECONDS_PER_TICK; }

	public static function shadowTimer()
	{
		# 1 second over in the Shadowlamb world.
		self::$sr_timestamp = GWF_Counter::getAndCount('SR4_TIME', self::SECONDS_PER_TICK);
	
		# Execute Web Commands
// 		self::shadowTimerWebcommands();
		
		if (defined('SL4_REALS'))
		{
			self::shadowTimerRealNPCs();
		}
		
		# All parties:
		$partyids = array_keys(self::$parties);
		shuffle($partyids); # Shuffle which party goes first to have evenly distributed winners in race conditions.
		foreach ($partyids as $id)
		{
			# still there?
			if (isset(self::$parties[$id]))
			{
				if (self::$parties[$id]->getTimestamp() < (time()-self::KICK_IDLE_TIMEOUT))
				{
					self::removeParty(self::$parties[$id]);
				}
				else 
				{
					self::$parties[$id] instanceof SR_Party; 
					self::$parties[$id]->timer(self::$sr_timestamp);
				}
			}
		}
		
		# Next tick in one second pls.
		Dog_Timer::addTimer(array(__CLASS__, 'shadowTimer'), NULL, self::TICKLEN, false);
	}
// 	private static function shadowTimerWebcommands()
// 	{
// 		$table = GDO::table('Lamb_IRCTo');
// 		if (false === ($result = $table->select('*'))) {
// 			return;
// 		}
// 		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A))) 
// 		{
// 			if (false !== ($player = self::getPlayerByPID($row['lit_pid'])))
// 			{
// // 				$player->setOption(SR_Player::WWW_OUT, true);
// // 				$player->setOption(SR_Player::DIRTY_FLAGS, false);
// 				echo $row['lit_message'].PHP_EOL;
// 				Shadowcmd::onTrigger($player, $row['lit_message']);
// 			}
// 		}
// 		$table->free($result);
// 		$table->truncate();
// 	}
	public static function shadowTimerRefreshHP()
	{
		foreach (self::$players as $player)
		{
			$player instanceof SR_Player;
			$player->refreshHPTimer();
		}
	}
	public static function shadowTimerRefreshMP()
	{
		foreach (self::$players as $player)
		{
			$player instanceof SR_Player;
			$player->refreshMPTimer();
		}
	}
	
	public static function shadowTimerHunger()
	{
		foreach (self::$players as $player)
		{
			$player instanceof SR_Player;
			if ($player->isCreated() && $player->hasFeelings())
			{
				SR_Feelings::timer($player);
			}
		}
	}
	
	public static function shadowTimerItems()
	{
		foreach (self::$players as $player)
		{
			$player instanceof SR_Player;
			if ($player->hasRottingItems())
			{
				$player->itemDurationTimer();
			}
		}
	}
	
	public static function callRealNPCFunc($function_name, array $args=array())
	{
		foreach (self::$players as $player)
		{
			if ($player instanceof SR_RealNPC)
			{
				$player->realnpcfunc($function_name, $args);
			}
		}
	}
	
	public static function shadowTimerRealNPCs()
	{
		self::callRealNPCFunc('tick');
		self::callRealNPCFunc('goal_when_idle');
	}
}
