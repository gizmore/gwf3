<?php
final class Lamb_Server
{
	const MAX_TRIES = 30;
	
	const IPS_NOT_CLOAKED = 0x01;
	
	private $id = 0;
	private $nicknames = 'Lamb,Lamb2,Lamb3';
	private $password = '';
	private $nickname_id = -1;
	private $current_nick = '';
	private $auto_chans = '';
	
	private $admins = array();
	
	private $full_hostname = '';
	private $hostname = '';
	private $port = 6667;
	private $maxusers = 0;
	private $maxchannels = 0;
	private $ip = '';
	
	private $retry_count = 0;
	private $next_retry = 0;
	
	private $lm_from = ''; # latest from/origin:
	private $lm_from_raw = ''; # latest from/origin:!IP.blub
	
	public function setFrom($from)
	{
		$this->lm_from_raw = $from;
		$this->lm_from = Common::substrUntil($from, '!');
	}
	
	public function getFrom()
	{
		return $this->lm_from;
	}
	
	public function getFromRaw()
	{
		return $this->lm_from_raw;
	}
	
	/**
	 * @var Lamb_IRC
	 */
	private $connection;
	private $channels = array(); // array of class Lamb_Channel
	private $users = array();
	
	public function __construct($host, $nicknames, $password, $channels, $admin)
	{
		$this->full_hostname = $host;
		$this->connection = new Lamb_IRC($host);
		$this->hostname = $this->connection->getHostname();
		$this->port = $this->connection->getPort();
//		$host = Common::substrFrom($host, '://', $host);
//		$this->hostname = Common::substrUntil($host, ':');
//		$this->port = intval(Common::substrFrom($host, ':', '6667'));
		$this->nicknames = trim($nicknames);
		$this->password = trim($password);
		$this->auto_chans = trim($channels);
		$this->admins = $admin === '' ? array() : explode(',', $admin);
		$this->syncDB();
		$this->next_retry = time();
	}
	
	public function getAutoChannels()
	{
		return explode(',', $this->auto_chans);
	}
	
	public function isAutoChannel($channel_name)
	{
		return in_array($channel_name, $this->getAutoChannels(), true);
	}
	
	public static function getByMsg($msg)
	{
		return is_numeric($msg) ? self::getByID($msg) : self::getByHost($msg);
	}
	
	public static function getByID($id)
	{
		$db = gdo_db();
		$id = (int)$id;
		$table = GWF_TABLE_PREFIX.'lamb_server';
		if (false === ($result = $db->queryFirst("SELECT serv_name,serv_nicknames,serv_password,serv_channels,serv_admins from $table WHERE serv_id=$id", false))) {
			return false;
		}
		$result = array_values($result);
		return new self($result[0], $result[1], $result[2], $result[3], $result[4]);
	}
	
	public static function getByHost($hostname)
	{
		$db = gdo_db();
		$hostname = $db->escape($hostname);
		$table = GWF_TABLE_PREFIX.'lamb_server';
		if (false === ($result = $db->queryFirst("SELECT serv_name,serv_nicknames,serv_password,serv_channels,serv_admins from $table WHERE serv_name LIKE '%$hostname%'", false))) {
			return false;
		}
		$result = array_values($result);
		return new self($result[0], $result[1], $result[2], $result[3], $result[4]);
	}
	
	public function __destruct()
	{
		$this->connection->disconnect();
	}
	
	public function getHostname()
	{
		return $this->hostname;
	}
	
	public function getPort()
	{
		return $this->port;
	}
	
	public function getBotsNickname()
	{
		return $this->current_nick;
	}
	
	public function getName()
	{
		return $this->hostname;
	}
	
	public function isSSL()
	{
		return Common::substrUntil($this->full_hostname, '://') === 'ircs';
	}
	
	public function getIP()
	{
		return $this->ip;
	}
	
	public function getMaxUsers()
	{
		return $this->maxusers;
	}
	
