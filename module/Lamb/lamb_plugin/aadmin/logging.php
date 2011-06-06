<?php # usage: %CMD% <on|off|default|show>. Set the logging mode for this server. Default will make the server fallback to value in lamb config. 
$bot instanceof Lamb;
$server instanceof Lamb_Server;
##############
### Toggle ###
##############
switch ($message)
{
	case 'on': 
		$server->saveOption(Lamb_Server::LOG_ON, true);
		$server->saveOption(Lamb_Server::LOG_OFF, false);
		break;
		
	case 'off':
		$server->saveOption(Lamb_Server::LOG_ON, false);
		$server->saveOption(Lamb_Server::LOG_OFF, true);
		break;
		
	case 'default':
		$server->saveOption(Lamb_Server::LOG_ON, false);
		$server->saveOption(Lamb_Server::LOG_OFF, false);
		break;
		
	case 'show':
		# No change.
		break;
		
	# Oops error!
	default:
		return $bot->getHelp('logging');
}

############
### Show ###
############

# Style
if ($server->isOptionEnabled(Lamb_Server::LOG_ON))
{
	$style = 'force enabled';
}
elseif ($server->isOptionEnabled(Lamb_Server::LOG_OFF))
{
	$style = 'force disabled';
}
elseif (LAMB_LOGGING)
{
	$style = 'default enabled';
}
else
{
	$style = 'default disabled';
}

# Output
$bot->reply(sprintf('Server %d(%s) has logging set to %s.', $server->getID(), $server->getHostname(), $style));
?>
