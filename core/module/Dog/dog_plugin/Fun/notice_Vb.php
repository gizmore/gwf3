<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <target> <message here...>. Send a NOTICE to the target. Admins can utilize this across networks. Staff can PRIVMS other users. Voice can only do this to channels.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% <Ziel> <Nachricht hier...>. Sendet eine "NOTICE" an das Ziel. Admins nutzen dies Netzwerkweit. Staff kann andere Nutzer anschreiben. Voice nur in einen Kanal.',
	),
);

$user = Dog::getUser();
$serv = Dog::getServer();
$plugin = Dog::getPlugin();
$message = $plugin->argv();
if (count($message) < 2)
{
	return $plugin->showHelp();
}
$arg = array_shift($message);
$message = implode(' ', $message);

# Admin
if (Dog::hasPermission($serv, false, $user, 'a'))
{
	if (false !== ($channel = Dog::getChannelByArg($arg)))
	{
		return $channel->sendNOTICE($message);
	}
	elseif (false !== ($tuser = Dog::getUserByArg($arg)))
	{
		return $tuser->sendNOTICE($message);
	}
}

# Staff
elseif (DOG::hasPermission($serv, false, $user, 's'))
{
	if (false !== ($channel = $serv->getChannelByName($arg)))
	{
		return $channel->sendNOTICE($message);
	}
	elseif (false !== ($tuser = $serv->getUserByName($arg)))
	{
		return $tuser->sendNOTICE($message);
	}
}

# Voice
else
{
	if (false !== ($channel = $serv->getChannelByName($arg)))
	{
		return $channel->sendNOTICE($message);
	}
}

# Errors
if   ( (false !== ($channel = Dog::getChannelByArg($arg)))
	 ||(false !== ($tuser = Dog::getUserByArg($arg))) )
{
	return Dog::noPermission('a');
}
else
{
	return Dog::rply('err_target');
}
?>
