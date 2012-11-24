<?php # :gizmore!gizmore@localhost PRIVMSG Dog :.join #sr
if (false === ($user = Dog::getOrCreateUser()))
{
	return;
}
$serv = Dog::getServer();
$serv->addUser($user);
$chan = Dog::setupChannel();
$user = Dog::setupUser();

# Log PRIVMSGs
$msg = Dog::getIRCMsg()->getArg(1);
Dog_Log::user($user, $msg);
Dog_Log::channel($chan, $msg);

# Exec Stuff
if (!$user->isBot())
{
	if ('' !== ($trigger = Common::substrUntil($msg, ' ')))
	{
		if (Dog_Init::isTrigger($serv, $chan, $trigger[0]))
		{
			Dog::setTriggered();
			$trigger = substr($trigger, 1);
			if (false !== ($plug = Dog_Plugin::getPlugWithPerms($serv, $chan, $user, $trigger)))
			{
				if ($plug->isEnabled($serv, $chan))
				{
					$plug->execute();
				}
			}
			elseif (false !== ($mod = Dog_Module::getModuleWithPermsByTrigger($serv, $chan, $user, $trigger)))
			{
				if ($mod->isTriggerEnabled($serv, $chan, $trigger))
				{
					$mod->execute($trigger);
				}
			}
		}
	}
	
	if ( (Common::startsWith($msg, "\X01")) && (Common::endsWith($msg, "\X01")) )
	{
		require 'CTCP.php';
	}
}
?>
