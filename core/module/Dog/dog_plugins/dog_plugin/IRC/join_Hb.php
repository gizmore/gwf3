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

if (false === ($server = Dog::getServerBySuffix($arg)))
{
	return $plugin->rply('unknown_serv');
}

if (false !== ($channel = Dog::getChannelByArg($arg)))
{
	return $plugin->rply('already');
}

$chan_name = Common::substrUntil($arg, '!', $arg);

if (false === ($channel = Dog_Channel::getOrCreate($server, $chan_name)))
{
	return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
}

$plugin->rply('trying');

$channel->saveOption(Dog_Channel::AUTO_JOIN, true);	

$server->joinChannel($channel);
?>
