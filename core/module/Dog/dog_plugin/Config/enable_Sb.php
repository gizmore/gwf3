<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <command>. When called in a channel, it will enable a command. If called in private it will allow the command on this server.',
		'plg_on_serv' => 'The %s plugin has been unlocked on %s.',
		'trg_on_serv' => 'The %s function in module %s has been unlocked on %s.',
		'mod_on_serv' => 'The %s module has been unlocked on %s.',
		'plg_on_chan' => 'The %s plugin has been enabled in %s.',
		'trg_on_chan' => 'The %s function in module %s has been enabled in %s.',
		'mod_on_chan' => 'The %s module has been enabled in %s',
	),
);

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

$name = $argv[0];

# PRIVMSG admin unlock
if ($chan === false)
{
	if (!Dog::hasPermission($serv, false, $user, 'a'))
	{
		return Dog::noPermission('a');
	}
	
	if (false !== ($plug = Dog_Plugin::getPlug($name)))
	{
		Dog_Conf_Plug_Serv::setDisabled($plug->getName(), $sid, false);
		$plugin->rply('plg_on_serv', array($name, $serv->displayName()));
	}
	
	if (false !== ($mod = Dog_Module::getByTrigger($name)))
	{
		Dog_Conf_Mod_Serv::setTriggerDisabled($mod->getName(), $sid, $name, false);
		$plugin->rply('trg_on_serv', array($name, $mod->displayName(), $serv->displayName()));
	}
	
	if (false !== ($mod = Dog_Module::getByName($name)))
	{
		Dog_Conf_Mod_Serv::setModuleDisabled($mod->getName(), $sid, false);
		$plugin->rply('mod_on_serv', array($mod->displayName(), $serv->displayName()));
	}
	
// 	else
// 	{
// 		Dog::rply('err_command');
// 	}
}

# staff enable in channel
else
{
	$cid = $chan->getID();
	if (!Dog::hasPermission($serv, $chan, $user, 's'))
	{
		return Dog::noPermission('s');
	}

	if (false !== ($plug = Dog_Plugin::getPlug($name)))
	{
		Dog_Conf_Plug_Chan::setDisabled($plug->getName(), $cid, false);
		$plugin->rply('plg_on_chan', array($name, $chan->displayLongName()));
	}
	
	if (false !== ($mod = Dog_Module::getByTrigger($name)))
	{
		Dog_Conf_Mod_Chan::setTriggerDisabled($mod->getName(), $cid, $name, false);
		$plugin->rply('trg_on_chan', array($name, $mod->displayName(), $chan->displayLongName()));
	}
	
	if (false !== ($mod = Dog_Module::getByName($name)))
	{
		Dog_Conf_Mod_Chan::setModuleDisabled($mod->getName(), $cid, false);
		$plugin->rply('mod_on_chan', array($mod->displayName(), $chan->displayLongName()));
	}
	
// 	else
// 	{
// 		Dog::rply('err_command');
// 	}
}
?>
