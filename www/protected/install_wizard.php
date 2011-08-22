<?php
chdir('../');
if (!file_exists('protected/config.php')) {
	define('GWF_HAVE_CONFIG', true);
	require_once 'core/inc/util/Common.php';
	require_once 'protected/install_scripts/install_wizard.inc.php';
}
require_once 'gwf3.class.php'; 
GWF3::onLoadConfig(GWF_CONFIG_PATH);
require_once 'protected/install_scripts/install_functions.php';
require_once 'protected/install_scripts/install_config.php';

# Init core
header('Content-Type: text/html; charset=UTF-8');
$server_root = str_replace(DIRECTORY_SEPARATOR.'protected', '', dirname(__FILE__));
GWF_Language::initEnglish();
GWF_HTML::init();
GWF_Debug::setBasedir($server_root);
GWF_Log::init(false, true, $server_root.'/protected/logs');
global $gwfil, $red;
$red = 0;
$gwfil = new GWF_LangTrans('protected/install_lang/install');

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'.PHP_EOL;
echo '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.PHP_EOL;
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">'.PHP_EOL;
echo '<head>'.PHP_EOL;
echo sprintf('<title>GWF Install Wizard</title>').PHP_EOL;
echo '<script type="text/javascript" src="'.GWF_WEB_ROOT.'js/jquery-1.4.2.min.js"></script>'.PHP_EOL;
echo '<link rel="stylesheet" type="text/css" href="install_css/install.css?v=1" />'.PHP_EOL;
echo '</head>'.PHP_EOL;
echo '<body>'.PHP_EOL;
echo install_wizard_banner();
echo '<div id="gwfinstmaindiv">'.PHP_EOL;

if (false !== (Common::getPost('create_admin'))) {
	echo install_wizard_8a();
}
elseif (false !== (Common::getPost('test_db'))) {
	echo install_wizard_1a();
}
elseif (false !== (Common::getPost('write_config'))) {
	echo install_wizard_1b();
}
elseif (false !== (Common::getPost('install_modules'))) {
	echo install_wizard_7a();
}
else switch(intval(Common::getGet('step', 0)))
{
	case 0: echo install_wizard_0(); break; # List Status
	case 1: echo install_wizard_1(); break;
	case 2: echo install_wizard_2(); break; # Init Install
	case 3: echo install_wizard_3(); break; # Create CoreDB
	case 4: echo install_wizard_4(); break; # Language Small
	case 5: echo install_wizard_5(); break; # Language Big
	case 6: echo install_wizard_6(); break; # UserAgentMap
	case 7: echo install_wizard_7(); break; # All Modules
	case 8: echo install_wizard_8(); break; # Admins
	case 9: echo install_wizard_9(); break; # Done
	case 10: echo install_wizard_10(); break; # htaccess
	case 11: echo install_wizard_11(); break; # create index.php, error.php
}

echo '</div>'.PHP_EOL;
echo '</body>'.PHP_EOL;
echo '</html>'.PHP_EOL;


#################
### Functions ###
#################
function install_wizard_banner()
{
	global $gwfil;
	return
	'<div id="gwfinstallbanner">'.PHP_EOL.
	'<h1><a href="install_wizard.php">'.$gwfil->lang('pt_wizard').'</a></h1>'.PHP_EOL.
//	'<p><a href="install_wizard.php?step=1">'.$gwfil->lang('step_1').'</a></p>'.PHP_EOL.
	'</div>'.PHP_EOL;
	//	'<ol>'.PHP_EOL.
//	install_wizard_banner_step('1', 'Config').
//	install_wizard_banner_step('3', 'Core').
//	install_wizard_banner_step('4', 'Core').
//	'<li><a href=</li>'.PHP_EOL.
//	'</ol>'.PHP_EOL.
}
//function install_wizard_banner_step($step, $text)
//{
//	return sprintf('<li><a href="install_wizard.php?step=%s">%s)%s</a></li>', $step, $step, $text).PHP_EOL;
//}

