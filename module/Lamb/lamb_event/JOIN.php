<?php
$server instanceof Lamb_Server;
$channel_name = $args[0];

if (false === ($channel = $server->getOrCreateChannel($channel_name))) {
	Lamb_Log::log(sprintf('events/JOIN.php: getOrCreateChannel() $channel_name='.$channel_name));
	return;
}

if (false === ($user = $server->getUserFromOrigin($from))) {
	Lamb_Log::log(sprintf('events/JOIN.php: getUserFromOrigin() $from='.$from));
	return;
}

$channel->addUser($user);

if ($user->getName() !== $server->getBotsNickname())
{
	foreach ($bot->getModules() as $module)
	{
		$module instanceof Lamb_Module;
		$module->onJoin($server, $user, $channel);
	}
}

//$char = '';
//switch($user->getOptions()&Lamb_User::USERMODE_FLAGS)
//{
//	case Lamb_User::ADMIN:
//	case Lamb_User::STAFF:
//	case Lamb_User::OPERATOR: $char = 'o'; break;
//	case Lamb_User::HALFOP: $char = 'h'; break;
//	case Lamb_User::VOICE: $char = 'v'; break;
//	default: Lamb_Log::log(sprintf('Unknown usermode flag: %08x', 0)); break;
//}
//if ($char !== '') {
//	
//}
?>