	public function getMaxChannels()
	{
		return $this->maxchannels;
	}
	
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_server'; }
	
	private function syncDB()
	{
		$db = gdo_db();
		$table = $this->getTableName();
		$tld = $this->getTLD();
		$tld = $db->escape($tld);
		$query = "SELECT serv_id, serv_maxusers, serv_maxchannels, serv_ip, serv_nicknames, serv_channels, serv_password, serv_admins FROM $table WHERE serv_name LIKE '%$tld%'";
		if (false === ($result = $db->queryFirst($query))) {
			return $this->newServer();
		}
		$this->id = (int) $result['serv_id'];
		$this->maxusers = (int) $result['serv_maxusers'];
		$this->maxchannels = (int) $result['serv_maxchannels'];
		$this->ip = $result['serv_ip'];
		$this->nicknames = $result['serv_nicknames'];
		$this->auto_chans = trim($result['serv_channels']);
		$this->password = $result['serv_password'];
		$this->admins = explode(',', $result['serv_admins']);
	}
	
	public function getTLD()
	{
		return Common::getTLD($this->full_hostname);
	}
	
	public function saveConfigVars($host, $nicks, $chans, $pass, $admin)
	{
		$db = gdo_db();
		$id = $this->getID();
		$table = $this->getTableName();
		$this->full_hostname = $host; $host = $db->escape($host);
		$this->nicknames = $nicks; $nicks = $db->escape($nicks);
		$this->auto_chans = $chans; $chans = $db->escape($chans);
		$this->password = $pass; $pass = $db->escape($pass);
		$admins = $db->escape($admin);
		$this->admins = $admin === '' ? array() : explode(',', $admin);
		$query = "UPDATE $table SET serv_name='$host', serv_nicknames='$nicks', serv_channels='$chans', serv_password='$pass', serv_admins='$admins' WHERE serv_id=$id";
		if (false === $db->queryWrite($query)) {
			die('DB Error: Cannot write server table');
		}
	}
	
	
	public function getID()
	{
		return $this->id;
	}
	
	public function getChannels()
	{
		return $this->channels;
	}
	
	/**
	 * Get a channel from memory.
	 * @param string $channel_name
	 * @return Lamb_Channel
	 */
	public function getChannel($channel_name)
	{
		return isset($this->channels[$channel_name]) ? $this->channels[$channel_name] : false;
	}
	
	public function getUsers()
	{
		return $this->users;
	}
	
	private function newServer()
	{
		$db = gdo_db();
		$name = $db->escape($this->full_hostname);
		$ip = gethostbyname($this->hostname);
		$table = $this->getTableName();
		$enicks = $db->escape($this->nicknames);
		$echans = $db->escape(implode(',', $this->channels));
		$epass = $db->escape($this->password); 
		$eadmins = $db->escape(implode(',', $this->admins));
		$query = "INSERT INTO $table (serv_name, serv_ip, serv_nicknames, serv_channels, serv_password, serv_admins) VALUES('$name', '$ip', '$enicks', '$echans', '$epass', '$eadmins')";
		if (false === $db->queryWrite($query)) {
			return false;
		}
		$this->ip = $ip;
		$this->id = $db->insertID();
		return true;
	}
	
	/**
	 * @return Lamb_IRC
	 */
	public function getConnection()
	{
		return $this->connection;
	}
	
	public function connect()
	{
		if ($this->retry_count >= self::MAX_TRIES) {
			Lamb_Log::log('Giving up to connect to '.$this->hostname.PHP_EOL);
			return false;
		}
		
		if (time() < $this->next_retry) {
			return true;
		}
		
		$this->retry_count++;
		
		if (false !== $this->connection->connect(LAMB_BLOCKING_IO))
		{
			$this->login();
			$this->sendNickname();
			return true;
		}
		
		$this->next_retry = time() + 10 * $this->retry_count;
		
		Lamb_Log::log(sprintf('Connection to %s failed. Will retry in %d seconds.', $this->hostname, $this->next_retry-time()).PHP_EOL);
		
		return true;
	}
	
