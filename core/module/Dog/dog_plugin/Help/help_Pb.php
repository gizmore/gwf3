<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<command>]. Show all commands in this context or the help for a %BOT% command. Register in private with %BOT% to see more commands.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% [<command>]. Zeige alle Befehle in diesem Kontext oder die Hilfe für einen %BOT% Befehl. Registriere dich im query mit %BOT% um mehr Befehle zu sehen.',
	),
);

$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

global $DPH_ALL;
$DPH_ALL = array();

if (!function_exists('dogplug_help_all'))
{
	function dogplug_help_all($entry, $fullpath, $cutlen)
	{
		global $DPH_ALL;
		$priv = $entry[0];
		$chan = Dog::getChannel();
		$serv = Dog::getServer();
		$user = Dog::getUser();
		$name = substr($entry, 0, -7);
		if (  (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $name)))
			&&($plug->isEnabled($serv, $chan)) )
		{
			$dir = substr($fullpath, $cutlen);
			$dir = substr($dir, 0, strrpos($dir, '/'));
			if (!isset($DPH_ALL[$dir]))
			{
				$DPH_ALL[$dir] = array();
			}
			if (!array_search($name, $DPH_ALL[$dir], true))
			{
				$DPH_ALL[$dir][] = $name;
			}
		}
	}
}

if ($argc === 0)
{
	# Modules
	$out = '';
	$modules = Dog_Module::getModules();
	ksort($modules);
	foreach ($modules as $module)
	{
		$module instanceof Dog_Module;
		$triggers = $module->getFilteredTriggers(Dog::getServer(), Dog::getChannel(), Dog::getUser());
		if (count($triggers) > 0)
		{
			sort($triggers);
			$out .= ' '.chr(2).$module->getName().chr(2).': ';
			$out .= implode(', ', $triggers);
			$out .= '.';
		}
	}
	$user = Dog::getUser();
	$user->sendNOTICE(substr($out, 1));
	
	# Plugins
	$out = '';
	$plugdir = Dog_Plugin::getPlugDir();
	GWF_File::filewalker($plugdir, 'dogplug_help_all', false, true, strlen($plugdir)+1);
	ksort($DPH_ALL);
	foreach ($DPH_ALL as $folder => $commands)
	{
		sort($commands);
		$out .= ' '.chr(2).$folder.chr(2).': ';
		$out .= implode(', ', $commands);
		$out .= '.';
	}
	$user->sendNOTICE(substr($out, 1));
}

elseif ($argc === 1)
{
	if (false !== ($plug = Dog_Plugin::getPlug($argv[0])))
// 	if (false !== ($plug = Dog_Plugin::getPlugWithPerms(Dog::getServer(), Dog::getChannel(), Dog::getUser(), $argv[0])))
	{
		$plugin->reply($plug->getHelp());
	}
	elseif (false !== ($mod = Dog_Module::getByTrigger($argv[0])))
// 	elseif (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger(Dog::getServer(), Dog::getChannel(), Dog::getUser(), $argv[0])))
	{
		$plugin->reply($mod->getHelp($argv[0]));
	}
	else
	{
		Dog::rply('err_command');
	}
}

else
{
	$plugin->showHelp();
}
