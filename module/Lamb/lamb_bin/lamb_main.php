<?php
# Not by remote!
if (isset($_SERVER['REMOTE_ADDR']))
{
	die('NO REMOTE CALLS PLEASE!');
}

# Parse Args:
if ($argc !== 3)
{
	die("Usage: $argv[0] gwfconfigfile lambconfigfile\nExample: $argv[0] protected/config.php Lamb_Config.php\n");
}
$_GET['ajax'] = 'true'; # emulate ajax templates

# GWF config
$gwfcfg = $argv[1];
if (!file_exists($gwfcfg))
{
	die("Error: GWF Config file not found.\nExample for the 1st parameter: protected/config.php.\nThis is the GWF config file.");
}
define('GWF_CONFIG_NAME', $gwfcfg);

# Lamb config
if (!file_exists("module/Lamb/lamb_bin/{$argv[2]}"))
{
	die("Error: Lamb Config File not found.\nExample for the 2nd parameter: Lamb_Config.php\nThis is the Lamb3 config file.");
}
define('LAMB_CONFIG_FILENAME', $argv[2]);

# Include GWF core
require_once 'inc/_gwf_include.php';
# Init it
GWF_HTML::init();
# Init the logger
GWF_Log::init(false, false, Common::substrUntil(dirname(__FILE__), '/module').'/protected/logs');

# Lamb3 core config
$dir = 'module/Lamb';
chdir($dir);
require_once 'lamb_bin/Lamb_ConfigInit.php';

# Lamb3 core
require_once 'Lamb_Channel.php';
require_once 'Lamb_IRC.php';
require_once 'Lamb_Log.php';
require_once 'Lamb_Module.php';
require_once 'Lamb_Server.php';
require_once 'Lamb_Timer.php';
require_once 'Lamb_User.php';
require_once 'Lamb.php';
chdir('../../');

###########
### RUN ###
###########
# Check installed
if (gdo_db() === false)
{
	die('Cannot connect to database.');
}
if (false === ($table = GDO::table('Lamb_User')))
{
	die('The Lamb_User GDO structure is not found. Please install Lamb first.'.PHP_EOL);
}
if (!$table->tableExists())
{
	die('The Lamb_User table does not exist. Please install Lamb first.'.PHP_EOL);
}
# Init the bot :)
$lamb = new Lamb();
if (!$lamb->init())
{
	die('Could not init lamb!');
}
# No halt on warnings ...
GWF_Debug::setDieOnError(false);
# ... and go!
$lamb->mainloop();
?>