function install_wizard_0()
{
	global $gwfil, $red;
	
	$back = '';
	
//	$back = sprintf('<h2>%s</h2>', $gwfil->lang('pt_wizard')).PHP_EOL;
	
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_0_0')).PHP_EOL;
	
	$back .= '<pre>'.PHP_EOL;
	$back .= "CREATE USER 'username'@'localhost' IDENTIFIED BY 'password'\n";
	$back .= "CREATE DATABASE `databasename`;\n";
	$back .= "GRANT ALL ON databasename.* TO 'username'@'localhost' IDENTIFIED BY 'password';\n";
	$back .= '</pre>'.PHP_EOL;
	
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_0_0a')).PHP_EOL;
	
	$back .= '<table>'.PHP_EOL;
	$back .= install_wizard_0_row('4', install_wizard_test_cfg_r());
	$back .= install_wizard_0_row('1', install_wizard_test_hta_sec());
	$back .= install_wizard_0_row('2', install_wizard_test_hta_w());
	$back .= install_wizard_0_row('3', install_wizard_test_cfg_w());
	$back .= install_wizard_0_row('5', install_wizard_test_dbimg());
	$back .= install_wizard_0_row('6', install_wizard_test_temp());
	$back .= install_wizard_0_row('7', install_wizard_test_logs());
	$back .= install_wizard_0_row('8', install_wizard_test_rawlogs());
	$back .= install_wizard_0_row('9', install_wizard_test_db());
	$back .= install_wizard_0_row('10', install_wizard_test_hash());
	$back .= install_wizard_0_row('11', install_wizard_test_zip());
	$back .= install_wizard_0_row('12', install_wizard_test_curl());
	$back .= install_wizard_0_row('13', install_wizard_test_mime());
	$back .= install_wizard_0_row('15', install_wizard_test_gpg());
	$back .= install_wizard_0_row('14', install_wizard_test_security1());
	$back .= '</table>'.PHP_EOL;
	
	
	$back .= '<div class="gwfinstallbtns">'.PHP_EOL;
	if (defined('GWF_WIZARD_COULD_WRITE_CFG_FILE'))
	{
		$back .= install_wizard_btn('1');
	}
	if (defined('GWF_WIZARD_COULD_WRITE_CFG_FILE') && defined('GWF_WIZARD_HAS_CFG_FILE'))
	{
		$back .= install_wizard_btn('2');
	}
	if (defined('GWF_WIZARD_HAS_DB') && $red === 0)
	{
		$back .= install_wizard_btn('3');
	}
	if (!defined('GWF_WIZARD_COULD_WRITE_CFG_FILE') && !defined('GWF_WIZARD_HAS_CFG_FILE'))
	{
		$back .= GWF_HTML::error($gwfil->lang('wizard'), $gwfil->lang('err_create_config'), false);
	}
	$back .= '</div>';
	return $back;
}
function install_wizard_0_row($step, $value)
{
	global $gwfil;
	return sprintf('<tr><td>%s</td><td>%s</td></tr>', $gwfil->lang('step_0_'.$step), $value).PHP_EOL;
}
function install_wizard_btn($step)
{
	global $gwfil;
	return sprintf('<p class="gwfinstallbtn"><a href="install_wizard.php?step=%s">Step %s: %s</a></p>', $step, $step, $gwfil->lang('step_'.$step)).PHP_EOL;
}
function install_wizard_bool($bool)
{
	global $gwfil;
	return $bool ? '<b class="gwfinstallyes">'.$gwfil->lang('yes').'</b>' : '<b class="gwfinstallno">'.$gwfil->lang('no').'</b>'; 
}

function install_wizard_test_func($func, $required=true)
{
	$b = function_exists($func);
	if (!$b && $required) {
		global $red;
		$red++;
	}
	return install_wizard_bool($b);
}

function install_wizard_test_hash()
{
	return install_wizard_test_func('hash', true);
}

function install_wizard_test_curl()
{
	return install_wizard_test_func('curl_init', false);
}

function install_wizard_test_zip()
{
	return install_wizard_bool(class_exists('ZipArchive', false));
}

function install_wizard_test_cfg_w()
{
	if (true === ($b = GWF_File::isWriteable('protected/config.php')))
	{
		define('GWF_WIZARD_COULD_WRITE_CFG_FILE', true);
	}
	else
	{
		global $red;
		$red++;
	}
	return install_wizard_bool($b);
}

