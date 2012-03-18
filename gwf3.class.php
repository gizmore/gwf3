<?php
define('GWF_DEBUG_TIME_START', microtime(true));
define('GWF_CORE_VERSION', '3.03-2011.Dec.24');

/**
 * Welcome to GWF3
 * @author spaceone <space@wechall.net>
 * @author gizmore <gizmore@gizmore.org>
 * @version 1.04
 * @since 01.07.2011
 * @todo better design handling
 */
class GWF3 
{
	private static $DESIGN = 'default';
	private static $MODULE, $page, $user;
	private static $CONFIG = array(
		'init' => true, # Init?
		'bootstrap' => false, # Init GWF_Bootstrap?
		'website_init' => true, # Init GWF_Website?
		'autoload_modules' => true, # Load modules with autoload flag?
		'load_module' => true, # Load the requested module?
		'load_config' => false, # Load the config file? (DEPRECATED) # TODO: REMOVE
		'start_debug' => true, # Init GWF_Debug?
		'get_user' => true, # Put user into smarty templates?
		'do_logging' => true, # Init the logger?
		'log_request' => true, # Log the request?
		'blocking' => true, # Lock the database, so we can request only one page by one?
		'no_session' => false, # Suppress session creation?
		'store_last_url' => true, # Save the current URL into session?
		'ignore_user_abort' => true, # Ignore abort and continue the script on browser kill?
		'kick_banned_ip' => true, # Kick banned IP adress by temp_ban file?
	);
	public static function setConfig($key, $v) { self::$CONFIG[$key] = $v; }
	public static function getConfig($key) { return self::$CONFIG[$key]; }
 	
	/**
	 * @param array $config
	 * @param string $basepath = dirname(__FILE__)
	 * $basepath is the GWF_WWW_PATH without trailing slash 
	 * @return GWF3 
	 */
	public function __construct($basepath, array $config = array())
	{
		self::$CONFIG = ($config = array_merge(self::$CONFIG, $config));

		# Bootstrap
		if (true === $config['bootstrap'])
		{
			GWF_Bootstrap::init();
		}
		
		# Windows patch
//		if (GWF_ServerInfo::isWindows())
//		{
// 			$basepath = str_replace('\\', '/', $basepath);
//		}
		
		# Important definements...
		Common::defineConst('GWF_WWW_PATH', $basepath.'/');
		Common::defineConst('GWF_PROTECTED_PATH', GWF_WWW_PATH.'protected/');
		Common::defineConst('GWF_CONFIG_PATH', GWF_PROTECTED_PATH.'config.php');
		Common::defineConst('GWF_LOGGING_PATH', GWF_PROTECTED_PATH.'logs');

		# Load config
		if (true === $config['load_config'])
		{
			$this->onLoadConfig(GWF_CONFIG_PATH);
		}

		# WebSite is down?
		if (true === defined('GWF_WORKER_IP'))
		{
			if (GWF_WORKER_IP !== (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''))
			{
				die(GWF_SITENAME.' is down for maintainance.<br/>'.GWF_DOWN_REASON);
			}
			else
			{
				GWF_Website::addDefaultOutput('<p style="color: #ff0000">Welcome back Admin! GWF_WORKER_IP is activated</p>');
			}
		}
		
		$db = gdo_db();
	
		# Set valid mo/me
		$_GET['mo'] = Common::getGetString('mo', GWF_DEFAULT_MODULE);
		$_GET['me'] = Common::getGetString('me', GWF_DEFAULT_METHOD);
		
		# Setting the Design... TODO...
		self::setDesign(Common::getConst('GWF_DEFAULT_DESIGN', 'default'));

		# abort script execution on user disconnect?
		ignore_user_abort($config['ignore_user_abort']);

		# define GWF_WEB_ROOT
		self::onDefineWebRoot();

		# Init the config?
		if (true === $config['init'])
		{
			$this->init();
		}

		return $this;
	}

	/**
	 * Initialize by ConfigOptions
	 * @return GWF3 
	 */
	public function init()
	{
		if (true === defined('GWF_WEBSITE_DOWN'))
		{
			$this->setConfig('load_module', false);
			$this->setConfig('autoload_modules', false);
			# log_request ?
		}

		$config = &self::$CONFIG;

		if (true === $config['kick_banned_ip'])
		{
			$this->onKickBannedIP();
		}

		if (true === $config['start_debug'])
		{
			GWF_Debug::enableErrorHandler();
			GWF_Debug::setMailOnError((GWF_DEBUG_EMAIL & 2) > 0);
		}
			
		if (false === $config['no_session'])
		{
			$this->onStartSession($config['blocking']);
		}
		
		if (true === $config['website_init']) 
		{ 
			GWF_Website::init();
		}
		
		if (true === $config['do_logging'])
		{
			$this->onStartLogging($config['no_session']);
		}
		
		if (true === $config['autoload_modules']) 
		{ 
			$this->onAutoloadModules(); 
		}
		
		if (true === $config['get_user'])
		{		
			GWF_Template::addMainTvars(array('user' => (self::$user = GWF_User::getStaticOrGuest())));
		}
		
		if (true === $config['load_module']) 
		{ 
			$this->onLoadModule(); 
		}

		if (true === defined('GWF_WEBSITE_DOWN'))
		{
			die( $this->onDisplayPage(GWF_WEBSITE_DOWN) );
		}

		return $this;
	}

