<?php
define('GWF_DEBUG_TIME_START', microtime(true));
define('GWF_CORE_VERSION', '3.02-2011.Aug.28');

/**
 * Welcome to GWF3
 * @author spaceone, gizmore
 * @version 1.03
 * @since 01.07.2011
 * @todo better GWF_WEBSITE_DOWN
 */
class GWF3 
{
	private static $design = 'default';
	private static $module, $page, $user;
	public static $CONFIG = array(
		'website_init' => true,
		'autoload_modules' => true,
		'load_module' => true,
		'load_config' => false,
		'start_debug' => true,
		'get_user' => true,
		'do_logging' => true,
		'blocking' => true,
		'no_session' => false,
		'store_last_url' => true,
		'ignore_user_abort' => true,
	);
	public static function setConfig($key, $v) { self::$CONFIG[$key] = $v; }
	public static function getConfig($key) { return self::$CONFIG[$key]; }
 	
	/**
	 * @param array $config
	 * @param $basepath = __DIR__
	 * @return GWF3 
	 */
	public function __construct($basepath, array $config = array())
	{
		self::$CONFIG = ($config = array_merge(self::$CONFIG, $config));

		# Important definements...
		Common::defineConst('GWF_WWW_PATH', $basepath.'/');
		Common::defineConst('GWF_PROTECTED_PATH', GWF_WWW_PATH.'protected/');
		Common::defineConst('GWF_CONFIG_PATH', GWF_PROTECTED_PATH.'config.php');
		Common::defineConst('GWF_LOGGING_PATH', GWF_PROTECTED_PATH.'logs');

		if($config['load_config'])
		{
			$this->onLoadConfig(GWF_CONFIG_PATH);
		}
		
		# Set valid mo/me
		$_GET['mo'] = Common::getGetString('mo', GWF_DEFAULT_MODULE);
		$_GET['me'] = Common::getGetString('me', GWF_DEFAULT_METHOD);
		
		# Setting the Design... TODO...
		self::setDesign(Common::getConst('GWF_DEFAULT_DESIGN', 'default'));

		ignore_user_abort($config['ignore_user_abort']);
		
		self::onDefineWebRoot();

		if($config['start_debug'])
		{
			GWF_Debug::enableErrorHandler();
		}
		if(!$config['no_session'])
		{
			$this->onStartSession($config['blocking']);
		}
		if($config['do_logging'])
		{
			$this->onStartLogging($config['no_session']);
		}
		if ($config['website_init']) 
		{ 
//			$this->onInit(); 
			GWF_Website::init();
		}
		if ($config['autoload_modules']) 
		{ 
			$this->onAutoloadModules(); 
		}
		if ($config['load_module']) 
		{ 
			$this->onLoadModule(); 
		}
//		if ($config['get_user']) 
		if (!defined('GWF_INSTALLATION')) 
		{		
			GWF_Template::addMainTvars(array('user' => (self::$user = GWF_User::getStaticOrGuest())));
		}
	}
	
	public function __destruct() 
	{
		$this->onSessionCommit(self::$CONFIG['store_last_url']);
	}
		
	/**
	 * This is always required!
	 */
	public static function _init()
	{
		# Require the util
		require_once 'core/inc/util/Common.php';
		
		#default definements
		define('GWF_PATH', __DIR__.'/');
		define('GWF_EXTRA_PATH', GWF_PATH.'extra/');
		define('GWF_CORE_PATH', GWF_PATH.'core/');
		
		# The GWF autoloader
		spl_autoload_register(array(__CLASS__,'onAutoloadClass'));
		
		# Require the Database
		require_once GWF_CORE_PATH.'inc/GDO/GDO.php';

	}
		
	public static function onAutoloadClass($classname, $prefix='GWF_')
	{
		if (substr($classname, 0, 4) === $prefix)
		{
			require_once GWF_CORE_PATH.'inc/util/'.$classname.'.php';
		}
	}
	
	public static function onLoadConfig($config='protected/config.php') 
	{
		# Get the config
		if (!defined('GWF_HAVE_CONFIG'))
		{
			if(!file_exists($config))
			{			
				die('GWF3 couldnt load the config: file doesnt exists. Message in '.__FILE__.' at line'.__LINE__);
			}
			require_once $config;
			define('GWF_HAVE_CONFIG', 1);
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
	public static function onStartSession($blocking=true) {
		if (!GWF_Session::start($blocking))
		{
			die('GWF not installed?!');
//			return false; # Not installed
		}
	}
	public static function onStartLogging($no_session=false)
	{
		$username = false;
		if (!$no_session)
		{
			if (false !== ($user = GWF_Session::getUser()))
			{
				$username = $user->getVar('user_name');
			}
		}
		GWF_Log::init($username, true, GWF_LOGGING_PATH);
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
		if (false === (self::$module = GWF_Module::loadModuleDB($_GET['mo']))) 
		{
			if (false === (self::$module = GWF_Module::loadModuleDB(GWF_DEFAULT_MODULE))) 
			{
				die('No module found.');
			}
			$_GET['me'] = GWF_DEFAULT_METHOD;
		}

		if (self::$module->isEnabled())
		{
			# Execute the method
			self::$module->onInclude();
			self::$module->onLoadLanguage();
			self::$page = self::$module->execute($_GET['me']);
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
		if(!defined('GWF_INSTALLATION'))
		{
			# Commit the session
			if (false !== ($user = GWF_Session::getUser()))
			{
				$user->saveVar('user_lastactivity', time());
			}
			GWF_Session::commit($store_last_url);
		}
		return $this;
	}
	
	public function onDisplayPage($content = NULL)
	{
		if(defined('GWF_WEBSITE_DOWN')) return GWF_WEBSITE_DOWN;
		
		# Display the page
		if (isset($_GET['ajax']))
		{
			return self::$page;
		}
		else
		{
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

	public static function getModule() { return self::$module; }
	public static function getUser() { return self::$user; }
	public static function setDesign($design) { self::$design = $design; }
	public static function getDesign() { return self::$design; }
	
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