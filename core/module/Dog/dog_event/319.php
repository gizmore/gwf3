<?php # :irc.gizmore.org 319 Dog gizmore :~#wechall ~#shadowlamb ~#sr 
# WHOIS CHANNELS / PERMS
$msg = Dog::getIRCMsg();
if (false === ($user = Dog::getOrCreateUserByName($msg->getArg(1))))
{
	return Dog::suppressModules();
}
Dog::setUser($user);

$server instanceof Dog_Server;
foreach (explode(' ', $msg->getArg(2)) as $chan_name)
{
	echo "$chan_name\n";
// 	$symbols = Dog_IRCPriv::matchSymbols($chan_name);
// 	$chan_name = Dog_IRCPriv::trimSymbols($chan_name);
// 	if (false !== ($channel = $server->getChannelByName($chan_name)))
// 	{
// 		$channel->addUser($user, $symbols);
// 	}
}
