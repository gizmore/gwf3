<?php
/**
 * GWF Session Handler. It's database driven, and queries a bot database to detect bots by IP.
 * @author gizmore
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
	
 	public function isOnline() { return $this->getVar('sess_time') > (time() - GWF_ONLINE_TIMEOUT); }
	
	public static function gdoDefine($flags=0) { return array(GDO::TOKEN|$flags, GDO::NOT_NULL, self::SESS_ENTROPY); }

	/**
	 * @return GWF_User
	 */
	public static function getUser() { return self::$USER; }
	public static function getSessID() { return self::$SESSION->getVar('sess_sid'); }
	public static function getSessSID() { return self::$SESSION->getVar('sess_id'); }
	public static function getSession() { return self::$SESSION; }
	public static function haveCookies() { return self::getSessSID() > 0; }
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
		if ( (false === ($cookie = Common::getCookieString(GWF_SESS_NAME)))
		  || (false === self::reload($cookie, $blocking)) )
		{
			return self::create();
		}
		return true;
	}
	
	public static function initFakeSession()
	{
		self::$SESSDATA = array();
		self::$SESSION = new self(array(
			'sess_id' => '0',
			'sess_sid' => 'xxxx_gwf3_nope_sess',
			'sess_user' => NULL,
			'sess_data' => NULL,
			'sess_time' => time(),
			'sess_ip' => NULL,
			'sess_lasturl' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : GWF_WEB_ROOT,
			'sessioncount' => 1,
		));
	}
	
	private static function reload($cookie, $blocking)
	{
		$split = explode('-', $cookie);
		if (count($split) !== 3)
		{
// 			die('WRONG COUNT: '.count($split).' :'.htmlspecialchars($cookie));
			return false;
		}
		$id = (int)$split[0];
		
		# Load session from DB
		if (false === ($session = GDO::table(__CLASS__)->selectFirstObject('*', 'sess_id='.$id)))
		{
			return false;
		}
		
		# Check UID
		$user = $session->getVar('sess_user');
		if ( ($user->getID() !== NULL) && ($user->getID() !== $split[1]) )
		{
			return false;
		}
		
		# Check SESSID
		if ($session->getVar('sess_sid') !== $split[2])
		{
			return false;
		}
		
		if (NULL !== ($ip = $session->getVar('sess_ip')))
		{
			if (GWF_IP6::getIP(GWF_IP_EXACT) !== $ip)
			{
				return false;
			}
		}
		
		# Lock the session if blocking.
		if ( ($blocking) && (!$session->lock('GWF_SESS_'.$session->getVar('sess_id'))) )
		{
			self::initFakeSession();
			die('Your session is still executing another page. You may delete your cookie to create a new session.');
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
		return $data === NULL ? array() : unserialize($data);
	}

	private static function create()
	{
// 		if (false !== ($spider = GWF_Webspider::getSpider()))
// 		{
// 			return self::createSpider($spider);
// 		}
		
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
		$sessid = GWF_Random::randomKey(self::SESS_ENTROPY);
		
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
	
	public static function getDomain()
	{
		if (isset($_SERVER['HTTP_HOST']))
		{
			return (strpos($_SERVER['HTTP_HOST'], GWF_DOMAIN) === false) ? $_SERVER['HTTP_HOST'] : '.'.GWF_DOMAIN;
		}
		else
		{
			return '.'.GWF_DOMAIN;
		}
	}
	
	private static function setCookies($id, $uid, $sessid)
	{
		if (isset($_SERVER['REMOTE_ADDR']))
		{
			# cookie is valid one year, but it's checked against config later.
//			$secure = Common::getProtocol() === 'https';
			$secure = false;
			setcookie(GWF_SESS_NAME, "$id-$uid-$sessid", time()+31536000, GWF_WEB_ROOT_NO_LANG, self::getDomain(), $secure, true);
		}
	}
	
	public static function getCookieValue()
	{
		$id = self::getSessSID();
		$uid = self::$USER ? self::$USER->getID() : 0;
		$sid = self::getSessID();
		return $id."-".$uid.'-'.$sid;
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
		if (!self::haveCookies())
		{
			return false;
		}
		
		$data = array();
		
		# Save new sess last activity time
		if (self::$SESSION->getInt('sess_time') < time())
		{
			$data['sess_time'] = time();
		}
		
		# Save new last url
		if ( $store_last_url && (false === isset($_GET['ajax'])) )
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
		if (false === ($result = self::$SESSION->selectFirst('sess_id min', "sess_user=$userid", 'sess_id DESC', NULL, self::ARRAY_N, GWF_SESS_PER_USER-1)))
		{
			$cut_id = '1';#return false;
		}
		else
		{
			$cut_id = $result[0];
		}
		
		if (false === self::$SESSION->deleteWhere("sess_user=$userid AND sess_id<$cut_id"))
		{
			GWF_HTML::err(ERR_DATABASE, array(__FILE__, __LINE__));
			return false;
		}
		
		# Update session 
		if (!self::$SESSION->saveVars(array(
			'sess_user' => $userid,
			'sess_ip' => $bind_to_ip ? GWF_IP6::getIP(GWF_IP_EXACT) : null,
		)))
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
		if (self::$USER === false)
		{
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
			'sess_ip' => null, # thx dloser
		))) {
			return false;
		}
		
		self::$SESSION->setVar('sess_user', GWF_Guest::getGuest());
		
		return true;
	}
	
	public static function getOnlineSessions()
	{
// 		var_dump('getSess', self::$SESSION);
		$cut = time() - GWF_ONLINE_TIMEOUT;
		$sid = self::$SESSION->getSessSID();
// 		return array_merge(array(self::$SESSION), self::table(__CLASS__)->selectObjects('*, COUNT(*) as num_online', "sess_time>{$cut} AND sess_sid!='{$sid}'", 'user_name ASC', -1, -1, 'sess_user'));
		$sessions = self::table(__CLASS__)->selectObjects('*, COUNT(1) as sessioncount', "sess_time>{$cut} OR sess_id={$sid}", 'user_name ASC', -1, -1, 'sess_user');
		if (!self::haveCookies()) # || !self::$SESSION->isOnline())
		{
			$sessions = array_merge(array(self::$SESSION), $sessions);
		}
		return $sessions;
	}
}
?>
