<?php

define('GWF_DEBUG_TIME_START', microtime(true));

# Include the core (always a good and safe idea)
require_once 'inc/_gwf_include.php';
/**
 * @author spaceone
 * @version 1.01
 * @todo check if Session commit works
 * @todo better $mo/$me handling
 * @todo class variable $user?
 * @param $basepath should be __FILE__
 * @param $autoload load all autoload-modules
 * @param $loadmo load the requested module
 */
class GWF3 
{
	private static $module, $me = GWF_DEFAULT_MODULE, $mo = GWF_DEFAULT_METHOD, $page, $user;
	public function __construct($basepath = __FILE__, $autoload = true, $loadmo = true, $user = true)
	{
		if (false !== $basepath) { $this->onInit(dirname($basepath)); }
		if (false !== $autoload) { $this->onAutoloadModules(); }
		if (false !== $loadmo) { $this->onLoadModule(); }
		if (false !== $user) 
		{		
			self::$user = GWF_User::getStaticOrGuest();
			GWF_Template::addMainTvars(array('user' => self::$user));
		}
		return $this;
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