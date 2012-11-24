<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <trigger|module> [<key>] [<value>]. Show or set channel configurations.',
	),
);

if (false === ($chan = Dog::getChannel()))
{
	return Dog::rply('err_only_channel');
}

$user = Dog::getUser();
$serv = Dog::getServer();
$chan = Dog::getChannel();
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 1)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->showConfigVarNames('c');
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
		||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->showConfigVarNames('c');
	}
}
elseif ($argc === 2)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->showConfigVar('c', $argv[1]);
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
			||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->showConfigVar('c', $argv[1]);
	}
}
elseif ($argc === 3)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->setConfigVar('c', $argv[1], $argv[2]);
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
			||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->setConfigVar('c', $argv[1], $argv[2]);
	}
}
else
{
	$plugin->showHelp();
}
?>
