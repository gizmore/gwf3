<?php # :gizmore!gizmore@localhost PRIVMSG Dog :.join #sr
if (false === ($user = Dog::getOrCreateUser()))
{
	return;
}
$serv = Dog::getServer();
$serv->addUser($user);
$user = Dog::setupUser();
$chan = Dog::setupChannel();

if ($user === false)
{
	return;
}

# Log PRIVMSGs
$msg = Dog::getIRCMsg()->getArg(1);
if (Dog::getIRCMsg()->shouldLog())
{
	Dog_Log::user($user, $msg);
	Dog_Log::channel($chan, $msg);
}

# Exec Stuff
if (!$user->isBot())
{
	if ('' !== ($trigger = Common::substrUntil($msg, ' ')))
	{
		if (Dog_Init::isTrigger($serv, $chan, $trigger[0]))
		{
			Dog::setTriggered();
			$trigger = substr($trigger, 1);
			if (false !== ($plug = Dog_Plugin::getPlug($trigger)))
			{
				if (!$plug->hasPermission($serv, $chan, $user))
				{
					Dog::rply('err_no_perm');
				}
				elseif (!$plug->isEnabled($serv, $chan))
				{
					Dog::rply('err_disabled');
				}
				else
				{
					$plug->execute();
				}
			}
			
			elseif (false !== ($mod = Dog_Module::getByTrigger($trigger)))
			{
				if (!$mod->hasPermissionFor($trigger, $serv, $chan, $user))
				{
					Dog::rply('err_no_perm');
				}
				elseif (!$mod->isTriggerEnabled($serv, $chan, $trigger))
				{
					Dog::rply('err_disabled');
				}
				else
				{
					$mod->execute($trigger);
				}
			}
		}
	}
	
	elseif ( (Common::startsWith($msg, "\X01")) && (Common::endsWith($msg, "\X01")) )
	{
		require 'CTCP.php';
	}
}
