<?php # :irc.giz.org 001 Dog :Welcome to the gizmore IRC Network Dog!Dawg@localhost
# Set bot mode
$server = Dog::getServer();
$nick = Dog::getNickname();

Dog::getOrCreateUserByName(Dog::argv(0));

$server->sendRAW("MODE {$nick} +b");
$server->sendRAW("MODE {$nick} +B");

if (false !== ($connector = $server->getVarDefault('dog_connector', false)))
{
	$server->unsetVar('dog_connector');
	$connector instanceof Dog_User;
	$connector->sendPRIVMSG(Dog::lang('msg_connected', array($server->displayLongName(), Dog::getNickname(), $server->getConf('ircoppass'))));
}

$server->saveOption(Dog_Server::HAS_CONNECTED_ONCE);

if (NULL !== ($pass = $server->getNick()->getPass()))
{
	$server->sendPRIVMSG('NickServ', 'IDENTIFY '.$pass);
}
?>