function install_wizard_test_cfg_r()
{
	if (true === ($b = Common::isFile('protected/config.php')))
	{
		define('GWF_WIZARD_HAS_CFG_FILE', true);
	}
	return install_wizard_bool($b);
}

function install_wizard_is_write($path, $required=true)
{
	$b = GWF_File::isWriteable($path);
	if (!$b && $required) {
		global $red;
		$red++;
	}
	return install_wizard_bool($b);
}

function install_wizard_test_dbimg() { return install_wizard_is_write('dbimg', true); }
function install_wizard_test_temp() { return install_wizard_is_write('temp', true); }
function install_wizard_test_logs() { return install_wizard_is_write('protected/logs', true); }
function install_wizard_test_rawlogs() { return install_wizard_is_write('protected/rawlog', true); }
function install_wizard_test_hta_w() { return install_wizard_is_write('.htaccess', true); }
function install_wizard_test_mime()
{
	$b = function_exists('mime_content_type') || function_exists('finfo_open');
	if (!$b) {
//		global $red;
//		$red++;
	}
	return install_wizard_bool($b);
}

function install_wizard_test_security1()
{
	$secure = true;
	$bad_funcs = array('exec', 'system', 'passthru', 'shell_exec', 'proc_open', 'popen', 'pcntl_exec');
	foreach ($bad_funcs as $func)
	{
		if (function_exists($func))
		{
			echo GWF_HTML::error('Install Wizard', sprintf('Function %s is available!', $func), false);
			$secure = false;
		}
	}
	return install_wizard_bool($secure);
}

function install_wizard_test_gpg()
{
	return install_wizard_bool(function_exists('gnupg_init'));
}

function install_wizard_test_db()
{
	global $gwfil;
	if (!defined('GWF_WIZARD_HAS_CFG_FILE'))
	{
		return $gwfil->lang('no_cfg_file');
	}
	require_once 'protected/config.php';
	
	if (false !== ($db = gdo_db()))
	{
		define('GWF_WIZARD_HAS_DB', true);
	}
	
	return install_wizard_bool($db!==false);
}

function install_wizard_test_db_2()
{
	$pv = Common::getPostArray(GWF_InstallConfig::POSTVARS, array());
	
	$host = isset($pv['GWF_DB_HOST']) ? $pv['GWF_DB_HOST'] : '';
	$user = isset($pv['GWF_DB_USER']) ? $pv['GWF_DB_USER'] : '';
	$pass = isset($pv['GWF_DB_PASSWORD']) ? $pv['GWF_DB_PASSWORD'] : '';
	$db = isset($pv['GWF_DB_DATABASE']) ? $pv['GWF_DB_DATABASE'] : '';
	$type = isset($pv['GWF_DB_TYPE']) ? $pv['GWF_DB_TYPE'] : 'mysql';
	
	if (false !== ($db = gdo_db_instance($host, $user, $pass, $db, $type, 'utf8', false)))
	{
		define('GWF_WIZARD_HAS_DB', true);
	}
	return install_wizard_bool($db!==false);
}

function install_wizard_test_hta_sec()
{
	return is_file('protected/.htaccess') ? '<b style="color:#ff0000">Unknown</b>' : install_wizard_bool(false);
}

#########################
### --- Step 1 --- ######
### --- Create Config ###
#########################
function install_wizard_h2($step, $param=array())
{
	global $gwfil;
	return sprintf('<h2>%s) - %s</h2>', $gwfil->lang('step', array($step)), $gwfil->lang('step_'.$step, $param));
}

function install_wizard_1()
{
	global $gwfil;
	$back = install_wizard_h2('1');
	$back .= GWF_InstallConfig::displayForm('install_wizard.php', $gwfil);
	return $back;
}

function install_wizard_1a()
{
	global $gwfil;
	$back = install_wizard_h2('1a');
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_1a_1', array(install_wizard_test_db_2())));
	if (!Common::isFile(GWF_SMARTY_PATH)) {
		$back .= install_wizard_error('err_no_smarty');
	}
	
	return $back.install_wizard_1().install_wizard_btn('2');
}

