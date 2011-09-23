<?php # Usage: %CMD% [command]. List all commands or show help for a command.

# Sort
if (!function_exists('lamb_help_sort_plugins'))
{
	function lamb_help_sort_plugins($a, $b)
	{
		return strcasecmp(substr($a,1), substr($b,1));
	}
}
# End of sort

# The plugin
$bot instanceof Lamb;
$user instanceof Lamb_User;
$server instanceof Lamb_Server;
$modules = $bot->getModules();

$b = chr(2);
$timeout = 120;
$username = $user->getName();

global $LAMB_HELP_FLOOD;
if (!isset($LAMB_HELP_FLOOD)) { $LAMB_HELP_FLOOD = array(); }

# Show all commands
if ($message === '')
{
	# FLOOD
	if (isset($LAMB_HELP_FLOOD[$username])) {
		if (time() > $LAMB_HELP_FLOOD[$username] + $timeout) {
			$LAMB_HELP_FLOOD[$username] = time();
		} else {
			$bot->reply('Your help flood was blocked.');
			return;
		}
	}
	else {
		$LAMB_HELP_FLOOD[$username] = time();
	}

	# Modules
	$modout = '';
	foreach ($modules as $module)
	{
		$module instanceof Lamb_Module;
		$commands = array();
		foreach (Lamb_User::$PRIVS as $priv)
		{
			if ( (!$server->isAdminUsername($username)) && !$user->hasPriviledge($priv) ) {
				continue;
			}
			$symbol = Lamb_User::priv2Symbol($priv);
			$triggers = $module->getTriggers($priv);
			sort($triggers);
			foreach ($triggers as $trigger)
			{
				$commands[] = $symbol.$trigger;
			}
		}
		if (count($commands) > 0)
		{
			$modout .= ', '.$b.$module->getName().$b.': '.implode(', ', $commands).'.';
		}
	}
	if ($modout !== '')
	{
		$server->sendPrivmsg($username, substr($modout, 2));
	}
	
	# Plugins
	$plugout = '';
	$dirs = Lamb::getPluginDirs();
	if (false === usort($dirs, 'lamb_help_sort_plugins')) {
		return $bot->reply('usort failed!');
	}
	foreach ($dirs as $fullpath)
	{
		if (Common::isDir($fullpath))
		{
			$dirname = basename($fullpath);
			$p = substr($dirname, 0, 1);
			$priv = Lamb_User::longPriv($p);
			$symbol = Lamb_User::priv2Symbol($priv);
			if ( (!$is_admin) && (!$user->hasPriviledge($priv)) ) {
				continue;
			}
			
			$out = '';
			$dir = dir($fullpath);
			$commands = array();
			while (false !== ($entry = $dir->read()))
			{
				if (strpos($entry, '.php') !== false)
				{
					$commands[] = substr($entry, 0, -4);
				}
			}
			$dir->close();
			
			if (count($commands) > 0)
			{
				sort($commands);
				$dirname = substr($dirname, 1);
				$plugout .= ", {$b}{$dirname}{$b}: ".implode(', ', $commands).'.';
			}
		}
	}
	
	if ($plugout !== '')
	{
		$server->sendPrivmsg($username, substr($plugout, 2));
	}
	
	return;
} # end of show all commands

# --- SNIP --- #
# Show single command
$command = Common::substrUntil($message, ' ');
$help = '';
foreach ($modules as $module)
{
	$module instanceof Lamb_Module;
	$h = $module->getHelp();
	if ( (isset($h[$command])) && ('' !== ($help = $h[$command])) )
//	if ('' !== ($help = $module->getHelp($command)))
	{
		break;
	}
}

if ($help === '')
{
	$command = str_replace(array('.', '/', '\\'), '', $command);
	
	foreach (Lamb::getPluginDirs() as $dirname)
	{
		$plugin_path = sprintf('%s/%s.php', $dirname, $command);
		if (Common::isFile($plugin_path))
		{
			$fh = fopen($plugin_path, 'r');
			$line = fgets($fh);
			fclose($fh);
			if ('' === ($help = trim(Common::substrFrom($line, '#', '')))) {
				if ('' === ($help = trim(Common::substrFrom($line, '//', '')))) {
					# no help in plugin/file.php
				}
			}
			break;
		}
	}
}

if ($help === '')
{
	$bot->reply(sprintf('The command \'%s\' is unknown or there is no help available.', $command));
	return;
}

//$help = str_replace('%TRIGGER%', LAMB_TRIGGER, $help);
$help = str_replace('%CMD%', LAMB_TRIGGER.$command, $help);
$bot->reply($help);

?>