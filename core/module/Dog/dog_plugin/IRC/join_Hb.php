<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <channel>[!<SID>]. Try to join a channel.',
		'already' => 'I am already on that channel.',
		'trying' => 'Trying to join this channel.',
		'unknown_serv' => 'This server is unknown.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% <Kanal>[!<SID>]. Versucht einem Kanal beizutreten.',
		'already' => 'Ich bin schon in diesem Kanal.',
		'trying' => 'Es wird versucht dem Kanal beizutreten.',
		'unknown_serv' => 'Dieser Server ist nicht vorhanden.',
	),
);
$plugin = Dog::getPlugin();

if ($plugin->argc() !== 1)
{
	return $plugin->showHelp();
}

$arg = $plugin->argv(0);
if (false !== ($channel = Dog::getChannelByArg($arg)))
{
	return $plugin->rply('already');
}
if (false === ($server = Dog::getServerBySuffix($arg)))
{
	return $plugin->rply('unknown_serv');
}

$plugin->rply('trying');

$channel = new Dog_Channel(array(
	'chan_id' => '0',
	'chan_sid' => $server->getID(),
	'chan_name' => Common::substrUntil($arg, '!'),
	'chan_lang' => $server->getLangISO(),
	'chan_pass' => NULL,
	'chan_modes' => '',
	'chan_triggers' => NULL,
	'chan_options' => Dog_Channel::DEFAULT_OPTIONS,
));

$server->joinChannel($channel);
?>