	public function disconnect()
	{
		$this->connection->disconnect();
		$this->channels = array();
		$this->users = array();
	}
	
	public function login()
	{
		$this->connection->send(sprintf('USER %s %s %s :%s', LAMB_USERNAME, LAMB_HOSTNAME, $this->connection->getHostname(), LAMB_REALNAME));
	}
	
	public function sendBotMode()
	{
		$this->connection->send(sprintf('MODE '.$this->current_nick.' +B'));
		$this->connection->send(sprintf('MODE '.$this->current_nick.' +b'));
	}
	
	public function sendNickname()
	{
		# Select next nickname to try.
		$nicks = explode(',', $this->nicknames);
		$this->nickname_id++;
		if ($this->nickname_id >= count($nicks)) {
			$this->nickname_id = -1;
			$this->current_nick = 'Lamb'.Common::randomKey(4, '123456789');
		}
		else {
			$this->current_nick = $nicks[$this->nickname_id];
		}
		
		$this->changeNick($this->current_nick);
	}
	
	public function changeNick($nickname)
	{
		$this->current_nick = $nickname;
		$this->connection->send('NICK '.$nickname);
	}
	
	public function identify()
	{
		if ($this->nickname_id === 0)
		{
			$this->connection->sendPrivmsg('NickServ', 'IDENTIFY '.$this->password);
		}
	}
	
	public function sendPrivmsg($to, $message)
	{
		$this->getConnection()->sendPrivmsg($to, $message);
	}
	
	public function sendCTCPReply($to, $message)
	{
		$this->getConnection()->sendCTCPReply($to, $message);
	}
	
	public function sendCTCPRequest($to, $message)
	{
		$this->getConnection()->sendCTCPRequest($to, $message);
	}
	
	public function sendNotice($to, $message)
	{
		$this->getConnection()->sendNotice($to, $message);
	}
	
	public function sendAction($to, $message)
	{
		$this->getConnection()->sendAction($to, $message);
	}
	
	public function reply($to, $message)
	{
		# PRIVMSG to the bot
		if ($to === $this->current_nick) {
			$message = preg_replace('#https?://#', '', $message);
			$to = $this->getFrom();
		} else {
			if (LAMB_REPLY_ISSUING_NICK) {
				$message = $this->getFrom().': '.$message;
			}
		}
		$this->connection->sendPrivmsg($to, $message);
	}
	
	public function autojoinChannels()
	{
		if ($this->auto_chans !== '')
		{
			$this->join($this->auto_chans);
		}
	}
	
	public function join($channel)
	{
		$this->connection->send(sprintf('JOIN %s', $channel));
	}
	
	public function part($channel)
	{
		unset($this->channels[$channel]);
		$this->connection->send(sprintf('PART %s', $channel));
	}
	
	
	public function pong($hash)
	{
		$this->connection->send(sprintf('PONG %s', $hash));
	}
	
	public function quit($message='')
	{
		if ($message !== '') {
			$message = " :$message";
		}
		$this->connection->send(sprintf('QUIT%s', $message));
	}
	
	public function addUser($username)
	{
		if (!isset($this->users[$username]))
		{
			$this->users[$username] = Lamb_User::getOrCreate($this, $username);
		}
	}
	
	public function remUser($username)
	{
		foreach ($this->channels as $channel)
		{
			$channel instanceof Lamb_Channel;
			$channel->removeUser($username);
		}
		unset($this->users[$username]);
	}
	
	public function getChannelsFor($username)
	{
		$back = array();
		foreach ($this->channels as $c)
		{
			$c instanceof Lamb_Channel;
			if ($c->isUserInChannel($username))
			{
				$back[] = $c;
			}
		}
		return $back;
	}
	
