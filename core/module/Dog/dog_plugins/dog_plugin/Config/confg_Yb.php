<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <trigger|module> [<key>] [<value>]. Show or set global configurations.',
	),
);

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
		$plug->showConfigVarNames('g');
	}
	elseif (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
		||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->showConfigVarNames('g');
	}
	else
	{
		Dog::rply('err_command');
	}
}
elseif ($argc === 2)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->showConfigVar('g', $argv[1]);
	}
	elseif (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
			||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->showConfigVar('g', $argv[1]);
	}
	else
	{
		Dog::rply('err_unk_var');
	}
	
}
elseif ($argc === 3)
{
	$name = $argv[0];
	if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
	{
		$plug->setConfigVar('g', $argv[1], $argv[2]);
	}
	elseif (  (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $name)))
			||(false !== ($mod = Dog_Module::getByName($name))) )
	{
		$mod->setConfigVar('g', $argv[1], $argv[2]);
	}
	else
	{
		Dog::rply('err_unk_var');
	}
}
else
{
	$plugin->showHelp();
}
?>