function install_wizard_1b()
{
	global $gwfil;
	$back = install_wizard_h2('1b');
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_1b_0', array(install_wizard_bool(GWF_InstallConfig::writeConfig($gwfil)))));
	return $back.install_wizard_1a();
}

#######################
### --- Step 2 --- ########
### --- Test Config --- ###
###########################
function install_wizard_error($key, $param=array())
{
	global $gwfil;
	return GWF_HTML::error($gwfil->lang('wizard'), $gwfil->lang($key, $param), false).PHP_EOL;
}

function install_wizard_2()
{
	global $gwfil;
	$back = install_wizard_h2('2');
	
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_1a_0', array(install_wizard_test_cfg_r())));
	if (!defined('GWF_WIZARD_HAS_CFG_FILE')) {
		return $back.install_wizard_error('err_no_config').install_wizard_1();
	}
	
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_1a_1', array(install_wizard_test_db())));
	if (!defined('GWF_WIZARD_HAS_DB')) {
		return $back.install_wizard_error('err_no_db').install_wizard_1();
	}
	
	return
		$back.PHP_EOL.
		sprintf('<p>%s</p>', $gwfil->lang('step_2_0')).PHP_EOL.
		install_wizard_btn('3');
}

######################
### --- Step 3 --- #########
### --- Install Core --- ###
############################
function install_wizard_check_cfg_quick()
{
	if (false === ($db = gdo_db())) {
		return install_wizard_error('err_no_db');
	}
	
	if (!Common::isFile(GWF_SMARTY_PATH)) {
		return install_wizard_error('err_no_smarty');
	}
	
	return false;
}

