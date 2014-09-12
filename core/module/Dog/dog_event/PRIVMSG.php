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
	return Dog::suppressModules();
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
			if ($user->isFlooding())
			{
				return;
			}
	
			Dog::setTriggered();
			$trigger = substr($trigger, 1);
			if (false !== ($plug = Dog_Plugin::getPlug($trigger)))
			{
				if (!$plug->isInScope($serv, $chan))
				{
					Dog::scopeError($plug->getScope());
				}
				elseif (!$plug->hasPermission($serv, $chan, $user))
				{
					Dog::permissionError($plug->getPriv());
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
				if (!$mod->hasScopeFor($trigger, $serv, $chan))
				{
					Dog::scopeError($mod->getScope($trigger));
				}
				if (!$mod->hasPermissionFor($trigger, $serv, $chan, $user))
				{
					Dog::permissionError($mod->getPriv($trigger));
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
			
			else
			{
// 				Dog::rply('err_command');
			}
		}
	}
	
	elseif ( (Common::startsWith($msg, "\X01")) && (Common::endsWith($msg, "\X01")) )
	{
		require 'CTCP.php';
	}
	
	else
	{
		$msg = preg_replace('[^a-z]', '', $msg);
		if ($msg === 'wechallnetISUP')
		{
			Dog::reply('Yay \o/');
		}
		elseif ($msg === 'wechallnetISUP')
		{
			Dog::reply('NO! :(');
		}
	}
}
