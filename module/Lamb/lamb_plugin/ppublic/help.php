<?php # Usage: %TRIGGER%help [command]. List all commands or show help for a command.
$modules = $bot->getModules();
$user instanceof Lamb_User;
$server instanceof Lamb_Server;
$b = chr(2);
$timeout = 600;
$username = $user->getName();

global $LAMB_HELP_FLOOD;
if (!isset($LAMB_HELP_FLOOD)) { $LAMB_HELP_FLOOD = array(); }

if ($message === '')
{
	# FLOOD
	if (isset($LAMB_HELP_FLOOD[$username])) {
		if (time() > $LAMB_HELP_FLOOD[$username] + $timeout) {
			$LAMB_HELP_FLOOD[$username] = time();
		} else {
			echo "BLOCKED HELP FLOOD!\n";
			return;
		}
	}
	else {
		$LAMB_HELP_FLOOD[$username] = time();
	}
	
	foreach ($modules as $module)
	{
		$module instanceof Lamb_Module;
		$out = $b.$module->getName().$b.': ';
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
			$out .= implode(', ', $commands);
			$server->reply($username, $out);
		}		
	}
	
	foreach (Lamb::getPluginDirs() as $fullpath)
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
				$server->reply($username, "[$p]$b$dirname$b: ".implode(', ', $commands));
			}
		}
	}
	return;
}

$command = Common::substrUntil($message, ' ');
$help = '';
foreach ($modules as $module)
{
	$module instanceof Lamb_Module;
	if ('' !== ($help = $module->getHelp($command))) {
		break;
	}
}

if ($help === '')
{
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

$help = str_replace('%TRIGGER%', LAMB_TRIGGER, $help);
$bot->reply($help);
?>