<?php

define('GWF_INSTALLATION', true);

die('Dont use it atm, its also not protected!-.-');
#TODO: use this script with cli? $_GET[ajax]
require_once 'gwf3.class.php';
# gizmore: permit to move these files.. (may to inc/util ??)
require_once GWF_PATH.'protected/install_scripts/install_functions.php';
require_once GWF_PATH.'protected/install_scripts/install_config.php';

$cpath = Common::defineConst('GWF_CONFIG_PATH', Common::getGet('configpath', GWF_PATH.'protected/config.example.php'));
$lpath = Common::defineConst('GWF_LOGGING_PATH', Common::getGet('loggingpath', GWF_PATH.'protected/installog'));

if(!file_exists($cpath))
{
	# TODO: Create Form; do html error message! define GWF_HTML const to use all errors in smarty
	die('please give me an existing example config; example: ?configpath=/home/GWF/config.example.php');
}

$gwf = new GWF3(__DIR__	, array(
		'website_init' => false,
		'autoload_modules' => false,
		'load_module' => false,
		'get_user' => false,
#		'config_path' => GWF_PATH.'protected/config.example.php',
#		'logging_path' => GWF_PATH.'protected/installlog',
		'do_logging' => true,
		'no_session' => true
));

# Website Init #Grr... cant have different languages atm
header('Content-Type: text/html; charset=UTF-8');
GWF_Language::initEnglish();
GWF_HTML::init();

# Design Init
GWF3::setDesign('install');
GWF_Website::addCSS('/tpl/install/css/install.css');
GWF_Website::setPageTitle('GWF Install Wizard');
GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jquery-1.4.2.min.js');

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
else switch(intval(Common::getGet('step', 0)))
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