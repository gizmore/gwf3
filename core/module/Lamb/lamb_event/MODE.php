<?php
$server instanceof Lamb_Server;
//$orig_user = $server->getUserFromOrigin($from);

switch (count($args))
{
	case 2: # Set mode for user
		if (false !== ($user = $server->getUserByNickname($args[0]))) {
		}
		break;
	case 3: # Set mode for channel
		if (false !== ($chan = $server->getOrCreateChannel($args[0])))
		{
			if (false !== ($chan->isUserInChannel($args[2])))
			{
				$chan->setUserMode($args[2], $args[1]);
			}
		}
		break;
}
?>