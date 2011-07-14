<?php

define('GWF_DEBUG_TIME_START', microtime(true));
define('GWF_CORE_VERSION', '3.02-2011.JUL.14');

/**
 * Welcome to
 * Space & Gizmore Website Framework
 * @author spaceone
 * @version 1.00
 * @since 14.07.2011
 */
final class GWF
{
	/**
	 * This is always required!
	 */
	public static function _init()
	{
		define('GWF_PATH', __DIR__.'/');
		define('GWF_CORE_PATH', GWF_PATH.'core/');
		
		# Require the Database
		require_once GWF_CORE_PATH.'inc/GDO/GDO.php';

		# Require the util
		require_once GWF_CORE_PATH.'inc/util/Common.php';

		# The GWF autoloader
		spl_autoload_register(array('GWF','onAutoloadClass'));
	
		Common::defineConst('GWF_DEFAULT_PROTECTED_PATH', GWF_PATH.'protected/');
		Common::defineConst('GWF_DEFAULT_CONFIG_PATH', GWF_DEFAULT_PROTECTED_PATH.'config.php'); // This could also the path for the example file, use it for installation-script!
		Common::defineConst('GWF_DEFAULT_LOGGING_PATH', GWF_DEFAULT_PROTECTED_PATH.'logs'); // without trailing slash
	}
	
	/**
	 * This will be required for a new GWF3() Instance.
	 * It will be called there!
	 */
	private static $_instance = false;
	public static function init($basepath, $configpath, $loggingpath, $blocking=true, $no_session=false) 
	{
		# Actions already done?
		if(true === self::$_instance) return;
		
		# Important definements
		Common::defineConst('GWF_WWW_PATH', $basepath);

		# Enable the error handlers
		GWF_Debug::enableErrorHandler();
		
		# Load the Config
		self::onLoadConfig($configpath);
		
		# Start Logging
		if (false === self::onStartLogging($loggingpath, $blocking, $no_session))
		{
			return false;
		}
		
		# Set valid mo/me
		$_GET['mo'] = Common::defineConst('GWF_MODULE', Common::getGetString('mo', GWF_DEFAULT_MODULE));
		$_GET['me'] = Common::defineConst('GWF_METHOD', Common::getGetString('me', GWF_DEFAULT_METHOD));

		self::$_instance = true;
		return true;
	}
	public static function onAutoloadClass($classname, $prefix='GWF_')
	{
		if (substr($classname, 0, 4) === $prefix)
		{
			require_once GWF_CORE_PATH.'inc/util/'.$classname.'.php';
		}
	}
	public static function onLoadConfig($config=GWF_DEFAULT_CONFIG_PATH) 
	{
		$config = Common::defineConst('GWF_CONFIG_PATH', $config);

		# Get the config
		if (!defined('GWF_HAVE_CONFIG'))
		{
			if(!file_exists($config))
			{			
				if(!file_exists(GWF_DEFAULT_CONFIG_PATH)) {
					die('GWF3 couldnt load the config: file doesnt exists.');
				} else {
					$config = GWF_DEFAULT_CONFIG_PATH;
					// REPORT THAT ACTION WITH EMAIL ?!
				}
			}
			require_once $config;
			define('GWF_HAVE_CONFIG', 1);
			self::onDefineWebRoot();
		}
	}
	public static function onDefineWebRoot() 
	{
		# Web Root
		$root = GWF_WEB_ROOT_NO_LANG;
		if (isset($_SERVER['REQUEST_URI'])) # Non CLI?
		{
			if (preg_match('#^'.GWF_WEB_ROOT_NO_LANG.'([a-z]{2})/#', $_SERVER['REQUEST_URI'], $matches)) # Match lang from url.
			{
				if (strpos(';'.GWF_SUPPORTED_LANGS.';', $matches[1]) !== false)
				{
					$root .= $matches[1].'/'; # web_root is lang extended
				}
			}
		}
		// User can decide for his instance
		Common::defineConst('GWF_WEB_ROOT', $root);
	}
	public static function onStartLogging($logpath=GWF_DEFAULT_LOGGING_PATH, $blocking=true, $no_session=false)
	{
		$logpath = Common::defineConst('GWF_LOGGING_PATH', $logpath);
		
		$username = false;
		if (!$no_session)
		{
			if (!GWF_Session::start($blocking))
			{
				return false; # Not installed
			}
			if (false !== ($user = GWF_Session::getUser()))
			{
				$username = $user->getVar('user_name');
			}
		}
		GWF_Log::init($username, true, $logpath);
		
	}
}

/**
 * @author spaceone
 * @version 1.02
 * @since 01.07.2011
 * @todo check if Session commit works
 * @todo better GWF_WEBSITE_DOWN
 * @todo disable logging for an instance
 */
