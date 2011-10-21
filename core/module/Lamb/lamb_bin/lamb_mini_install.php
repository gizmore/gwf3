<?php
#########################################################################
# to do a clean reinstall, run this script with --drop-tables argument! #
#########################################################################
chdir('../../../');

# EDIT!
# Change your protected/config.php location
require_once 'protected/config_lamb_dev.php';
# Change your gwf3.class.php location
require_once '../gwf3.class.php'; 
# End of EDIT!


require_once 'core/module/Lamb/Lamb_Install.php';

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
require_once 'core/module/Lamb/Lamb_IRC.php';
require_once 'core/module/Lamb/Lamb_User.php';
require_once 'core/module/Lamb/Lamb_Server.php';
require_once 'core/module/Lamb/Lamb_Channel.php';
require_once 'core/module/Lamb/Lamb_IRCFrom.php';
require_once 'core/module/Lamb/Lamb_IRCTo.php';
foreach (Lamb_Install::$DB_CLASSES as $classname)
{
	GDO::table($classname)->createTable($drop_tables);
}
?>
