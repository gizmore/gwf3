<?php
/** The GWF-Installation (Wizard)
 * @author spaceone, gizmore
 * @todo use this script with cli? $_GET[ajax]
 * @todo protect this file, include www/mini_install.php: self-deletion!
 * @todo path-handling, logging
 */
die('Dont use it atm, its also not protected!-.-');
define('GWF_INSTALLATION', true);
require_once 'gwf3.class.php';

$cpath = Common::defineConst('GWF_CONFIG_PATH', Common::getGet('configpath', './protected/config.example.php'));
$lpath = Common::defineConst('GWF_LOGGING_PATH', Common::getGet('loggingpath', './protected/installog'));
$spath = Common::defineConst('GWF_SMARTY_PATH', Common::getGet('smartypath', GWF_CORE_PATH.'inc/3p/smarty/Smarty.class.php'));

if(!file_exists($cpath) || !file_exists($spath))
{
	$error = '<p>The config-file OR the Smarty-class couldn\'t be found! Please give me the needed information!</p>';
	$error .= sprintf('
	<form action="%s" method="GET">
		<label for="config">Example-Config-Path:</label><input size="50" id="config" type="text" name="path" value="%s"><br>
		<label for="smarty">Smarty-Config-Path:</label><input size="50" id="smarty" type="text" name="path" value="%s"><br>
		<label for="logging">Logging-Path: </label><input size="50" id="logging" type="text" name="path" value="%s">
		<input type="submit" value="Install GWF!">
	</form>
	', '/install.php', $cpath, $spath, $lpath);
	die($error);
}

require_once $spath;
require_once GWF_CORE_PATH.'inc/install/GWF_InstallFunctions.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallConfig.php';

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

# Design Init
GWF3::setDesign('install');
GWF_Website::addCSS(GWF_WEB_ROOT.'tpl/install/css/install.css');
GWF_Website::setPageTitle('GWF Install Wizard');
GWF_Website::includeJQuery();
GWF_Template::addMainTvars(array('gwfpath'=> GWF_PATH, 'gwfwebpath' => GWF_WWW_PATH));

# set Install Language
GWF_Install::setGWFIL(new GWF_LangTrans(GWF_CORE_PATH.'lang/install/install'));

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