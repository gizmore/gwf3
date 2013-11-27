<?php
/**
 * The classical !seen module.
 * Doggy style ;)
 * @author gizmore
 */
final class DOGMOD_Seen extends Dog_Module
{
	/**
	 * We hook into PRIVMSG to record activity.
	 */
	public function event_privmsg()
	{
		if (!Dog::isTriggered())
		{
			if (false !== Dog::getUser())
			{
				Dog_Seen::record(Dog::getUser(), Dog::getChannel(), 'privmsg', $this->msg());
			}
		}
	}
	
	/**
	 * We got triggered by !seen.
	 */
	public function on_seen_Pb()
	{
		$argv = $this->argv();
		$argc = count($argv);
		
		if ($argc === 1)
		{
			if (!preg_match('/^[a-z0-9_!]+$/iD', $argv[0]))
			{
				return Dog::rply('err_user');
			}
		
			if (false === ($server = Dog::getServerBySuffix($argv[0])))
			{
				return Dog::rply('err_server');
			}
			
			if (false === ($user = Dog_User::getByLongName($argv[0])))
			{
				return Dog::rply('err_user');
			}
			
			if (false === ($seen = Dog_Seen::getSeen($user)))
			{
				return $this->rply('never', array($user->displayName()));
			}
			
			$channel = $seen->getChannel();
			$channam = $channel === false ? '!NOCHAN!' : $channel->displayName();
					
			$this->rply($seen->getEvent(), array(
				$user->displayName(), $server->displayName(), $channam,
				$seen->displayDate(), $seen->displayAge(), $seen->getMessage()
			));
		}
		
		else
		{
			$this->showHelp('seen');
		}
	}
}
?>
