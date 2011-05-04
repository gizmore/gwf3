<?php
# Not by remote!
if (isset($_SERVER['REMOTE_ADDR'])) {
	die('NO REMOTE CALL PLS');
}
# GWF2 core
define('GWF_CONFIG_NAME', 'protected/config_lamb.php');
require_once 'inc/_gwf_include.php';

# Lamb2 core
$dir = 'modules/Lamb';
chdir($dir);
require 'Lamb_Channel.php';
require 'Lamb_IRC.php';
require 'Lamb_Log.php';
require 'Lamb_Module.php';
require 'Lamb_Server.php';
require 'Lamb_User.php';
require 'Lamb.php';
chdir('../../');

# check installed
if ( (gdo_db() === false) || (false === ($table = GDO::table('Lamb_User'))) || (!$table->tableExists()) ) {
	die('Please Install First :)'.PHP_EOL);
}

GWF_Log::init(false, false, dirname(__FILE__).'/../../../protected/logs');

# Load Lamb Module
if (false === ($module = GWF_Module::loadModuleFSByName('Lamb'))) {
	die('Lamb is disabled?');
}

# Copy Modulevars
foreach ($module->getModuleVars() as $var => $data)
{
	define($data['mv_key'], $module->getModuleVar($var));
}

# Run the bot :)
chdir($dir);
$lamb = new Lamb();
$lamb->init();
$lamb->mainloop();
?>