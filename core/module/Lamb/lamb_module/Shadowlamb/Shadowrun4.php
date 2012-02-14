<?php
require_once 'Shadowcmd.php';
require_once 'Shadowfunc.php';
require_once 'Shadowhelp.php';
require_once 'Shadowlang.php';
require_once 'Shadowrap.php';
require_once 'Shadowshout.php';

final class Shadowrun4
{
	const SR_SHORTCUT = '#';
	const KICK_IDLE_TIMEOUT = 1800; # 30min
	const TICKLEN = 1.0; # 1.0 real second == 1 gametick
	const SECONDS_PER_TICK = 1; # N game second per gametick (you may want to raise during developement, only full int)
	
	################
	### Language ###
	################
	public static function lang($key, $args=NULL) { return LambModule_Shadowlamb::instance()->lang($key, $args); }
	
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
				self::$GMS = array('gizmore{1}');
			}
		}

		if (NULL === ($user = $player->getUser()))
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
	
	public static function getCityByAbbrev($name)
	{
		$back = array();
		foreach (self::$cities as $cn => $city)
		{
			if (stripos($cn, $name) !== false)
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
	public static function getParty($partyid)
	{
		$partyid = (int)$partyid;
		if (false === isset(self::$parties[$partyid]))
		{
			if (false === ($party = SR_Party::getByID($partyid)))
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
			if (NULL !== ($user = $player->getUser()))
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
	 * @param Lamb_User $user
	 * @return SR_Player
	 */
	public static function getPlayerForUser(Lamb_User $user, $create=true)
	{ 
		foreach (self::$players as $pid => $player)
		{
			$player instanceof SR_Player;
			$u = $player->getUser();
			if ($u instanceof Lamb_User)
			{
				if ($user->getID() === $u->getID())
				{
					return $player;
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
			return Lamb_Log::logError(sprintf('Shadowrun4::getNPC(%s) failed no cityname.', $name));
		}
		if (false === ($city = self::getCity($cityname)))
		{
			return Lamb_Log::logError(sprintf('Shadowrun4::getNPC(%s) failed no city.', $name));
		}
		if (false === ($npc = $city->getNPC($name)))
		{
			return Lamb_Log::logError(sprintf('Shadowrun4::getNPC(%s) failed no such NPC.', $name));
		}
		return $npc;
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
		Lamb_Log::logDebug(__METHOD__);
		
		static $inited = false;
		if ($inited === false)
		{
			$inited = true;
			Shadowrap::init();
			self::$sr_timestamp = GWF_Counter::getCount('Lamb_SR4_Timestamp');
			self::initCore(Lamb::DIR);
			self::initCmds(Lamb::DIR);
			Shadowcmd::init();
			self::initItems(Lamb::DIR);
// 			self::initQuests(Lamb::DIR);
			self::initCityBases(Lamb::DIR);
			self::initSpells(Lamb::DIR);
			self::initCityQuests(Lamb::DIR);
			self::initCityNPCs(Lamb::DIR);
			self::initCityLocations(Lamb::DIR);
// 			self::initCities(Lamb::DIR);
			self::initCityAfter();
			SR_Player::init();
			require_once Lamb::DIR.'Lamb_IRCFrom.php';
			require_once Lamb::DIR.'Lamb_IRCTo.php';

			Shadowlang::onLoadLanguage();
		}
	}
	public static function initTimers()
	{
		$bot = Lamb::instance();
		self::reloadParties();
		$bot->addTimer(array(__CLASS__, 'shadowTimer'), self::TICKLEN, NULL, NULL, 1);
		$bot->addTimer(array(__CLASS__, 'shadowTimerRefreshHP'), SR_Player::HP_REFRESH_TIMER);
		$bot->addTimer(array(__CLASS__, 'shadowTimerRefreshMP'), SR_Player::MP_REFRESH_TIMER);
//		$bot->addTimer(array(__CLASS__, 'shadowTimerItems'), 60);
	}
	
	public static function getShadowDir() { return Lamb::DIR.'lamb_module/Shadowlamb/'; }
	public static function initCmds($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/cmd', array(__CLASS__, 'includeFile')); }
	public static function initCore($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/core', array(__CLASS__, 'includeFile')); }
	public static function initItems($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/item', array('SR_Item', 'includeItem')); }
	public static function initSpells($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/spell', array('SR_Spell', 'includeSpell')); }
// 	public static function initCities($dir='') { self::initCityFiles($dir); self::initCityAfter(); }
// 	private static function initCityFiles($dir) { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/city', false, array(__CLASS__, 'initCity'), false); }
// 	private static function initCityNPCs($dir) { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/city', false, array(__CLASS__, 'initCityNPC'), false); }
// 	private static function initCityQuests($dir) { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/city', false, array(__CLASS__, 'initCityQuest'), false); }
// 	private static function initCityLocations($dir) { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/city', false, array(__CLASS__, 'initCityLocation'), false); }
	private static function initCityAfter() { foreach (self::$cities as $city) { $city->onInit(); } }
// 	public static function initQuests($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/quest', array('SR_Quest', 'includeQuest')); }
//	public static function initTimer() { self::$sr_timestamp = GWF_Counter::getCount('Lamb_SR4_Timestamp'); }

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
	 * @param unknown_type $dir
	 */
	private static function initCityBases($dir)
	{
		Lamb_Log::logDebug('Init all Areas in chronological order...');
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
			GWF_File::filewalker($dir.'lamb_module/Shadowlamb/city', false, array(__CLASS__, 'initCityBase'), false, $city);
		}
		
		# And the rest for backwards compatible
		Lamb_Log::logDebug('Init remaining / new areas...');
		GWF_File::filewalker($dir.'lamb_module/Shadowlamb/city', false, array(__CLASS__, 'initCityBase'), false, NULL);
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
		Lamb_Log::logDebug(sprintf('Shadowrun4::initCityBase(%s)', $entry));
		require_once "{$fullpath}/{$entry}.php";
		self::$cities[strtolower($entry)] = new $entry($entry);
		self::$cities[strtolower($entry)]->onLoadLanguage();
	}
	
	public static function initCityNPCs($dir='stub')
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
	
	public static function initCityLocations($dir='stub')
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
	}
	
	public static function initCityQuests($dir='stub')
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
	public static function onTrigger(Lamb_Server $server, Lamb_User $user, $channel_name, $msg)
	{
		$bot = Lamb::instance();
		if ($user->isRegistered() && !$user->isLoggedIn())
		{
			$bot->tryAutologin($user);
			# You need to login to play.
			return $bot->reply(LambModule_Shadowlamb::instance()->langUser($user, '0001'));
		}
		
		if (false === ($player = self::getPlayerForUser($user)))
		{
			return $bot->reply('Can not get Player for user '.$user->getName().'.');
		}
		
		$player->setOption(SR_Player::WWW_OUT, false);
		
		SR_Tell::onTell($player);
		
		# Do it!
		Shadowcmd::onTrigger($player, $msg);
	}
	
	public static function onQuit(Lamb_Server $server, Lamb_User $user, $message)
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
	public static function shadowTimer()
	{
		# 1 second over in the Shadowlamb world.
		self::$sr_timestamp = GWF_Counter::getAndCount('Lamb_SR4_Timestamp', self::SECONDS_PER_TICK);
	
		# Next tick in one second max pls.
		Lamb::instance()->addTimer(array(__CLASS__, 'shadowTimer'), self::TICKLEN, NULL, NULL, 1);
		
		# Execute Web Commands
		self::shadowTimerWebcommands();
		
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
					self::$parties[$id]->timer(self::$sr_timestamp);
				}
			}
		}
	}
	private static function shadowTimerWebcommands()
	{
		$table = GDO::table('Lamb_IRCTo');
		if (false === ($result = $table->select('*'))) {
			return;
		}
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A))) 
		{
			if (false !== ($player = self::getPlayerByPID($row['lit_pid'])))
			{
				$player->setOption(SR_Player::WWW_OUT, true);
				$player->setOption(SR_Player::DIRTY_FLAGS, false);
				echo $row['lit_message'].PHP_EOL;
				Shadowcmd::onTrigger($player, $row['lit_message']);
			}
		}
		$table->free($result);
		$table->truncate();
	}
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
	
	public static function shadowTimerItems()
	{
		foreach (self::$players as $player)
		{
			$player instanceof SR_Player;
			$player->itemDurationTimer();
		}
	}
}
?>
