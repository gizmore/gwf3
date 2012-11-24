<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<triggers>]. Show or set the triggers configured for this channel/server. Needs admin/ircop to set it. Use %CMD% default to switch back to defaults.',
		'chan' => 'This channel overrides triggers to %s.',
		'chan_by_serv' => 'This channel uses the triggers from the server: %s.',
		'chan_by_bot' => 'This channel uses the bot triggers: %s.',
		'serv' => 'This server overrides triggers to %s.',
		'serv_by_bot' => 'This server uses the bot triggers: %s.',
		'chan_to_default' => 'This channel now uses the server or %BOT% triggers.',
		'chan_to' => 'This channel now overrides triggers to %s.',
		'serv_to_default' => 'This server now uses the %BOT% triggers.',
		'serv_to' => 'This server now defaults triggers to %s.',
	),
);
$plugin = Dog::getPlugin();
$user = Dog::getUser();
$serv = Dog::getServer();
$chan = Dog::getChannel();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	if ($chan !== false)
	{
		if (NULL !== ($t = $chan->getTriggers()))
		{
			$plugin->rply('chan', array($t));
		}
		elseif (NULL !== ($t = $serv->getTriggers()))
		{
			$plugin->rply('chan_by_serv', array($t));
		}
		else
		{
			$plugin->rply('chan_by_bot', array(Dog_Init::getTriggers()));
		}
	}
	else
	{
		if (NULL !== ($t = $serv->getTriggers()))
		{
			$plugin->rply('serv', array($t));
		}
		else
		{
			$plugin->rply('serv_by_bot', array(Dog_Init::getTriggers()));
		}	
	}
}

elseif ($argc === 1)
{
	if ($chan !== false)
	{
		if ($argv[0] === 'default')
		{
			$chan->saveVar('chan_triggers', NULL);
			$plugin->rply('chan_to_default');
		}
		else
		{
			$chan->saveVar('chan_triggers', $argv[0]);
			$plugin->rply('chan_to', array($argv[0]));
		}
	}
	else
	{
		if (!Dog::hasPermission($serv, false, $user, 'i'))
		{
			Dog::noPermission('i');
		}
		elseif ($argv[0] === 'default')
		{
			$serv->saveVar('serv_triggers', NULL);
			$plugin->rply('serv_to_default');
		}
		else
		{
			$serv->saveVar('serv_triggers', $argv[0]);
			$plugin->rply('serv_to', array($argv[0]));
		}
	}
}

else
{
	$plugin->showHelp();
}
?>
