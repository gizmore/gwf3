<?php
if (PHP_SAPI!=='cli') {
	die('CLI Please');
}
chdir('../');
if (!file_exists('protected/config.php')) { $write_a_config = true; define('GWF_HAVE_CONFIG', true); }
require_once 'gwf3.class.php'; 
GWF3::onLoadConfig(GWF_CONFIG_PATH);
require_once 'protected/install_scripts/install_wizard.inc.php';
require_once 'protected/install_scripts/install_functions.php';
require_once 'protected/install_scripts/install_config.php';
$server_root = str_replace('/protected', '', dirname(__FILE__));
GWF_Language::initEnglish();
GWF_Debug::setBasedir($server_root);
GWF_Log::init(false, true, $server_root.'/protected/logs');
$lang = new GWF_LangTrans('protected/install_lang/install');

if (isset($write_a_config))
{
	GWF_InstallConfig::writeConfig($lang);
	echo "I have written a default config to protected/config.php".PHP_EOL;
	echo "Please edit that config.php, before installing gwf3.".PHP_EOL;
	die(0);
}

if (false === gdo_db())
{
	echo 'Cannot connect to the database. Check your protected/config.php!'.PHP_EOL;
	die(1);
}


echo "Installing gwf util core...".PHP_EOL;
if (!install_core(false)) {
	echo 'Cannot install core... giving up!';
	die(2);
}

echo "Installing Language,Country,IP2Country...".PHP_EOL;
install_createLanguage(true, true, false);

echo "Installing all modules...".PHP_EOL;
echo install_all_modules(false);

echo "Thank you for trying GWF!".PHP_EOL;
die(0);
?>