<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <command>. When called in a channel, it will disable a command there. If called in private it will disable the command on this server or a different channel.',
		'plg_on_serv' => 'The %s plugin has been disabled on %s.',
		'trg_on_serv' => 'The %s function in module %s has been disabled on %s.',
		'mod_on_serv' => 'The %s module has been disabled on %s.',
		'plg_on_chan' => 'The %s plugin has been disabled in %s.',
		'trg_on_chan' => 'The %s function in module %s has been disabled in %s.',
		'mod_on_chan' => 'The %s module has been disabled in %s',
		'core_plugin' => 'You cannot disable the %s functionality.',
	),
);

$coreplugs = array('enable');

$plugin = Dog::getPlugin();
$serv = Dog::getServer();
$sid = $serv->getID();
$chan = Dog::getChannel();
$user = Dog::getUser();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc !== 1)
{
	return $plugin->showHelp();
}

$name = strtolower($argv[0]);

# Block important core plugins from beeing disabled.
if (in_array($name, $coreplugs, true))
{
	$plugin->rply('core_plugin', array($name));
}

# PRIVMSG admin block
elseif ($chan === false)
{
	if (!Dog::hasPermission($serv, false, $user, 'a'))
	{
		Dog::noPermission('a');
	}
	elseif (false !== ($plug = Dog_Plugin::getPlug()))
	{
		Dog_Conf_Plug_Serv::setDisabled($plug->getName(), $sid, '1');
		$plugin->rply('plg_on_serv', array($name, $serv->displayName()));
	}
	elseif (false !== ($mod = Dog_Module::getByName($name)))
	{
		Dog_Conf_Mod_Serv::setModuleDisabled($mod->getName(), $sid, $name, '1');
		$plugin->rply('mod_on_serv', array($mod->displayName(), $serv->displayName()));
	}
	elseif (false !== ($mod = Dog_Module::getByTrigger($name)))
	{
		Dog_Conf_Mod_Serv::setTriggerDisabled($mod->getName(), $sid, $name, '1');
		$plugin->rply('trg_on_serv', array($name, $mod->displayName(), $serv->displayName()));
	}
	else
	{
		Dog::rply('err_command');
	}
}

# Staff disable in channel
else
{
	$cid = $chan->getID();
	if (!Dog::hasPermission($serv, $chan, $user, 's'))
	{
		return Dog::noPermission('s');
	}
	elseif (false !== ($plug = Dog_Plugin::getPlug($name)))
	{
		Dog_Conf_Plug_Chan::setDisabled($plug->getName(), $cid, '1');
		$plugin->rply('plg_on_chan', array($name, $chan->displayLongName()));
	}
	elseif (false !== ($mod = Dog_Module::getByName($name)))
	{
		Dog_Conf_Mod_Chan::setModuleDisabled($mod->getName(), $cid, '1');
		$plugin->rply('mod_on_chan', array($mod->displayName(), $chan->displayLongName()));
	}
	elseif (false !== ($mod = Dog_Module::getByTrigger($name)))
	{
		Dog_Conf_Mod_Chan::setTriggerDisabled($mod->getName(), $cid, $name, '1');
		$plugin->rply('trg_on_chan', array($name, $mod->displayName(), $chan->displayLongName()));
	}
	else
	{
		Dog::rply('err_command');
	}
}
?>
