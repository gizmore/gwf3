<?php
/**
 * Autologin via NickServ STATUS or WHOIS.
 * Probes servers on startup.
 * @author gizmore
 * @version 4.0
 */
final class DOGMOD_AutoLogin extends Dog_Module
{
	private $tried = array();
	private $status = array();
	
	public function event_001()
	{
		$this->probeServer();
	}
	
	public function event_privmsg()
	{
		if (Dog::isTriggered())
		{
			$this->onTryAutoLogin();
		}
	}
	
	public function onTryAutoLogin()
	{
		$user = Dog::getUser();
		$server = Dog::getServer();
		if ( (!$user->isLoggedIn() && ($user->isRegistered()) && (!$this->triedAutologin($user->getID()))) )
		{
			$this->tryAutoLogin($server, $user);
		}
	}
	
	public function event_330()
	{
		if (false !== ($user = Dog::getUserByArg(Dog::argv(1))))
		{
			$this->onAutoLogin($user);
		}
	}
	
	public function event_notice()
	{
		if (false !== ($user = Dog::getUser()))
		{
			if (!strcasecmp($user->getName(), 'NickServ'))
			{ 
				if (preg_match('/^STATUS ([^ ]+) ([0-9])$/Di', $this->msgarg(), $matches))
				{
					$server = Dog::getServer();
					$nickname = $matches[1];
					$status = (int)$matches[2];
					if (  (!$this->probingNickservStatus($server, $nickname, $status))
						&&($status === 3) )
					{
						if (false !== ($user = $server->getUserByName($nickname)))
						{
							$this->onAutoLogin($user);
						}
					}
				}
			}
		}
	}
	
	private function onAutoLogin(Dog_User $user)
	{
		if ($user->isRegistered())
		{
			unset($this->tried[array_search($user->getID(), $this->tried)]);
			$user->setLoggedIn(true);
			$user->sendNOTICE($this->lang('logged_in'));
		}
	}
	
	private function probingNickservStatus(Dog_Server $server, $nickname, $status)
	{
		if (  ($nickname === $server->getNick()->getName())
			&&(($status === 0) || ($status === 3)) )
		{
			$this->status[] = $server->getID();
		}
	}
	
	private function probeServer()
	{
		$server = Dog::getServer();
		$this->sendNickservStatus($server, $server->getNick()->getName());
	}

	private function sendNickservStatus(Dog_Server $server, $username)
	{
		$server->sendPRIVMSG('NickServ', 'STATUS '.$username);
	}
	
	private function triedAutoLogin($userid)
	{
		if (in_array($userid, $this->tried, true))
		{
			return true;
		}
		$this->tried[] = $userid;
		return false;
	}
	
	private function tryAutoLogin(Dog_Server $server, Dog_User $user)
	{
		if ($user->isRegistered())
		{
			$username = $user->getName();
			if (in_array($server->getID(), $this->status, true))
			{
				$this->sendNickservStatus($server, $username);
			}
			else
			{
				$server->getConnection()->sendRAW("WHOIS $username");
			}
		}
	}
}
?>
