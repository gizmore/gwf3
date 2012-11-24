<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <trigger|module> [<key>] [<value>]. Show or set server configurations.',
	),
);

$user = Dog::getUser();
$chan = Dog::getChannel();
$serv = Dog::getServer();
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

var_dump($argv);

if ($argc === 1)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		echo 'AAA';
		$plug->showConfigVarNames('s');
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
		||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->showConfigVarNames('s');
	}
}
elseif ($argc === 2)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->showConfigVar('s', $argv[1]);
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
			||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->showConfigVar('s', $argv[1]);
	}
}
elseif ($argc === 3)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->setConfigVar('s', $argv[1], $argv[2]);
	}
	if (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
			||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->setConfigVar('s', $argv[1], $argv[2]);
	}
}
else
{
	$plugin->showHelp();
}
?>
