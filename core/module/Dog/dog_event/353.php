<?php # :irc.giz.org 353 Dog = #sr :@gizmore Dog 
$msg = Dog::getIRCMsg();
$serv = Dog::getServer();
$chan_name = $msg->getArg(2);
if (false === ($channel = $serv->getChannelByName($chan_name)))
{
	return;
}

$sid = $serv->getID();
foreach (explode(' ', $msg->getArg(3)) as $username)
{
	if (false !== ($user = Dog::getOrCreateUserByName(ltrim($username, Dog_IRCPriv::allSymbols()))))
	{
		$serv->addUser($user);
		$channel->addUser($user, Dog_IRCPriv::matchSymbols($username));
	}
}