	/**
	 * commits the session if allowed
	 * @return NULL
	 */
	public function __destruct() 
	{
		# Commit Session
		if (false === self::getConfig('no_session'))
		{
			$this->onSessionCommit(self::getConfig('store_last_url'));
		}

		# Flush logfiles
		if (true === self::getConfig('do_logging'))
		{
			GWF_Log::flush();
		}
	}
		
	/**
	 * This is always required!
	 * We include all basic required files here. (optimize?)
	 * GWF_PATH will be defined here
	 */
	public static function _init()
	{
		# The GWF autoloader
		spl_autoload_register(array(__CLASS__, 'onAutoloadClass'));
		
		# Require the util/Common.php
		require_once 'core/inc/util/Common.php';
		
//		$path = dirname(__FILE__).'/';		
//		if (true === GWF_ServerInfo::isWindows()) // replace by original code!?
//		{
//			$path = str_replace('\\', '/', $path); # Windows patch
//		}

		# Default defines
		define('GWF_PATH', dirname(__FILE__).'/');
		define('GWF_EXTRA_PATH', GWF_PATH.'extra/');
		define('GWF_CORE_PATH', GWF_PATH.'core/');
	
		# Require the database
		require_once GWF_CORE_PATH.'inc/GDO/GDO.php';
	}

	/**
	 * Log a message as critical, then die()
	 * @return NULL 
	 */
	public static function logDie($msg='')
	{
		if (true === self::getConfig('do_logging'))
		{
			GWF_Log::logCritical($msg);
		}
		die(htmlspecialchars($msg));
	}

	/**
	 * require an inc/util/ class
	 * This is used by the GWF_AutoLoader
	 * @param string $classname 
	 */
	public static function onAutoloadClass($classname)
	{
		if (strpos($classname, 'GWF_') === 0)
		{
			require_once GWF_CORE_PATH.'inc/util/'.$classname.'.php';
		}
	}
	
	/**
	 * Load a config file.
	 * @deprecated
	 * @param string $config
	 */
	public static function onLoadConfig($config='protected/config.php') 
	{
		# Get the config
		if (false === defined('GWF_HAVE_CONFIG'))
		{
			if (false === file_exists($config))
			{			
				self::logDie('GWF3 couldnt load the config: '.$config.'file doesnt exists. Message in '.__FILE__.' at line'.__LINE__);
			}
			require_once $config;
			define('GWF_HAVE_CONFIG', 1);
		}
	}

