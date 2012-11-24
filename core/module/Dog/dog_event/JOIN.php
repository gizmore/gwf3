<?php # :Dog!Dawg@localhost JOIN :#sr
$msg = Dog::getIRCMsg();
$serv = Dog::getServer();

if (false === ($user = Dog::getOrCreateUser()))
{
	return Dog_Log::critical("Cannot create user!");
}

$serv->addUser($user);

if (false === Dog::setupUser())
{
	return Dog_Log::critical('Cannot setup user!');
}

$chan_name = $msg->getArg(0);

if (false === ($channel = $serv->getChannelByName($chan_name)))
{
	if (false === ($channel = Dog_Channel::getOrCreate($serv, $chan_name)))
	{
		return;
	}
	$serv->addChannel($channel);
}

$channel->addUser($user);

if (false === Dog::setupChannel())
{
	Dog_Log::critical('Cannot setup channel.');
}
?>
