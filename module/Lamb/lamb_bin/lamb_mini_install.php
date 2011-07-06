<?php
#########################################################################
# to do a clean reinstall, run this script with --drop-tables argument! #
#########################################################################
chdir('../../../');

# CHANGE THIS! THEN IT MIGHT WORK!
define('GWF_CONFIG_NAME', 'protected/config_lamb_dev.php');
//die("CHANGE THIS!\n");

require_once 'inc/_gwf_include.php';
require_once 'module/Lamb/Lamb_Install.php';

# Args
$drop_tables = isset($argv[1]) && $argv[1] === '--drop-tables';

if ($drop_tables === true)
{
	echo "Flushing all core tables!!!".PHP_EOL;
}

#############################
### Needed GWF/inc tables ###
#############################
GDO::table('GWF_Counter')->createTable($drop_tables);
GDO::table('GWF_Settings')->createTable($drop_tables);

##########################
### Needed Lamb tables ###
##########################
require_once 'module/Lamb/Lamb_IRC.php';
require_once 'module/Lamb/Lamb_User.php';
require_once 'module/Lamb/Lamb_Server.php';
require_once 'module/Lamb/Lamb_Channel.php';
require_once 'module/Lamb/Lamb_IRCFrom.php';
require_once 'module/Lamb/Lamb_IRCTo.php';
foreach (Lamb_Install::$DB_CLASSES as $classname)
{
	GDO::table($classname)->createTable($drop_tables);
}
?>
