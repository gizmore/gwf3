<?php # PING :irc.giz.org
$serv = Dog::getServer();
$serv->sendRAW('PONG '.Dog::argv(0), false);
#echo $serv->getNick()->getNick().PHP_EOL;
// if ($serv->getID()==58)
// {
//     $channel = Dog_Channel::getOrCreate($serv, '#lamb3_chatbot');
//     $serv->joinChannel($channel);
// }