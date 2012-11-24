<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<channel>[!<SID>]]. Command %BOT% to leave a channel. IRCOps can utilize this across networks.',
		'not_there' => 'The channel you are trying to leave ist not occupied by %BOT% at all.',
		'parting' => 'I am leaving %s now, and won´t come back on my own.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% [<Kanal>[!<SID>]]. Befehle %BOT% einen Kanal zu verlassen. IRCOps können dies Netzwerkübergreifend erledigen.',
		'not_there' => 'Der Kanal den Du verlassen möchtest wird ist %BOT% zur Zeit unbekannt.',
		'parting' => 'Ich verlasse nun %s und komme auch nicht von selbst wieder.',
	),
);
$plugin = Dog::getPlugin();
$serv = Dog::getServer();
$user = Dog::getUser();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc === 0)
{
	if (false === ($channel = Dog::getChannel()))
	{
		return $plugin->showHelp();
	}
}

elseif ($argc === 1)
{
	if (false === ($channel = Dog::getChannelByArg($argv[0])))
	{
		return $plugin->rply('not_there');
	}
	if ($channel->getSID() !== $serv->getID())
	{
		if (!Dog::hasPermission($serv, false, $user, 'i'))
		{
			return Dog::noPermission('i');
		}
	}
}

else
{
	return $plugin->showHelp();
}

# Do it!
$channel->saveOption(Dog_Channel::AUTO_JOIN, false);
$plugin->rply('parting', array($channel->displayLongName()));
$serv->partChannel($channel);
?>
