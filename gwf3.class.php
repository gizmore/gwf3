<?php

define('GWF_DEBUG_TIME_START', microtime(true));
define('GWF_CORE_VERSION', '3.01-2011.JUL.02');
define('GWF_PATH', __DIR__.'/');
define('GWF_CORE_PATH', GWF_PATH.'core/');
if (!defined('GWF_CONFIG_PATH')) define('GWF_CONFIG_PATH', 'protected/config.php');

/**
 * @author spaceone
 * @version 1.02
 * @todo check if Session commit works
 * @todo better $mo/$me handling
 */
class GWF3 
{
	public static $CONFIG = array(
		'website_init' => true,
		'autoload_modules' => true,
		'load_module' => true,
		'get_user' => true,
		'config_path' => GWF_CONFIG_PATH,
//		'logging' => true,
	);
	
//	private static $me = GWF_DEFAULT_MODULE, $mo = GWF_DEFAULT_METHOD;
	private static $me = '';
	private static $mo = '';
	private static $module, $page, $user;

	/**
	 *
	 * @param array $config
	 * @param $basepath = __DIR__
	 * @return GWF3 
	 */
	public function __construct($basepath, array $config = array())
	{
		$config = array_merge(self::$CONFIG, $config);
		define('GWF_WWW_PATH', $basepath);
		self::onLoadConfig($config['config_path']);
		
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
			self::$user = GWF_User::getStaticOrGuest();
			GWF_Template::addMainTvars(array('user' => self::$user));
		}
//		return $this;
	}
	public function __destruct() 
	{
		$this->onSessionCommit();
	}
	public function onInit($server_root, $blocking=true, $no_session=false) 
	{
		# Init core
		if (false === GWF_Website::init($server_root, $blocking, $no_session)) {
			die('GWF3 does not seem to be installed properly.');
		}
		return $this;
	}
	public function onAutoloadModules()
	{
		# Autoload Modules
		if (false === GWF_Module::autoloadModules()) {
			die('Cannot autoload modules. GWF not installed?');
		}
		return $this;
	}
	public function onLoadModule()
	{
		# Load the module
		if (false === (self::$module = GWF_Module::loadModuleDB(Common::getGetString('mo', GWF_DEFAULT_MODULE)))) {
			if (false === (self::$module = GWF_Module::loadModuleDB(GWF_DEFAULT_MODULE))) {
				die('No module found.');
			}
			self::$me = GWF_DEFAULT_METHOD; //IMPORTANT
		}
		else {
			self::$me = Common::getGetString('me', GWF_DEFAULT_METHOD);
		}

		# Set valid mo/me
		$_GET['mo'] = self::$module->getName();
		$_GET['me'] = self::$me;

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
	public static function gwf3_autoload($classname)
	{
		if (substr($classname, 0, 4) === 'GWF_')
		{
			require_once GWF_CORE_PATH.'/inc/util/'.$classname.'.php';
		}
	}
	public static function onLoadConfig($config = GWF_CONFIG_PATH) {
		# Get the config
		if (!defined('GWF_HAVE_CONFIG'))
		{
			require_once $config;
			define('GWF_HAVE_CONFIG', 1);
			self::onDefineWebRoot();
		}
	}
	public static function onDefineWebRoot() {
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
		define('GWF_WEB_ROOT', $root);
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
	public static function getMo() { return self::$mo; }
	public static function getMe() { return self::$me; }
	public static function getModule() { return self::$module; }
	public static function getUser() { return self::$user; }
}

# Require the Database
require_once GWF_CORE_PATH.'inc/GDO/GDO.php';

# Require the util
require_once GWF_CORE_PATH.'inc/util/Common.php';

# The GWF autoloader
spl_autoload_register(array('GWF3','gwf3_autoload'));

# Enable the error handlers
GWF_Debug::enableErrorHandler();