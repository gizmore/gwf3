<?php
# Not by remote!
if (isset($_SERVER['REMOTE_ADDR'])) {
	die('NO REMOTE CALL PLS');
}

$_GET['ajax'] = 'true';

# Parse Args:
if ($argc !== 3) {
	die("Usage: $argv[0] gwfconfigfile lambconfigfile\nExample: $argv[0] protected/config.php Lamb_Config.php\n");
}

$gwfcfg = $argv[1];
if (!file_exists($gwfcfg)) {
	die("Error: GWF Config file not found.\nExample for the 1st parameter: protected/config.php.\nThis is the GWF config file.");
}
define('GWF_CONFIG_NAME', $gwfcfg);

if (!file_exists("module/Lamb/lamb_bin/{$argv[2]}")) {
	die("Error: Lamb Config File not found.\n");
}
define('LAMB_CONFIG_FILENAME', $argv[2]);

# GWF3 core
#if (!file_exists('protected/config_lamb.php')) {
#	die('Please copy your protected/config.php to protected/config_lamb.php. You may have a different gwf config for the bot.');
#}

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