function install_wizard_3()
{
	global $gwfil;
	$back = install_wizard_h2('3');
	if (false !== ($error = install_wizard_check_cfg_quick())) {
		return $error;
	}
	
	$back .= $gwfil->lang('step_3_0').PHP_EOL;
	
	$output = '';
	if (false === install_core(false)) {
		return $output.GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	$back .= $output;
	$back .= $gwfil->lang('step_3_1').PHP_EOL;
	$back .= install_wizard_btn('4');
	$back .= install_wizard_btn('5');
	return $back;
}

### Lang
function install_wizard_4()
{
	global $gwfil;
	$back = install_wizard_h2('4');
	install_createLanguage(true, true, false);
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_4_0'));
	$back .= install_wizard_btn('6');
	$back .= install_wizard_btn('7');
	return $back;
}

### Lang + IP
function install_wizard_5()
{
	global $gwfil;
	$back = install_wizard_h2('5');
	install_createLanguage(true, true, true);
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_5_0'));
	$back .= install_wizard_btn('6');
	$back .= install_wizard_btn('7');
	return $back;
}

### Useragent
function install_wizard_6()
{
	global $gwfil;
	$back = install_wizard_h2('6');
	$back = '<h2>Step 6</h2><p>Installed the useragent map.</p>';
	install_createUserAgents();
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_6_0'));
	$back .= install_wizard_btn('7');
	return $back;
}

### Modules
//function install_wizard_7c()
//{
//	global $gwfil;
//	$back = install_wizard_h2('7');
//	install_all_modules(false);
//	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_7_0'));
//	$back .= install_wizard_btn('8');
//	return $back;
//}

function install_wizard_7()
{
	global $gwfil;
	$back = install_wizard_h2('7');
	if (false === ($modules = GWF_ModuleLoader::loadModulesFS())) {
		return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
	}
	$back .= install_wizard_7_form($modules);
	return $back;
}

function install_wizard_7_form(array $modules)
{
	$back = '<div><table>';
	$back .= '<form action="install_wizard.php?step=7a" method="post" id="form_install_modules" >'.PHP_EOL;

//	$back .= sprintf('<tr><td></td><td><input name="toggle_all" type="checkbox" checked="checked" onclick="$(\'#form_install_modules\').find(\':checkbox\').attr(\'checked\', \'checked\'); return false;" /></td></tr>').PHP_EOL;
	
	GWF_ModuleLoader::sortModules($modules, 'module_name', 'ASC');
	
	foreach ($modules as $module)
	{
		$name = $module->getName();
		$back .= sprintf('<tr><td>%s</td><td><input name="mod[%s]" type="checkbox" checked="checked" /></td></tr>', $name, $name).PHP_EOL;
	}
	$back .= '<tr><td><input type="submit" name="install_modules" value="Install Modules" /></td></tr>'.PHP_EOL;
	$back .= '</form>'.PHP_EOL;
	$back .= '</table></div>'.PHP_EOL;
	
	return $back;
}

function install_wizard_7a()
{
	global $gwfil;
	$back = '';
	$names = Common::getPostArray('mod', array());
	if (count($names) === 0) {
		return install_wizard_7();
	}
	$back = install_wizard_h2('7a');
	$back .= sprintf('<p>%s</p>', $gwfil->lang('step_7_0'));
	
	$modules = array();
	$back2 = '';
	foreach ($names as $name => $on)
	{
		if (false === ($module = GWF_ModuleLoader::loadModuleFS($name))) {
			$back2 .= GWF_HTML::err('ERR_MODULE_MISSING', array(htmlspecialchars($name)));
			continue;
		}
		$modules[] = $module;
	}
	
	if ($back2 !== '') {
		return $back.$back2;
	}
	
	
	$modules = GWF_ModuleLoader::loadModulesFS();
	GWF_ModuleLoader::sortModules($modules, 'module_priority', 'ASC');
	
	$back .= install_modules($modules, false);
	
//	foreach ($modules as $module)
//	{
//		$module instanceof GWF_Module;
//		echo $module->getName().'<br/>';
//		# TODO: Check dependencies. Quit on error.
//		$back .= GWF_ModuleLoader::installModule($module, false);
//	}
//	
//	GWF_ModuleLoader::i
//	GWF_Module::installHTAccessModules($modules);
	
	$back .= install_wizard_btn('8');
	
	return $back;
}


### Admins
function install_wizard_8()
{
	global $gwfil;
	$back = install_wizard_h2('8');
	$back .= '<div>';
	$back .= sprintf('<form method="post" action="install_wizard.php">');
	$back .= '<div>Username:';
	$back .= sprintf('<input type="text" name="username" value="" />');
	$back .= '</div>';
	$back .= '<div>Password:';
	$back .= sprintf('<input type="text" name="password" value="" />');
	$back .= '</div>';
	$back .= '<div>EMail:';
	$back .= sprintf('<input type="text" name="email" value="" />');
	$back .= '</div>';
	$back .= sprintf('<div><input type="submit" name="create_admin" value="Install Admin" /></div>');
	$back .= '</form>';
	$back .= '</div>';
	return $back;
}

function install_wizard_8a()
{
	$username = Common::getPost('username', '');
	if (!GWF_Validator::isValidUsername($username)) {
		return GWF_HTML::error('Install Wizard', 'Invalid username.', false).install_wizard_8();
	}
	
	$password = Common::getPost('password', '');
	if (!GWF_Validator::isValidPassword($password)) {
		return GWF_HTML::error('Install Wizard', 'Invalid password.', false).install_wizard_8();
	}
	
	$email = Common::getPost('email', '');
	if (!GWF_Validator::isValidEmail($email)) {
		return GWF_HTML::error('Install Wizard', 'Invalid email.', false).install_wizard_8();
	}
	
	install_default_groups();
	
	install_createAdmin($username, $password, $email, $back);
	
	return
		$back.
		install_wizard_btn('8').
		install_wizard_btn('9');
}

function install_wizard_9()
{
	return 
		GWF_HTML::message('Install Wizard Completed', 'Install wizard has finished. Please login as your admin account now. Also: <b>DO NOT FORGET TO .htaccess PROTECT THE FOLDER /protected</b>', false).
		install_wizard_btn('11');
}

function install_wizard_10()
{
	if (false === GWF_HTAccess::protect(dirname(__FILE__).'/protected')) {
		echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
	}
	
	return GWF_HTML::message('Install Wizard Completed', 'Install wizard has finished.', false);
}

function install_wizard_11()
{
	if (false === copyExampleFiles()) {
		echo GWF_HTML::err('ERR_GENERAL', array('Please copy index.example.php => index.php and error.example.php => error.php now'));
	} else { 
		echo GWF_HTML::message('Install Wizard', 'Successfully created index.pp and error.php.', false);
	}
	return install_wizard_btn('10');
}


?>