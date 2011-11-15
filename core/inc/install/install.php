<?php
/**
 * The GWF-Installation-Wizard
 * @author spaceone, gizmore
 * @todo use this script with cli? $_GET[ajax]
 */
# Load Install-Core
require_once GWF_CORE_PATH.'inc/install/GWF_Install.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallConfig.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallFunctions.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallWizardLanguage.php';

// define('GWF_INSTALLATION', true);
define('GWF_STEP', Common::getGetString('step', '0'));
define('GWF_LOGGING_PATH', Common::getGet('loggingpath', './protected/installog'));

$gwf = new GWF3(getcwd(), array(
	'website_init' => false,
	'autoload_modules' => false,
	'load_module' => false,
	'load_config' => false,
	'start_debug' => true,
	'get_user' => false,
	'do_logging' => true,
	'log_request' => true,
	'blocking' => false,
	'no_session' => true,
	'store_last_url' => false,
	'ignore_user_abort' => true,
));

GWF_Debug::setDieOnError(false);

# Website init
header('Content-Type: text/html; charset=UTF-8');
GWF_InstallWizardLanguage::init();
GWF_HTML::init();

# Set install language
$il = new GWF_LangTrans(GWF_CORE_PATH.'lang/install/install');
GWF_Install::setGWFIL($il);

# Design init
GWF3::setDesign('install');
GWF_Website::addCSS(GWF_WEB_ROOT.'tpl/install/css/install.css');
GWF_Website::addCSS(GWF_WEB_ROOT.'tpl/install/css/design.css');
GWF_Website::setPageTitle('GWF Install Wizard');
GWF_Template::addMainTvars(array('gwfpath'=> GWF_PATH, 'gwfwebpath' => GWF_WWW_PATH, 'step' => GWF_STEP, 'il' => $il));

if (false !== (Common::getPost('create_admin'))) {
	$page = GWF_Install::wizard_9_1();
}
elseif (false !== (Common::getPost('test_db'))) {
	$page = GWF_Install::wizard_1a();
}
elseif (false !== (Common::getPost('write_config'))) {
	$page = GWF_Install::wizard_1b();
}
elseif (false !== (Common::getPost('install_modules'))) {
	$page = GWF_Install::wizard_6_1();
}
else switch(GWF_STEP)
{
	case '1': $page = GWF_Install::wizard_1(); break; # Create Config
	case '2': $page = GWF_Install::wizard_2(); break; # Init Install
	case '3': $page = GWF_Install::wizard_3(); break; # Install CoreDB
	case '4': $page = GWF_Install::wizard_4(); break; # Choose Language
	case '4_1': $page = GWF_Install::wizard_4_1(); break; # Install Language
	case '4_2': $page = GWF_Install::wizard_4_2(); break; # Install Language+IP2C 
	case '5': $page = GWF_Install::wizard_5(); break; # Choose UA
	case '5_1': $page = GWF_Install::wizard_5_1(); break; # Install UA
	case '5_2': $page = GWF_Install::wizard_5_2(); break; # Skip UA
	case '6': $page = GWF_Install::wizard_6(); break; # Choose modules
	case '7': $page = GWF_Install::wizard_7(); break; # Create index.php
	case '8': $page = GWF_Install::wizard_8(); break; # Create htaccess
	case '9': $page = GWF_Install::wizard_9(); break; # Create admins
	case '10': $page = GWF_Install::wizard_10(); break; # Create admins

	default:
	case '0': $page = GWF_Install::wizard_0(); break; # List Status
}

# Display page
echo $gwf->onDisplayPage($page);
?>
