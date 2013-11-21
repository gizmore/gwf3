<?php
if (!class_exists('GDO'))
{
	die('Please do not call directly.');
}

if (isset($argv[4]) && $argv[4] === 'lamb_import')
{
	require_once 'lamb_import.php';
}

# Want a flush?
$drop_tables = isset($argv[3]) && $argv[3] === 'flush';

#############################
### Needed GWF/inc tables ###
#############################
require_once GWF_CORE_PATH.'inc/install/GWF_InstallFunctions.php';
GDO::table('GWF_Language')->createTable($drop_tables);
GDO::table('GWF_Country')->createTable($drop_tables);
GDO::table('GWF_LangMap')->createTable($drop_tables);
GWF_InstallFunctions::createLanguage(true, true, false);
# More util
GDO::table('GWF_CachedCounter')->createTable($drop_tables);
GDO::table('GWF_Counter')->createTable($drop_tables);
GDO::table('GWF_Settings')->createTable($drop_tables);

##################
# DOG GDO Tables #
##################
$tables = array(
	'Channel',
	'Conf_Bot',
	'Conf_Chan',
	'Conf_Mod',
	'Conf_Mod_Chan',
	'Conf_Mod_Serv',
	'Conf_Mod_User',
	'Conf_Plug',
	'Conf_Plug_Chan',
	'Conf_Plug_Serv',
	'Conf_Plug_User',
// 	'Conf_Serv',
	'Conf_User',
	'Nick',
	'PrivChannel',
	'PrivServer',
	'Server',
	'User',
);

# Install Tables
foreach ($tables as $table)
{
	GDO::table("Dog_{$table}")->createTable($drop_tables);
}

# Install modules
Dog_Init::installModules($drop_tables);


# Want defaults?
if (isset($argv[4]) && $argv[4] === 'giz')
{
	GDO::table('Dog_Server')->insertAssoc(array(
		'serv_id' => '1',
		'serv_host' => 'irc.giz.org',
		'serv_port' => '6668',
// 		'serv_retries' => '10',
// 		'serv_timeout' => '5',
// 		'serv_throttle' => '3',
		'serv_triggers' => '.',
		'serv_options' => Dog_Server::DEFAULT_OPTIONS,
	));
	
	GDO::table('Dog_Nick')->insertAssoc(array(
		'nick_id' => '1',
		'nick_sid' => '1',
		'nick_name' => 'Dog',
		'nick_pass' => NULL,
	));
}

?>
