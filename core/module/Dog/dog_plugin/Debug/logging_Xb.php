<?php
$lang = array(
	'en' => array(
		'help' => 'usage: %CMD% [<[<channel>!]SID>] <on|off|default|show>. Set the logging mode for a channel or server. Default will make it fallback to value in server/%BOT% config.',
	),
);

$plugin = Dog::getPlugin();
$argv = $plugin->argv();

if ($argc === 1)
{
	$action = $argv[0];
	if (false === ($target = Dog::getChannel()))
	{
		$target = Dog::getServer();
	}
}
elseif ($argc === 2)
{
	$action = $argv[1];
	if (false === ($target = Dog::getOrLoadChannelByArg($argv[0])))
	{
		if (false === ($target = Dog::getServerBySuffix($argv[0])))
		{
			return $plugin->rply('err_target');
		}
	}
}
else
{
	return $plugin->showHelp();
}

switch ($action)
{
	case 'on':
		$target->setLogging(1);
		return $plugin->rply('enabled', array($target->displayLongName()));

	case 'off':
		$target->setLogging(0);
		return $plugin->rply('disabled', array($target->displayLongName()));

	case 'default':
		$target->setLogging(NULL);
		return $plugin->rply('defaults', array($target->displayLongName()));

	case 'show':
		# No change.
		break;

		# Oops error!
	default:
		return $plugin->showHelp();
}


?>
