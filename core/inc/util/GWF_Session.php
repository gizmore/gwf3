<?php
/**
 * GWF Session Handler. It's database driven, and queries a bot database to detect bots by IP.
 * @author gizmore
 *
 */
final class GWF_Session extends GDO
{
	const SESS_ENTROPY = 16;
	
	/**
	 * @var GWF_Session
	 */
	private static $SESSION = NULL;
	private static $USER = false;
	private static $SESSDATA;
	
	###########
	### GDO ###
	###########
	public function getTableName() { return GWF_TABLE_PREFIX.'session'; }
	public function getClassName() { return __CLASS__; }
	public function getColumnDefines()
	{
		return array(
			'sess_id' => array(GDO::AUTO_INCREMENT),
			'sess_sid' => self::gdoDefine(GDO::INDEX),
			'sess_user' => array(GDO::OBJECT|GDO::INDEX, GDO::NULL, array('GWF_User', 'sess_user', 'user_id')),
//			'sess_user' => array(GDO::UINT|GDO::INDEX, 0),
			'sess_data' => array(GDO::BLOB),
			'sess_time' => array(GDO::UINT|GDO::INDEX),
			'sess_ip' => GWF_IP6::gdoDefine(GWF_IP_EXACT, GDO::NULL),
			'sess_lasturl' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 255),
			'user' => array(GDO::JOIN, 0, array('GWF_User', 'sess_user', 'user_id')),
		);
	}
	public static function gdoDefine($flags=0) { return array(GDO::TOKEN|$flags, GDO::NOT_NULL, self::SESS_ENTROPY); }

	/**
	 * @return GWF_User
	 */
	public static function getUser() { return self::$USER; }
	public static function getSessID() { return self::$SESSION->getVar('sess_sid'); }
	public static function getSession() { return self::$SESSION; }
	public static function haveCookies() { return self::$SESSION !== NULL; }
	public static function set($var, $value) { self::$SESSDATA[$var] = $value; }
	public static function exists($var) { return isset(self::$SESSDATA[$var]); }
	public static function remove($var) { unset(self::$SESSDATA[$var]); }
	public static function &get($var) { return self::$SESSDATA[$var]; }
	public static function getOrDefault($var, $default=false) { return isset(self::$SESSDATA[$var]) ? self::$SESSDATA[$var] : $default; }
	public static function getLastURL() { return self::$SESSION->getVar('sess_lasturl'); }
	public static function getCurrentURL() { return isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI']; }
	public static function getUserID() { return self::$USER === false ? '0' : self::$USER->getID(); }
	public static function isLoggedIn() { return self::$USER !== false; }
	############
	### Init ###
	############
	public static function start($blocking=true)
	{
		if ( (NULL === ($cookie = Common::getCookie(GWF_SESS_NAME)))
		  || (!self::reload($cookie, $blocking)) )
		{
			return self::create();
		}
		return true;
	}
	
	private static function reload($cookie, $blocking)
	{
		$split = explode('-', $cookie);
		if (count($split) !== 3) {
			die('WRONG COUNT: '.count($split).' :'.$cookie);
			return false;
		}
		$id = (int)$split[0];
		
		
		if (false === ($session = GDO::table(__CLASS__)->selectFirstObject('*', "sess_id=$id"))) {
			return false;
		}
		$user = $session->getVar('sess_user');
		# Check UID
		if ( ($user->getID() !== NULL) && ($user->getID() !== $split[1]) ) {
			return false;
		}
		
		# Check SESSID
		if ($session->getVar('sess_sid') !== $split[2]) {
			return false;
		}
		
		if (NULL !== ($ip = $session->getVar('sess_ip')))
		{
			if (GWF_IP6::getIP(GWF_IP_EXACT) !== $ip)
			{
				return false;
			}
		}
		
		# Lock if logged in and blocking is enabled.
		if ( ($user->getID() > 0) && ($blocking) && (false === ($session->lock('GWF_SESS_'.$user->getID()))) )
		{
			die('The server is currently very busy. (or your cookie is broken)');
		}
		
		
		$session->setVar('sess_time', time()-1);
		
		self::$SESSION = $session;
		
		self::$SESSDATA = self::reloadSessData($session->getVar('sess_data'));
		
		if ($user->getID() > 0)
		{
			self::$USER = $user;
		}
		
		return true;
	}
	
	private static function reloadSessData($data)
	{
		if ($data === NULL) {
			return array();
		}
		return unserialize($data);
	}

	private static function create()
	{
		if (false !== ($spider = GWF_Webspider::getSpider()))
		{
			return self::createSpider($spider);
		}
		
//		return self::createByETag();
		return self::createSession();
	}
	
//	private static function createByETag()
//	{
//		# Reload by ETag
//		if (isset($_SERVER['HTTP_IF_NONE_MATCH']))
//		{
//			if (self::reload(substr($_SERVER['HTTP_IF_NONE_MATCH'], 2)))
//			{
//				self::setETag(self::$SESSION->getID(), self::getUserID(), self::getSessID());
//				return true;
//			}
//		}
//		
//		return self::createSession(true);
//	}
	
	private static function createSession($create_etag=false)
	{
		$sessid = Common::randomKey(self::SESS_ENTROPY);
		
		$session = new self(array(
			'sess_id' => 0,
			'sess_sid' => $sessid,
			'sess_user' => NULL,
			'sess_data' => NULL,
			'sess_time' => time(),
			'sess_ip' => NULL,
			'sess_lasturl' => NULL,
		));
		if (false === $session->insert())
		{
			return false;
		}
		
		self::$SESSION = $session;
		
//		if ($create_etag)
//		{
//			self::setETag($session->getVar('sess_id'), 0, $sessid);
//		}
		
		self::setCookies($session->getVar('sess_id'), 0, $sessid);
		
		return true;
	}
	
//	private static function setETag($id, $uid, $sessid)
//	{
//		header('Etag: '.sprintf('W/%s-%s-%s', $id, $uid, $sessid));
//	}
	
	private static function createSpider($spiderid)
	{
		$table = self::table(__CLASS__);
		if (false === ($session = $table->getBy('sess_sid', $spiderid, GDO::ARRAY_O, array('user'))))
		{
			$session = new self(array(
				'sess_id' => 0,
				'sess_sid' => $spiderid,
				'sess_user' => $spiderid,
				'sess_data' => '',
				'sess_time' => time(),
				'sess_ip' => NULL,
				'sess_lasturl' => '',
			));
			if (false === $session->insert()) {
				return false;
			}
		}
		
		$spider = GWF_User::getByID($spiderid);
//		$session->setVar('sess_user', $spider);
		self::$USER = $spider;
		self::$SESSION = $session;
		self::$SESSDATA = array();
//		self::setCookies($session->getVar('sess_id'), $spiderid, $spiderid);
		
		return true;
	}
	
	
	public static function setCookies($id, $uid, $sessid)
	{
		if (isset($_SERVER['REMOTE_ADDR']))
		{
			# cookie is valid one year, but it's checked against config later.
			if (isset($_SERVER['HTTP_HOST']))
			{
				$domain = (strpos($_SERVER['HTTP_HOST'], GWF_DOMAIN) === false) ? $_SERVER['HTTP_HOST'] : '.'.GWF_DOMAIN;
			}
			else
			{
				$domain = '.'.GWF_DOMAIN;
			}
			$secure = Common::getProtocol() === 'https';
			setcookie(GWF_SESS_NAME, "$id-$uid-$sessid", time()+31536000, GWF_WEB_ROOT_NO_LANG, $domain, $secure, true);
		}
	}
	
	##############
	### Commit ###
	##############
	/**
	 * Commit the session data.
	 * @param boolean $store_last_url
	 */
	public static function commit($store_last_url=true)
	{
		$data = array();
		
		# Save new sess last activity time
		if (self::$SESSION->getInt('sess_time') < time())
		{
			$data['sess_time'] = time();
		}
		
		# Save new last url
		if ( $store_last_url && (!isset($_GET['ajax'])) )
		{
			$data['sess_lasturl'] = self::getCurrentURL();
		}
		
		# Save new session data
		$serialized = serialize(self::$SESSDATA);
		if ($serialized !== self::$SESSION->getVar('sess_data'))
		{
			$data['sess_data'] = $serialized;
		}
		
		# Save it
		return count($data) === 0 ? true : self::$SESSION->saveVars($data);
	}
	
	#############
	### Login ###
	#############
	public static function onLogin(GWF_User $user, $bind_to_ip=true, $with_hooks=true)
	{
		$userid = $user->getID();

		# Keep only N sessions for one user
		if (false === ($result = self::$SESSION->selectFirst('MIN(sess_id) min', "sess_user=$userid", 'sess_id DESC', NULL, self::ARRAY_N, GWF_SESS_PER_USER)))
		{
			$cut_id = '1';#return false;
		} else {
			$cut_id = $result[0];
		}
		
		if (false === self::$SESSION->deleteWhere("sess_user=$userid AND sess_id<$cut_id"))
		{
			return false;
		}
		
		# Update session 
		$data = array('sess_user' => $userid);
		if ($bind_to_ip)
		{
			$data['sess_ip'] = GWF_IP6::getIP(GWF_IP_EXACT);
		}
		if (false === self::$SESSION->saveVars($data))
		{
			return false;
		}
		self::$SESSION->setVar('sess_user', $user);
		
		# Set cookies
		self::setCookies(self::$SESSION->getVar('sess_id'), $userid, self::$SESSION->getVar('sess_sid'));
		self::$USER = $user;

		# Call hooks
		return $with_hooks ? GWF_Hook::call(GWF_Hook::LOGIN, $user) : true;
	}
	
	public static function onLogout()
	{
		if (self::$USER === false) {
			return true;
		}
		
		GWF_Hook::call(GWF_HOOK::LOGOUT, self::$USER);
		
		if (self::$USER->isWebspider())
		{
			self::$USER = false;
			return self::createSession();
		}
		
		# Mark the session to be recreated as human
//		if (self::$USER->isWebspider())
//		{
//			self::create();
//			self::setCookies($id, $uid, $sessid)$webspider_killer = true;
//		}
		
		self::$USER = false;
		
		if (false === self::$SESSION->saveVars(array(
			'sess_user' => 0,
		))) {
			return false;
		}
		
		self::$SESSION->setVar('sess_user', GWF_Guest::getGuest());
		
		return true;
	}
	
	public static function getOnlineSessions()
	{
		$cut = time() - GWF_ONLINE_TIMEOUT;
		$sid = self::$SESSION->getSessID();
		return array_merge(array(self::$SESSION), self::table(__CLASS__)->selectObjects('*', "sess_time>{$cut} AND sess_sid!='{$sid}'"));
	}
}
?>