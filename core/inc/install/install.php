<?php
/** The GWF-Installation (Wizard)
 * @author spaceone, gizmore
 * @todo use this script with cli? $_GET[ajax]
 * @todo protect this file, include www/mini_install.php: self-deletion!
 * @todo path-handling, logging, cleanup path, smarty
 */

define('GWF_INSTALLATION', true);
define('GWF_ERRORS_TO_SMARTY', true);
define('GWF_MESSAGES_TO_SMARTY', true);
define('GWF_WEB_ROOT_NO_LANG', '/GWF3/www/');

require_once 'gwf3.class.php';

$cpath = Common::defineConst('GWF_CONFIG_PATH', Common::getGet('configpath', './protected/config.example.php'));
$lpath = Common::defineConst('GWF_LOGGING_PATH', Common::getGet('loggingpath', './protected/installog'));

require_once GWF_CORE_PATH.'inc/install/GWF_Install.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallFunctions.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallConfig.php';
require_once $cpath;

GWF_Debug::setDieOnError(false);

$gwf = new GWF3(__DIR__, array(
	'website_init' => false,
	'autoload_modules' => false,
	'load_module' => false,
	'get_user' => false,
	'config_path' => $cpath,
	'logging_path' => $lpath,
	'do_logging' => true,
	'no_session' => true
));

# Website Init #Grr... cant have different languages atm
header('Content-Type: text/html; charset=UTF-8');
GWF_Language::initEnglish();
GWF_HTML::init();

# set Install Language
GWF_Install::setGWFIL(new GWF_LangTrans(GWF_CORE_PATH.'lang/install/install'));

# Design Init
GWF3::setDesign('install');
GWF_Website::addCSS(GWF_WEB_ROOT.'tpl/install/css/install.css');
GWF_Website::setPageTitle('GWF Install Wizard');
GWF_Website::includeJQuery();
GWF_Template::addMainTvars(array('gwfpath'=> GWF_PATH, 'gwfwebpath' => GWF_WWW_PATH, 'wizard_banner' => GWF_Install::wizard_banner()));

$page = '';

if (false !== (Common::getPost('create_admin'))) {
	$page .= GWF_Install::wizard_8a();
}
elseif (false !== (Common::getPost('test_db'))) {
	$page .= GWF_Install::wizard_1a();
}
elseif (false !== (Common::getPost('write_config'))) {
	$page .= GWF_Install::wizard_1b();
}
elseif (false !== (Common::getPost('install_modules'))) {
	$page .= GWF_Install::wizard_7a();
}
else switch(Common::getGetInt('step', 0))
{
	case 0: $page .= GWF_Install::wizard_0(); break; # List Status
	case 1: $page .= GWF_Install::wizard_1(); break;
	case 2: $page .= GWF_Install::wizard_2(); break; # Init Install
	case 3: $page .= GWF_Install::wizard_3(); break; # Create CoreDB
	case 4: $page .= GWF_Install::wizard_4(); break; # Language Small
	case 5: $page .= GWF_Install::wizard_5(); break; # Language Big
	case 6: $page .= GWF_Install::wizard_6(); break; # UserAgentMap
	case 7: $page .= GWF_Install::wizard_7(); break; # All Modules
	case 8: $page .= GWF_Install::wizard_8(); break; # Admins
	case 9: $page .= GWF_Install::wizard_9(); break; # Done
	case 10: $page .= GWF_Install::wizard_10(); break; # htaccess
	case 11: $page .= GWF_Install::wizard_11(); break; # create index.php, error.php
}

# Display Page
echo $gwf->onDisplayPage($page);

?>