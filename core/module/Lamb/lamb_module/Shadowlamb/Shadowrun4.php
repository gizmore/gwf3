<?php
require_once 'Shadowcmd.php';
require_once 'Shadowfunc.php';
require_once 'Shadowhelp.php';
require_once 'Shadowrap.php';
require_once 'Shadowshout.php';

final class Shadowrun4
{
	const SR4_ALPHA = false; # iS BETA?
	
	const SR_SHORTCUT = '#';
	const KICK_IDLE_TIMEOUT = 3600; # 1h
	const SECONDS_PER_TICK = 1.0;
	
	####################
	### Game Masters ###
	####################
	private static $GMS = array('gizmore');
	public static function isGM(SR_Player $player)
	{
		if (NULL === ($user = $player->getUser()))
		{
			return false;
		}
//		if (!$user->isLoggedIn()) {
//			return false;
//		}
		return in_array($user->getName(), self::$GMS, true);
	}

	#################
	### Game Data ###
	#################
	private static $cities = array();
	private static $parties = array();
	private static $players = array();
	
	public static function getParties() { return self::$parties; }
	public static function getPlayers() { return self::$players; }
	public static function getCityCount() { return count(self::$cities); }
	
	/**
	 * @param string $name
	 * @return SR_Dungeon
	 */
	public static function getCity($name)
	{
		if (!isset(self::$cities[$name]))
		{
//			Lamb_Log::logError(sprintf('Unknown city: %s.', $name));
			return false;
		}
		return self::$cities[$name];
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
	 * @param int $partyid
	 * @return SR_Party
	 */
	public static function getParty($partyid)
	{
		$partyid = (int)$partyid;
		if (!(isset(self::$parties[$partyid]))) {
			if (false === ($party = SR_Party::getByID($partyid))) {
				return false;
			}
			self::$parties[$partyid] = $party;
		}
		return self::$parties[$partyid];
	}
	
	public static function removeParty(SR_Party $party)
	{
		$partyid = $party->getID();
		foreach ($party->getMembers() as $member)
		{
			self::removePlayer($member);
		}
		unset(self::$parties[$partyid]);
	}
	
	public static function removePlayer(SR_Player $player)
	{
		unset(self::$players[$player->getID()]);
	}
	
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
		if (isset(self::$players[$playerid]))
		{
			return self::$players[$playerid];
		}
		# Load?
		if (false === ($player = SR_Player::getByID($playerid)))
		{
			return false;
		}
		# Cache
		self::$players[$playerid] = $player;
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
//			if ($user instanceof Lamb_User)
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
			if ($create === false) {
				return false;
			}
			if (false === ($player = SR_Player::createHuman($user))) {
				return false;
			}
		}
		
		$pid = $player->getID();
//		if (!isset(self::$players[$pid])) {
		self::$players[$pid] = $player;
//		}
		return self::$players[$pid];
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
			self::initItems(Lamb::DIR);
			self::initSpells(Lamb::DIR);
			self::initCities(Lamb::DIR);
			self::initQuests(Lamb::DIR);
			SR_Player::init();
//			require_once 'SR_Install.php';
//			SR_Install::onInstall();
			require_once Lamb::DIR.'Lamb_IRCFrom.php';
			require_once Lamb::DIR.'Lamb_IRCTo.php';
		}
	}
	public static function initTimers()
	{
		$bot = Lamb::instance();
		self::reloadParties();
		$bot->addTimer(array(__CLASS__, 'shadowTimer'), self::SECONDS_PER_TICK, NULL, NULL, 1);
		$bot->addTimer(array(__CLASS__, 'shadowTimerRefreshHP'), SR_Player::HP_REFRESH_TIMER);
		$bot->addTimer(array(__CLASS__, 'shadowTimerRefreshMP'), SR_Player::MP_REFRESH_TIMER);
//		$bot->addTimer(array(__CLASS__, 'shadowTimerItems'), 60);
	}
	
	public static function initCmds($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/cmd', array(__CLASS__, 'includeFile')); }
	public static function initCore($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/core', array(__CLASS__, 'includeFile')); }
	public static function initItems($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/item', array('SR_Item', 'includeItem')); }
	public static function initSpells($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/spell', array('SR_Spell', 'includeSpell')); }
	public static function initCities($dir='') { self::initCityFiles($dir); self::initCityAfter(); }
	private static function initCityFiles($dir) { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/city', false, array(__CLASS__, 'initCity'), false); }
	private static function initCityAfter() { foreach (self::$cities as $city) { $city->onInit(); } }
	public static function initQuests($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/quest', array('SR_Quest', 'includeQuest')); }
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
	
	public static function initCity($entry, $fullpath)
	{
		Lamb_Log::logDebug(sprintf('Shadowrun4::initCity(%s)', $entry));
		require_once $fullpath."/$entry.php";
		self::$cities[$entry] = $city = new $entry($entry);
		GWF_File::filewalker($fullpath.'/location', array($city, 'initLocations'));
		GWF_File::filewalker($fullpath.'/npc', array($city, 'initNPCS'));
	}
	
	private static function initCities2()
	{
		foreach (self::$cities as $name => $city)
		{
			$city->onInit();
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
			return $bot->reply('You need to login to play.');
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
		$p->notice(sprintf('%s just quit his irc server.', $player->displayNameNB()), $player);
	}
	
	#############
	### Timer ###
	#############
	private static $sr_timestamp = 0;
	public static function getTime() { return self::$sr_timestamp; }
	public static function shadowTimer()
	{
		# 1 second over in the Shadowlamb world.
		self::$sr_timestamp = GWF_Counter::getAndCount('Lamb_SR4_Timestamp');
//		Lamb_Log::logDebug(sprintf('Executing %s with shadowtime=%s', __METHOD__, self::$sr_timestamp));
		
		# Next tick in one second max pls.
		Lamb::instance()->addTimer(array(__CLASS__, 'shadowTimer'), self::SECONDS_PER_TICK, NULL, NULL, 1);
		
		# Execute Web Commands
		self::shadowTimerWebcommands();
		
		# All parties:
		$partyids = array_keys(self::$parties);
		shuffle($partyids);
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
