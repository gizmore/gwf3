<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<on|off|default>]',
		'serv_on' => 'This server has set it´s logging to explicit enabled.',
		'serv_off' => 'This server has set it´s logging to explicit disabled.',
		'serv_default' => 'This server has set it´s logging to %BOT% settings.',
		'chan_on' => 'This channel has set it´s logging to explicit enabled.',
		'chan_off' => 'This channel has set it´s logging to explicit disabled.',
		'chan_default' => 'This channel has set it´s logging to %BOT% settings.',
	),
);

$plugin = Dog::getPlugin();

$argv = $plugin->argv();
$argc = count($argv);

if ( ($argc > 1) || ($argc === 1 && !in_array($argv[0], array('on', 'off', 'default'))) )
{
	return $plugin->showHelp();
}

$serv = Dog::getServer();

if (false !== ($chan = Dog::getChannel()))
{
	if ($argc === 0)
	{
		if ($chan->isOptionEnabled(Dog_Channel::LOGGING_ON))
		{
			$plugin->rply('chan_on');
		}
		elseif ($chan->isOptionEnabled(Dog_Channel::LOGGING_OFF))
		{
			$plugin->rply('chan_off');
		}
		else
		{
			$plugin->rply('chan_default');
		}
	}
	else
	{
		$chan->saveOption(Dog_Channel::LOGBITS, false);
		if ($argv[0] === 'on')
		{
			$chan->saveOption(Dog_Channel::LOGGING_ON, true);
		}
		elseif ($argv[0] === 'off')
		{
			$chan->saveOption(Dog_Channel::LOGGING_OFF, true);
		}
	}
}
else
{
	if ($argc === 1)
	{
		$serv->saveOption(Dog_Server::LOGBITS, false);
		if ($argv[0] === 'on')
		{
			$serv->saveOption(Dog_Server::LOGGING_ON, true);
		}
		elseif ($argv[0] === 'off')
		{
			$serv->saveOption(Dog_Server::LOGGING_OFF, true);
		}
	}
}

if ($argc === 0)
{
	if ($serv->isOptionEnabled(Dog_Server::LOGGING_ON))
	{
		$plugin->rply('serv_on');
	}
	elseif ($serv->isOptionEnabled(Dog_Server::LOGGING_OFF))
	{
		$plugin->rply('serv_off');
	}
	else
	{
		$plugin->rply('serv_default');
	}
}

?>
