<?php
require_once 'Shadowcmd.php';
require_once 'Shadowfunc.php';
require_once 'Shadowhelp.php';
require_once 'Shadowrap.php';

final class Shadowrun4
{
	####################
	### Game Masters ###
	####################
	private static $GMS = array('gizmore');
	public static function isGM(SR_Player $player)
	{
		if (NULL === ($user = $player->getUser())) {
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
	
	
	/**
	 * @param string $name
	 * @return SR_City
	 */
	public static function getCity($name)
	{
		if (!isset(self::$cities[$name])) {
			Lamb_Log::log(sprintf('Unknown city: %s.', $name));
			return false;
		}
		return self::$cities[$name];
	}
	
	public static function addParty(SR_Party $party)
	{
		$pid = $party->getID();
		if (!isset(self::$parties[$pid]))
		{
			self::$parties[$pid] = $party;
		}
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
//		$party->setDeleted(true);
		unset(self::$parties[$partyid]);
	}
	
	public static function removePlayer(SR_Player $player)
	{
		$playerid = $player->getID();
		unset(self::$players[$playerid]);
	}
	
	/**
	 * @param int $playerid
	 * @return SR_Player
	 */
	public static function getPlayerByPID($playerid)
	{
		$playerid = $playerid;
		if (isset(self::$players[$playerid]))
		{
			return self::$players[$playerid];
		}
		
		if (false === ($player = SR_Player::getByID($playerid))) {
			return false;
		}
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
			$user = $player->getUser();
			if ($user instanceof Lamb_User)
			{
				if ($uid === $user->getID())
				{
					return $player;
				}
			}
		}
		return false;
	}
	
	/**
	 * @param string $name
	 * @return SR_Player
	 */
	public static function getPlayerByName($name, $shortname=false)
	{
		$name = strtolower($name);
		foreach (self::$players as $pid => $player)
		{
			$player instanceof SR_Player;
			if (strtolower($player->getName()) === $name)
			{
				return $player;
			}
		}
		return false;
	}
	
	
	/**
	 * @param Lamb_User $user
	 * @return SR_Player
	 */
	public static function getPlayerForUser(Lamb_User $user)
	{ 
		if (false === ($player = SR_Player::getByUID($user->getID()))) {
			if (false === ($player = SR_Player::createHuman($user))) {
				return false;
			}
		}
		
		$pid = $player->getID();
		if (!isset(self::$players[$pid])) {
			self::$players[$pid] = $player;
		}
		return self::$players[$pid];
	}
	
	/**
	 * @param string $name
	 * @return SR_NPC
	 */
	public static function getNPC($name)
	{
		if (false === ($cityname = Common::substrUntil($name, '_', false))) {
			Lamb_Log::log(sprintf('Shadowrun4::getNPC(%s) failed no cityname.', $name));
			return false;
		}
		if (false === ($city = self::getCity($cityname))) {
			Lamb_Log::log(sprintf('Shadowrun4::getNPC(%s) failed no city.', $name));
			return false;
		}
		if (false === ($npc = $city->getNPC($name))) {
			Lamb_Log::log(sprintf('Shadowrun4::getNPC(%s) failed no such NPC.', $name));
			return false;
		}
		return $npc;
	}
	
	############
	### Init ###
	############
	public static function includeFile($filename, $fullpath) { require_once $fullpath; }
	public static function init(Lamb_Server $server)
	{
		Lamb_Log::log('Shadowrun4::init()');
		static $inited = false;
		if ($inited === false)
		{
			$inited = true;
			
			self::initCore(Lamb::DIR);
			self::initItems(Lamb::DIR);
			self::initSpells(Lamb::DIR);
			self::initCities(Lamb::DIR);
			
			require_once 'SR_Install.php';
			SR_Install::onInstall(false);
			
			self::reloadParties();
			
			Lamb::instance()->addTimer($server, array(__CLASS__, 'shadowTimer'), NULL, 1.0);
			
			Shadowrap::init();
			
			require_once Lamb::DIR.'Lamb_IRCFrom.php';
			require_once Lamb::DIR.'Lamb_IRCTo.php';
		}
	}
	
	public static function initCore($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/core', array(__CLASS__, 'includeFile')); }
	public static function initItems($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/item', array('SR_Item', 'includeItem')); }
	public static function initSpells($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/spell', array('SR_Spell', 'includeSpell')); }
	public static function initCities($dir='') { GWF_File::filewalker($dir.'lamb_module/Shadowlamb/city', false, array(__CLASS__, 'initCity'), false); }
	public static function initTimer() { self::$sr_timestamp = GWF_Counter::getCount('Lamb_SR4_Timestamp'); }
	
	private static function reloadParties()
	{
		$table = GWF_TABLE_PREFIX.'sr4_party';
		$query = "SELECT * FROM $table WHERE sr4pa_action='talk' OR sr4pa_action='fight' OR sr4pa_action='search' OR sr4pa_action='sleep' OR sr4pa_action='travel' OR sr4pa_action='explore' OR sr4pa_action='goto' OR sr4pa_action='hunt'";
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
		Lamb_Log::log(sprintf('Shadowrun4::initCity(%s)', $entry));
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
		if ($user->isRegistered() && !$user->isLoggedIn()) {
			return $bot->reply('You need to login to play.');
		}
		
		if (false === ($player = self::getPlayerForUser($user))) {
			return $bot->reply('Can not get Player for user '.$user->getName().'.');
		}
		
		$player->setOption(SR_Player::WWW_OUT, false);
		
		# Do it!
		Shadowcmd::onTrigger($player, $msg);
	}
	
	#############
	### Timer ###
	#############
	private static $sr_timestamp = 0;
	public static function getTime() { return self::$sr_timestamp; }
	public static function shadowTimer(Lamb_Server $server)
	{
		# Execute Web Commands
		self::shadowTimerWebcommands();
		
		# 1 second over in the Shadowlamb world.
		self::$sr_timestamp = GWF_Counter::getAndCount('Lamb_SR4_Timestamp');
//		Lamb_Log::log(sprintf('Shadowrun4::shadowTimer(%s) with %d parties.', self::$sr_timestamp, count(self::$parties)));
		
		# Call timer in 1 second again
		Lamb::instance()->addTimer($server, array(__CLASS__, 'shadowTimer'), NULL, 1.0);
		
		# All parties:
		$partyids = array_keys(self::$parties);
		shuffle($partyids);
		foreach ($partyids as $id)
		{
			# still alive?
			if (isset(self::$parties[$id]))
			{
				# Timer then
				self::$parties[$id]->timer(self::$sr_timestamp);
			}
		}
	}
	
	private static function shadowTimerWebcommands()
	{
//		echo __METHOD__.PHP_EOL;
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
}
?>
