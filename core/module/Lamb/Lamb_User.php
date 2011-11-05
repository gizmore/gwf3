<?php
final class Lamb_User extends GDO
{
	#################
	### Constants ###
	#################
	private $auto_login_attempt = 0;
	public function setAutoLoginAttempt($i) { $this->auto_login_attempt = $i; }
	public function getAutoLoginAttempt() { return $this->auto_login_attempt; }
	
	const USERMODES = '~&@%+';
	
	const ADMIN = 0x01;
	const STAFF = 0x02;
	const OPERATOR = 0x04;
	const HALFOP = 0x08;
	const VOICE = 0x10;
	const USERMODE_FLAGS = 0x1F;
	
	const BOT = 0x100;
	
	public static $PRIVS = array('public','voice','halfop','op','staff','admin');
	public static $SYMBOL = array('public'=>'','voice'=>'','halfop'=>'','op'=>'','staff'=>'','admin'=>'');
	public static function priv2symbol($priv)
	{
		return self::$SYMBOL[$priv];
	}
	
	private $channel_modes = '';
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_user'; }
	public function getOptionsName() { return 'lusr_options'; }
	public function getColumnDefines()
	{
		return array(
			'lusr_id' => array(GDO::AUTO_INCREMENT),
			'lusr_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::INDEX, GDO::NOT_NULL, 64),
			'lusr_sid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lusr_options' => array(GDO::UINT, 0),
//			'lusr_last_date' => array(GDO::DATE, '', GWF_Date::LEN_SECOND),
			'lusr_last_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'lusr_last_channel' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 64),
			'lusr_password' => array(GDO::TOKEN, GDO::NULL, 32),
			'lusr_timestamp' => array(GDO::TIME, GDO::NOT_NULL, 0),
			'lusr_hostname' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 255),
			'lusr_ip' => GWF_IP6::gdoDefine(GWF_IP6::BIN_32_128, GDO::NULL),
		);
	}
	public function getID() { return $this->getVar('lusr_id'); }
	public function getServerID() { return $this->getVar('lusr_sid'); }
	public function getName() { return $this->getVar('lusr_name'); }
	public function isBot() { return $this->isOptionEnabled(self::BOT); }
	public function isAdmin() { return $this->isLoggedIn() && $this->getServer()->isAdminUsername($this->getName()); }
	
	/**
	 * @return Lamb_Server
	 */
	public function getServer()
	{
		return Lamb::instance()->getServer($this->getServerID());
	}
	
	##############
	### Static ###
	##############
	public static function getWWWUser($username)
	{ 
		$username = GDO::escape($username);
		return self::table(__CLASS__)->selectFirstObject('*', "lusr_sid=0 AND lusr_name='$username'");
	}
	
	public static function getByID($lamb_user_id)
	{
		return self::table(__CLASS__)->getRow($lamb_user_id);
	}
	
	public static function getOrCreate(Lamb_Server $server, $username)
	{
		$username = ltrim(trim($username), self::USERMODES);
		if (false !== ($user = self::getUser($server, $username)))
		{
			return $user;
		}
		return self::createUser($server, $username);
	}
	
	public static function getUser(Lamb_Server $server, $username)
	{
		$sid = $server->getID();
		$username = GDO::escape($username);
		return GDO::table(__CLASS__)->selectFirstObject('*', "lusr_sid=$sid AND lusr_name='$username'");
	}
	
	private static function createUser(Lamb_Server $server, $username)
	{
		$user = new self(array(
			'lusr_id' => 0,
			'lusr_name' => $username,
			'lusr_sid' => $server->getID(),
			'lusr_options' => 0,
			'lusr_last_message' => '',
			'lusr_last_channel' => '',
			'lusr_password' => '',
			'lusr_timestamp' => 0,
			'lusr_hostname' => '',
			'lusr_ip' => '',
		));
		if (false === ($user->insert())) {
			return false;
		}
		return $user;
	}
	
	/**
	 * Get the usermode for a nickname.
	 * @example getPriviledge('@gizmore') returns '@';
	 * @param string $nickname
	 * @return string
	 */
	public static function getUsermode($nickname)
	{
		if ('' === ($nickname = trim($nickname)))
		{
			return '';
		}
		$char = $nickname{0};
		if (strpos(self::USERMODES, $char) === false) {
			return '';
		}
		else {
			return $char;
		}
	}
	
	public function getChannelModes()
	{
		return $this->channelModes;
	}

	public function setChannelModes($modes)
	{
		$this->channelModes = $modes;
	}
	
	###################
	### Priviledges ###
	###################
	private $logged_in = false;
	public function setLoggedIn($boolean)
	{
		$this->logged_in = $boolean;
	}
	
	public function isLoggedIn()
	{
		return $this->logged_in === true;
	}
	
	public function isRegistered()
	{
		return $this->getVar('lusr_password') !== '';
	}
	
	public function hasPriviledge($priviledge)
	{
		if ($this->isBot())
		{
			return false;
		}
		
		if (0 === ($need = $this->priviledgeToOption($priviledge)))
		{
			return true;
		}
		
		if (!$this->isLoggedIn())
		{
			return false;
		}
		
		if (0 === ($have = ($this->getOptions() & self::USERMODE_FLAGS)))
		{
			return false;
		}
		
		return $have <= $need;
	}
	
	public static function longPriv($p)
	{
		static $map = array('p'=>'public','v'=>'voice','h'=>'halfop','o'=>'op','s'=>'staff','a'=>'admin',);
		return $map[$p];
	}
	
	private static $map_p20 = array(
			'public' => 0,
			'voice' => self::VOICE,
			'halfop' => self::HALFOP,
			'op' => self::OPERATOR,
			'staff' => self::STAFF,
			'admin' => self::ADMIN,
		);
	public static function priviledgeToOption($priviledge)
	{
		return self::$map_p20[$priviledge];
	}
	
	public static function optionToPriv($bit)
	{
		static $map = array(self::VOICE=>'v', self::HALFOP=>'h', self::OPERATOR=>'o', self::STAFF=>'s', self::ADMIN=>'a');
		return isset($map[$bit]) ? $map[$bit] : 'p';
	}
	
	##############
	### Anonet ###
	##############
	/**
	 * Check if this user is on Anonet. (thx srn)
	 * @return true|false 
	 */
	public function isOnAnonet()
	{
		return self::isOnAnonetS($this->getName());
	}
	
	/**
	 * Check if a nickname is on Anonet. (thx srn)
	 * @param string $nickname
	 * @return true|false 
	 */
	public static function isOnAnonetS($nickname)
	{
		return $nickname[0] === '/';
	}
	
	/**
	 * Get the user's anonet prefix. (thx srn)
	 * @return string|false 
	 */
	public function getAnonetPrefix()
	{
		return self::getAnonetPrefixS($this->getName());
	}
	
	
	/**
	 * Get an Anonet(tm) network prefix from a nickname. (thx srn)
	 * @return string|false 
	 */
	public static function getAnonetPrefixS($nickname)
	{
		return self::isOnAnonetS($nickname) ? self::_getAnoPrefix($nickname) : false;
	}
	private static function _getAnoPrefix($nickname)
	{
		return Common::substrUntil(substr($nickname, 1), '/');
	}
	
}
?>