class GWF3 
{
	public static $CONFIG = array(
		'website_init' => true,
		'autoload_modules' => true,
		'load_module' => true,
		'get_user' => true,
		'config_path' => GWF_DEFAULT_CONFIG_PATH,
		'logging_path' => GWF_DEFAULT_LOGGING_PATH,
//		'do_logging' => true,
		'blocking' => true,
		'no_session' => false
	);
	
	private static $me = '';
	private static $module, $page, $user;

	/**
	 * @param array $config
	 * @param $basepath = __DIR__
	 * @return GWF3 
	 */
	public function __construct($basepath, array $config = array())
	{
		$config = array_merge(self::$CONFIG, $config);

		if (false === GWF::init($basepath, $config['config_path'], $config['logging_path'], $config['blocking'], $config['no_session']) 
			&& !defined('GWF_INSTALLATION')	)
		{			
			die('GWF Initialisation: GWF not installed?!');
		}
		if ($config['website_init']) 
		{ 
			$this->onInit($basepath); 
		}
		if ($config['autoload_modules']) 
		{ 
			$this->onAutoloadModules(); 
		}
		if ($config['load_module']) 
		{ 
			$this->onLoadModule(); 
		}
		if ($config['get_user']) 
		{		
			GWF_Template::addMainTvars(array('user' => (self::$user = GWF_User::getStaticOrGuest()) ));
		}
	}
	public function __destruct() 
	{
		$this->onSessionCommit();
	}
	// this function is maybe senseless now... it cant return false?!
	public function onInit() 
	{
		# Init core
		if (false === GWF_Website::init()) {
			die('GWF3 does not seem to be installed properly.');
		}
		return $this;
	}
	public function onAutoloadModules()
	{
		if(defined('GWF_WEBSITE_DOWN')) return;
		# Autoload Modules
		if (false === GWF_Module::autoloadModules()) {
			die('Cannot autoload modules. GWF not installed?');
		}
		return $this;
	}
	public function onLoadModule()
	{
		if(defined('GWF_WEBSITE_DOWN')) return;
		# Load the module
		if (false === (self::$module = GWF_Module::loadModuleDB(GWF_MODULE))) 
		{
			if (false === (self::$module = GWF_Module::loadModuleDB(GWF_DEFAULT_MODULE))) 
			{
				die('No module found.');
			}
			// add Module::defaultMethod(); !!!!!!!!!!!!!! check if method exists
			// good for performance!
			self::$me = GWF_DEFAULT_METHOD; //IMPORTANT
		}
		else 
		{
			self::$me = GWF_METHOD;
		}

		if (self::$module->isEnabled())
		{
			# Execute the method
			self::$module->onInclude();
			self::$module->onLoadLanguage();
			self::$page = self::$module->execute(self::$me);
			if (isset($_GET['ajax']))
			{
				self::$page = GWF_Website::getDefaultOutput().self::$page;
			}
		}
		else
		{
			self::$page = GWF_HTML::err('ERR_MODULE_DISABLED', array(self::$module->display('module_name')));
		}
		return $this;

	}

	public function onSessionCommit($store_last_url=true) 
	{
		# Commit the session
		if (false !== ($user = GWF_Session::getUser())) {
			$user->saveVar('user_lastactivity', time());
		}
		GWF_Session::commit($store_last_url);
		return $this;
	}
	public function onDisplayPage($content = NULL)
	{
		if(defined('GWF_WEBSITE_DOWN')) return GWF_WEBSITE_DOWN;
		# Display the page
		if (isset($_GET['ajax'])) {
			return self::$page;
		} else {
			$page = $content === NULL ? self::$page : $content;
			return GWF_Website::displayPage($page);
		}
	}
	public static function onDisplayHead($path = 'tpl/%DESIGN%/') 
	{
		return GWF_Website::getPagehead($path);
	}
	public static function onDisplayFoot($path = 'tpl/%DESIGN%/')
	{
		return GWF_Website::getHTMLbody_foot($path);
	}
	public static function getMo() { return GWF_MODULE; }
	public static function getMe() { return self::$me; }
	public static function getModule() { return self::$module; }
	public static function getUser() { return self::$user; }
	
	public function __toString() {
		$module = Common::displayGet('mo', GWF_DEFAULT_MODULE);
		$method = Common::displayGet('me', GWF_DEFAULT_METHOD);
		$class = sprintf('<a href="%s" title="%s">%s</a>', GWF_WEB_ROOT, GWF_HTML::lang(__CLASS__), GWF_HTML::lang(__CLASS__));
		$method = sprintf('<a href="%s" title="%s">%s</a>', GWF_WEB_ROOT.'index.php?mo='.$module.'&amp;me='.$method, $method, $method);
		$module = sprintf('<a href="%s" title="%s">%s</a>', GWF_WEB_ROOT.'index.php?mo='.$module, $module, $module);

		return $class.' &gt;&gt; '.$module.' &gt; '.$method;
	}
}

GWF::_init();