	public function updateMaxchannels($channelcount)
	{
		$channelcount = (int) $channelcount;
		if ($channelcount > $this->maxchannels)
		{
			$db = gdo_db();
			$table = $this->getTableName();
			$id = $this->getID();
			$db->queryWrite("UPDATE $table SET serv_maxchannels=$channelcount WHERE serv_id=$id");
			$this->maxchannels = $channelcount;
		}
	}

	/**
	 * Get a channel for this server.
	 * @param string $channel_name
	 * @return Lamb_Channel
	 */
	public function getOrCreateChannel($channel_name)
	{
		if (isset($this->channels[$channel_name])) {
			return $this->channels[$channel_name];
		}
		
		if ($channel_name === $this->getBotsNickname()) {
			return false;
		}
		
		if (false === ($channel = Lamb_Channel::getByName($this, $channel_name))) {
			if (false === ($channel = Lamb_Channel::createChannel($this, $channel_name))) {
				Lamb_Log::log("Lamb_Server::getOrCreateChannel($channel) FAILED!");
				return false;
			}
		}
		
		$this->channels[$channel_name] = $channel;
		return $channel;
	}

	/**
	 * Get user from origin and channel.
	 * The only true permission safe call.
	 * @param string $origin
	 * @param string $channel_name
	 * @return Lamb_User
	 */
	public function getUserFromOrigin($origin, $channel_name=NULL)
	{
		if (strpos($origin, '!') === false) {
			return false;
		}
		$username = trim(Common::substrUntil($origin, '!'), ': ');
		
		if (false === ($user = $this->getUserByNickname($username, $channel_name))) {
//			if (false === ($user = Lamb_User::getOrCreate($this, $username))) {
				Lamb_Log::log(sprintf('Can not find user %s ($origin=%s, $channel_name=%s', $username, $origin, $channel_name));
				return false;
//			}
		}
		
		return $user;
	}
	
	/**
	 * Get a user by nickname. Case sensitive.
	 * @param string $nickname
	 * @return Lamb_User
	 */
	public function getUser($nickname)
	{
		return isset($this->users[$nickname]) ? $this->users[$nickname] : false;
	}
	
	
	/**
	 * Get a user by nickname, case insensitive.
	 * @see getUser
	 * @param string $nickname
	 * @return Lamb_User
	 */
	public function getUserI($nickname)
	{
		$n = strtolower($nickname);
		foreach ($this->users as $nick => $user)
		{
			if (!strcasecmp($n, $nick))
			{
				return $user;
			}
		}
		return false;
	}
	
	/**
	 * @param $username
	 * @return Lamb_User
	 */
	public function getUserByNickname($username, $channel_name=NULL)
	{
		if (!isset($this->users[$username]))
		{
			$this->users[$username] = Lamb_User::getOrCreate($this, $username);
		}
		
		if ($channel_name !== NULL) {
			if (false !== ($channel = $this->getChannel($channel_name))) {
				if (false !== ($mode = $channel->getModeByName($username))) {
					$this->users[$username]->setChannelModes($mode);
				}
			}

		}
		
		return $this->users[$username];
	}
	
	public function reloadUser(Lamb_User $user)
	{
		$n = $user->getName();
		unset($this->users[$n]);
		if (false === ($u = self::getUserByNickname($n))) {
			return false;
		}
		if ($user->isLoggedIn()) {
			$u->setLoggedIn(true);
		}
		$this->users[$n] = $u;
		foreach ($this->getChannelsFor($n) as $c) {
			$c instanceof Lamb_Channel;
			$c->removeUser($n);
			$c->addUser($u);
		}
		return true;
	}
	
	public function getUserByNickAndChannel($username, $channel_name)
	{
		if (false === ($channel = $this->getChannel($channel_name))) {
			return false;
		}
		if (false === ($user = $channel->isUserInChannel($username))) {
			return false;
		}
		return $this->getUserByNickname($username, $channel_name);
	}
	
	public function isAdminUsername($username)
	{
		return in_array($username, $this->admins, true);
	}
}
?>