	/**
	 * Kick Client if he has a banned IP
	 * IPs from protected/temp_ban.lst.txt file
	 * You can ban webspider IPs
	 */
	public static function onKickBannedIP()
	{
		if (false === isset($_SERVER['REMOTE_ADDR']))
		{
			return true;
		}
		$path = GWF_PROTECTED_PATH.'temp_ban.lst.txt';
		if (false === Common::isFile($path))
		{
			return false;
		}

		if ('' === ($bans = file_get_contents($path)))
		{
			return true;
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		$bans = explode("\n", $bans);
		foreach ($bans as $i => $ban)
		{
			$ban = explode(':', $ban);
			if (count($ban) === 2)
			{
				if ($ban[1] === $ip && $ban[0] > time())
				{
					die('You are banned until '.date('Y-m-d H:i:s', $ban[0]).'+UGZ.');
					return true;
				}
			}
		}
	}

	/**
	 * define the GWF_WEB_ROOT
	 * @return NULL
	 */
	public static function onDefineWebRoot() 
	{
		# Web Root
		$root = GWF_WEB_ROOT_NO_LANG;
		if (true === isset($_SERVER['REQUEST_URI'])) # Non CLI?
		{
			if (preg_match('#^'.GWF_WEB_ROOT_NO_LANG.'([a-z]{2})/#', $_SERVER['REQUEST_URI'], $matches)) # Match lang from url.
			{
				if (strpos(';'.GWF_SUPPORTED_LANGS.';', $matches[1]) !== false)
				{
					$root .= $matches[1].'/'; # web_root is lang extended
				}
			}
		}
		# You can pre define your GWF_WEB_ROOT
		Common::defineConst('GWF_WEB_ROOT', $root);
	}

	/**
	 * start a SQL based Session 
	 * @param boolean $blocking 
	 */
	public static function onStartSession($blocking=true)
	{
		if (false === GWF_Session::start($blocking))
		{
			self::logDie('GWF not installed?!');
		}
	}

	/**
	 * Initialize the GWF_Log
	 * @param boolean $no_session 
	 */
	public static function onStartLogging($no_session=false)
	{
		$username = false;
		if (false === $no_session)
		{
			if (false !== ($user = GWF_Session::getUser()))
			{
				$username = $user->getVar('user_name');
			}
		}
		GWF_Log::init($username, GWF_LOG_BITS, GWF_LOGGING_PATH);
	}

	/**
	 * Load modules which are autoload flagged 
	 * @return GWF3 
	 */
	public function onAutoloadModules()
	{
		# Autoload Modules
		if (false === GWF_Module::autoloadModules())
		{
			self::logDie('Can not autoload modules. GWF not installed OR problems with database?');
		}
		return $this;
	}

	/**
	 * Load the $_GET['mo'] or GWF_DEFAULT_MODULE and execute it
	 * @return GWF3 
	 */
	public function onLoadModule()
	{
		# Load the module
		if (false === (self::$MODULE = GWF_Module::loadModuleDB($_GET['mo']))) 
		{
			if (false === (self::$MODULE = GWF_Module::loadModuleDB(GWF_DEFAULT_MODULE))) 
			{
				self::logDie('No module found.');
			}
			$_GET['me'] = GWF_DEFAULT_METHOD;
		}

		# Module is enabled?
		if (true === self::$MODULE->isEnabled())
		{
			# Execute the method
			self::$MODULE->onInclude();
			self::$MODULE->onLoadLanguage();
			self::$page = self::$MODULE->execute($_GET['me']);
			if (true === isset($_GET['ajax']))
			{
				self::$page = GWF_Website::getDefaultOutput().self::$page;
			}
		}
		else
		{
			self::$page = GWF_HTML::err('ERR_MODULE_DISABLED', array(self::$MODULE->display('module_name')));
		}
		return $this;
	}

	/**
	 * Commit the Session
	 * @param type $store_last_url
	 * @return GWF3 
	 */
	public function onSessionCommit($store_last_url=true) 
	{
		# Commit the session
		if (false !== ($user = GWF_Session::getUser()))
		{
			$user->saveVar('user_lastactivity', time());
		}
		GWF_Session::commit($store_last_url);
		return $this;
	}

	/**
	 * Display the page with layout
	 * If ajax is enabled it returns only the module content
	 * @param string|NULL $content replace page content
	 * @return string
	 */
	public function onDisplayPage($content=NULL)
	{
		if ((true === self::getConfig('log_request')) && (class_exists('GWF_Log')))
		{
			GWF_Log::logRequest();
		}
		
		# Display the page
		if (true === isset($_GET['ajax']))
		{
			GWF_Website::plaintext();
			return self::$page;
		}
		else
		{
			$page = $content === NULL ? self::$page : $content;
			return GWF_Website::displayPage($page);
		}
	}

	/**
	 * Display the template head
	 * @return string
	 */
	public static function onDisplayHead() 
	{
		return GWF_Website::getPagehead();
	}

	/**
	 * Display the template foot
	 * @return string
	 */
	public static function onDisplayFoot()
	{
		return GWF_Website::getHTMLbody_foot();
	}

	public static function getModule() { return self::$MODULE; }
	public static function getUser() { return self::$user; }
	public static function setDesign($design) { self::$DESIGN = $design; }
	public static function getDesign() { return self::$DESIGN; }
	
	public function __toString()
	{
		$module = Common::displayGet('mo', GWF_DEFAULT_MODULE);
		$method = Common::displayGet('me', GWF_DEFAULT_METHOD);
		$class = sprintf('<a href="%s" title="%s">%s</a>', GWF_WEB_ROOT, GWF_HTML::lang(__CLASS__), GWF_HTML::lang(__CLASS__));
		$method = sprintf('<a href="%s" title="%s">%s</a>', GWF_WEB_ROOT.'index.php?mo='.$module.'&amp;me='.$method, $method, $method);
		$module = sprintf('<a href="%s" title="%s">%s</a>', GWF_WEB_ROOT.'index.php?mo='.$module, $module, $module);
		return $class.' &gt;&gt; '.$module.' &gt; '.$method;
	}
}

GWF3::_init();
?>
