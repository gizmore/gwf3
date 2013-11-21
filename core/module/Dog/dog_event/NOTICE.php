<?php
if (false === ($user = Dog::getOrCreateUser()))
{
	return;
}
$serv = Dog::getServer();
$serv->addUser($user);
$user = Dog::setupUser();
$chan = Dog::setupChannel();
$msg = Dog::getIRCMsg()->getArg(0);
if ($user !== false)
{
	Dog_Log::user($user, $msg);
}
if ($chan !== false)
{
	Dog_Log::channel($chan, $msg);
}
