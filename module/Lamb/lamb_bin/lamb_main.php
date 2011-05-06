<?php
# Not by remote!
if (isset($_SERVER['REMOTE_ADDR'])) {
	die('NO REMOTE CALL PLS');
}

$_GET['ajax'] = 'true';

# GWF3 core
if (!file_exists('protected/config_lamb.php')) {
	die('Please copy your protected/config.php to protected/config_lamb.php. You may have a different gwf config for the bot.');
}

define('GWF_CONFIG_NAME', 'protected/config_lamb.php');
require_once 'inc/_gwf_include.php';

GWF_HTML::init();
//GWF_Debug::setBasedir($basedir);

GWF_Log::init(false, false, Common::substrUntil(dirname(__FILE__), '/module').'/protected/logs');

# Lamb3 core
$dir = 'module/Lamb';
chdir($dir);
require_once 'lamb_bin/Lamb_ConfigInit.php';

require_once 'Lamb_Channel.php';
require_once 'Lamb_IRC.php';
require_once 'Lamb_Log.php';
require_once 'Lamb_Module.php';
require_once 'Lamb_Server.php';
require_once 'Lamb_User.php';
require_once 'Lamb.php';
chdir('../../');

# check installed
if ( (gdo_db() === false) || (false === ($table = GDO::table('Lamb_User'))) || (!$table->tableExists()) ) {
	die('Please Install First :)'.PHP_EOL);
}

GWF_Debug::setDieOnError(false);

# Run the bot :)
//chdir($dir);
$lamb = new Lamb();
if ($lamb->init())
{
	$lamb->mainloop();
}
?>