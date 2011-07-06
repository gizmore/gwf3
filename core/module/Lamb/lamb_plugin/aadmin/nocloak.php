<?php # usage: %CMD% <true|false|detect|show>. Administrate the IP cloaking mode for this server. 
$bot instanceof Lamb;
$server instanceof Lamb_Server;

##############
### Toggle ###
##############
switch ($message)
{
	case 'true': 
		$server->saveOption(Lamb_Server::NO_CLOAK, true);
		break;
		
	case 'false':
		$server->saveOption(Lamb_Server::NO_CLOAK, false);
		break;
		
	case 'detect':
		$bot->reply('Auto detection of cloakmode is not implemented yet.');
		return;
		
	case 'show':
		# No change.
		break;
		
	# Oops error!
	default:
		$bot->reply($bot->getHelp('logging'));
		return;
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
