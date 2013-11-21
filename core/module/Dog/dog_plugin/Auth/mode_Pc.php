<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<user>]. Show the irc modes for a user for debugging purposes.',
		'priv' => '%s has the %s irc modes in this channel, according to my memory.',
	),
);

$plug = Dog::getPlugin();
$chan = Dog::getChannel();
$argv = $plug->argv();
$argc = count($argv);
if ($argc === 0)
{
	$user = Dog::getUser();
}
else if ($argc === 1)
{
	if (false === ($user = Dog::getUserByArg($argv[0])))
	{
		return Dog::rply('err_user');
	}
}
else
{
	return $plug->showHelp();
}

$priv = $chan->getPriv($user);

$plug->rply('priv', array($user->getName(), $priv));
