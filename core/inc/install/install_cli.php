#!/usr/bin/php
<?php
/**
 * GWF Installer via CLI
 * @author gizmore
 * @author spaceone
 * @todo configpath, GWF_AutoConfig
 */
die('TODO: did not test it yet; GWF_AutoConfig');
if (PHP_SAPI !== 'cli')
{
	die('CLI Please');
}

# GWF_PATH
chdir('../../../');
require_once 'gwf3.class.php'; 

if(!defined('GWF_CONFIG_PATH'))
{
	define('GWF_CONFIG_PATH', realpath(GWF_PATH.'www/protected/config.php')); #TODO
}

# Is there a config file?
if ( false === file_exists(GWF_CONFIG_PATH) )
{
	$write_a_config = true;
	define('GWF_HAVE_CONFIG', true);
}
else
{
	GWF3::onLoadConfig(GWF_CONFIG_PATH);
}

require_once GWF_CORE_PATH.'inc/install/GWF_InstallWizard.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallFunctions.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallConfig.php';
require_once GWF_CORE_PATH.'inc/install/GWF_InstallWizardLanguage.php';

GWF_InstallWizardLanguage::init();
GWF_Log::init(false, true, GWF_PATH.'/protected/installlog');

$lang = new GWF_LangTrans(GWF_CORE_PATH.'lang/install/install');

if (isset($write_a_config))
{
	GWF_InstallConfig::writeConfig($lang);
	echo 'I have written a default config to protected/config.php'.PHP_EOL;
	echo 'Please edit that config.php, before installing gwf3.'.PHP_EOL;
	die(0);
}

if (false === gdo_db())
{
	file_put_contents('php://stderr', 'Cannot connect to the database. Check your protected/config.php!'.PHP_EOL);
	die(1);
}

echo "Installing gwf util core...".PHP_EOL;
if (!GWF_InstallFunctions::core(false))
{
	file_put_contents('php://stderr', 'Cannot install core... giving up!');
	die(2);
}

echo "Installing Language,Country,IP2Country...".PHP_EOL;
GWF_InstallFunctions::createLanguage(true, true, false);

echo "Installing all modules...".PHP_EOL;
echo GWF_InstallFunctions::all_modules(false);

echo "Thank you for trying GWF!".PHP_EOL;
die(0);
