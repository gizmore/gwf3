<?php # :gizmore!gizmore@localhost KICK #sr Dog :gizmore
Dog::setupUser();
$server = Dog::getServer();
$channel = Dog::setupChannel();
if (false !== ($user = Dog::getOrLoadUserByArg(Dog::argv(1))))
{
	$channel->removeUser($user);
}

if (Dog::getNickname() === $user->getName())
{
	$server->removeChannel($channel);
}

?>
