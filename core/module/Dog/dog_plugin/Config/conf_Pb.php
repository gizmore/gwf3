<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <command|module> [<key>] [<value>]. Show or change settings for your user.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% <Befehl|Modul> [<Variable>] [<Wert>]. Zeige oder ändere Einstellungen für deinen Benutzer.',
	),
);
$user = Dog::getUser();
$chan = Dog::getChannel();
$serv = Dog::getServer();
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);
if ($argc === 1)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->showConfigVarNames('u');
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
		||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->showConfigVarNames('u');
	}
}
elseif ($argc === 2)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->showConfigVar('u', $argv[1]);
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
		||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->showConfigVar('u', $argv[1]);
	}
}
elseif ($argc === 3)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->setConfigVar('u', $argv[1], $argv[2]);
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
		||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->setConfigVar('u', $argv[1], $argv[2]);
	}
}
else
{
	$plugin->showHelp();
}
?>
