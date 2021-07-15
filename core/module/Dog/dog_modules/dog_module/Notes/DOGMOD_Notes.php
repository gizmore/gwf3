<?php
final class DOGMOD_Notes extends Dog_Module
{
	public function event_nick()
	{
		$server = Dog::getServer();
// 		$this->onJoinTell($server, $server->getUserByName(Dog::argv(0)));
	}
	
	public function event_join()
	{
	    if ($user = Dog::getUser())
	    {
    		$this->onJoinTell(Dog::getServer(), $user);
	    }
	}
	
	public function trigger_login(Dog_User $user)
	{
		$this->onJoinTell(Dog::getServer(), $user);
	}
	
	public function onJoinTell(Dog_Server $server, Dog_User $user)
	{
		if ($user->isRegistered() && (!$user->isLoggedIn()))
		{
			return;
		}
		$userid = $user->getID();
		if (0 == ($count = Dog_Note::countUnread($userid)))
		{
			return;
		}
		$username = $user->getName();
		
		if ($count == 1)
		{
			$user->sendPRIVMSG($this->lang('note1'));
		}
		else
		{
			$user->sendPRIVMSG($this->lang('note2'));
		}
		
		for ($i = 0; $i < $count; $i++)
		{
			$user->sendPRIVMSG($this->readNext($server, $user));
		}
	}
	
	public function readNext(Dog_Server $server, Dog_User $user)
	{
		$userid = $user->getID();
		if (false === ($note = Dog_Note::popNote($userid)))
		{
			return "Error: No unread note to pop.";
		}
		return $note->displayNote($server, $userid);
	}
	
	################
	### Commands ###
	################
	public function on_note_Pb()
	{
		$server = Dog::getServer();
		$user = Dog::getUser();
		$message = $this->msgarg();
		$command = Common::substrUntil($message, ' ', $message);
		$message = Common::substrFrom($message, ' ', '');
		switch ($command)
		{
			case 'send'; $out = $this->onSend($server, $user, $message); break;
			case 'read'; $out = $this->onRead($server, $user, $message); break;
			case 'delete'; $out = $this->onDelete($server, $user, $message); break;
			case 'search'; $out = $this->onSearch($server, $user, $message); break;
			default:
			case 'help': $this->onHelp(); return;
		}
		$this->reply($out);
	}
	
	public function onHelp()
	{
		$message = $this->argv(0);
		if (!$this->hasTrans($message))
		{
			$message = 'commands';
		}
		$this->showHelp($message);
	}
	
	public function onSend(Dog_Server $server, Dog_User $user, $message)
	{
// 		$c = Dog::getTrigger();
		if (false === ($nickname = Common::substrUntil($message, ' ', false)))
		{
			return $this->lang('help_send');
		}
		$message = Common::substrFrom($message, ' ');
		
		if (false === ($user_to = Dog_User::getForServer($server->getID(), $nickname)))
		{
			return Dog::lang('err_user');
		}
		
		if (false === Dog_Note::isWithinLimits($user->getID()))
		{
			return $this->lang('err_limit', array(Dog_Note::LIMIT_AMT, GWF_Time::humanDuration(Dog_Note::LIMIT_TIME)));
		}
		
		if (false !== ($channel = Dog::getChannel()))
		{
			if (false !== $channel->getUserByName($nickname))
			{
				return $this->lang('err_in_chan', array($nickname));
			}
		}
		
		if (false === Dog_Note::insertNote($user, $user_to, $message))
		{
			return GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		return $this->lang('msg_sent', array($nickname));
	}
	
	public function onRead(Dog_Server $server, Dog_User $user, $message)
	{
		return 'STUB FUNCTION';
	}
	
	public function onDelete(Dog_Server $server, Dog_User $user, $message)
	{
		return 'STUB FUNCTION';
	}
	
	public function onSearch(Dog_Server $server, Dog_User $user, $message)
	{
		return 'STUB FUNCTION';
	}
}
?>
