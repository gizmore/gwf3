<html>
<body>
<?php
chdir('../');

$worker_ip = 'YOUR.IP.GOES.HERE';

if (!is_readable('protected/config.php')) {
	die('Try install/wizard.php');
}

set_time_limit(0);

require_once 'protected/config.php';
require_once '../gwf3.class.php'; 
$gwf = new GWF3(getcwd(), array(
	'website_init' => false,
	'autoload_modules' => false,
	'load_module' => false,
	'load_config' => false,
	'start_debug' => true,
	'get_user' => false,
	'do_logging' => false,
	'log_request' => false,
	'blocking' => false,
	'no_session' => true,
	'store_last_url' => false,
	'ignore_user_abort' => true,
));

######################
### Security Check ###
######################
if (!GWF_IP6::isLocal()) 
{
	if ($_SERVER['REMOTE_ADDR'] !== $worker_ip)
	{
		GWF3::logDie(sprintf('You have no valid $worker_ip in %s line %s.', __FILE__, __LINE__));
	}
}

GWF_Debug::setDieOnError(false);

GWF_Language::initEnglish();
GWF_HTML::init();
GWF_Log::init(false, true, GWF_WWW_PATH.'protected/logs');

require_once GWF_CORE_PATH.'inc/install/GWF_InstallFunctions.php';

if (false !== Common::getPost('core')) {
	$success = true;
	install_core(false, $success);
}
if (false !== Common::getPost('lang')) {
	install_createLanguage(true, true, false);
}
if (false !== Common::getPost('lang2')) {
	install_createLanguage(true, true, true);
}
if (false !== Common::getPost('mods')) {
	install_all_modules();
}
if (false !== Common::getPost('users')) {
	install_default_users();
}
if (false !== Common::getPost('gwf23')) {
	require_once GWF_CORE_PATH.'inc/install/upgrade/install23.php';
}

?>
<div>
<form action="install.php" method="post">
	<div><input type="submit" name="core" value="Core Tables" /></div>
	<div><input type="submit" name="lang" value="Lang+Country" /></div>
	<div><input type="submit" name="lang2" value="Lang+Country+IP" /></div>
	<div><input type="submit" name="mods" value="All Modules" /></div>
	<div><input type="submit" name="users" value="Admin Account" /></div>
	<div><input type="submit" name="gwf23" value="GWF2=>3" /></div>
</form>
</div>

</body>
</html>
