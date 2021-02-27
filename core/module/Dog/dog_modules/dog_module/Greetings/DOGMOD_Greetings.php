<?php
/**
 * Greet the users once, like a channel topic.
 * @author gizmore
 * @version 4.0
 */
final class DOGMOD_Greetings extends Dog_Module
{
	public function event_join()
	{
		$user = Dog::getUser();
		$server = Dog::getServer();
		$channel = Dog::getChannel();
		
		if (!$channel) # should not happen
		{
		    return; # should not happen
		}
		
		$cid = $channel->getID();
		
		if (  (Dog::isItself())
			||(Dog_Greeting::hasBeenGreeted($user->getID(), $cid))
			||(false === ($greeting = Dog_GreetMsg::getGreetMsg($server, $channel))) 
			||($greeting->isDisabled()) )
		{
			return;
		}
		
		$message = $greeting->getVar('dgm_msg');
		
		switch ($greeting->getGreetMode())
		{
			case Dog_GreetMsg::MODE_CHAN:
				$server->sendPRIVMSG($channel->getName(), $user->getName().': '.$message);
				break;
			case Dog_GreetMsg::MODE_NOTICE:
				$server->sendNOTICE($user->getName(), $message);
				break;
			case Dog_GreetMsg::MODE_PRIVMSG:
				$server->sendPRIVMSG($user->getName(), $message);
				break;
			default:
				Dog_Log::error('Invalid type of greeting in '.__FILE__.' line '.__LINE__.'!');
				return;
		}
		
		Dog_Greeting::markGreeted($user->getID(), $cid);
	}

	
	public function on_ADDgreet_Sc()
	{
		$message = $this->msgarg();
		$channel = Dog::getChannel();
		
		if (false === Dog_GreetMSG::setGreetMsg(Dog::getServer(), Dog::getChannel(), $message))
		{
			Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		else
		{
			$this->rply('set', array($channel->displayLongName(), $message));
		}
	}
	
	public function on_REMOVEgreet_Sc()
	{
		$channel = Dog::getChannel();
		
		if (false === ($msg = Dog_GreetMSG::getGreetMsg(Dog::getServer(), $channel)))
		{
			Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		elseif (!$msg->setEnabled(false))
		{
			Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		else
		{
			$this->rply('unset', array($channel->displayLongName()));
		}
	}

	public function on_greet_Pc()
	{
		$channel = Dog::getChannel();
		
		if (false === ($msg = Dog_GreetMsg::getGreetMsg(Dog::getServer(), $channel)))
		{
			$this->rply('none', array($channel->displayLongName()));
		}
		elseif ($msg->isEnabled())
		{
			$this->rply('enabled', array($channel->displayLongName(), $msg->getVar('dgm_msg')));
		}
		else
		{
			$this->rply('disabled', array($channel->displayLongName(), $msg->getVar('dgm_msg')));
		}
	}
	
	public function on_greetmode_Sc()
	{
		$channel = Dog::getChannel();
		
		if (false === ($msg = Dog_GreetMSG::getGreetMsg(Dog::getServer(), $channel)))
		{
			return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$argv = $this->argv();
		$argc = count($argv);
		
		if ($argc === 0)
		{
			$this->showGreetMode($channel, $msg);
		}
		elseif ($argc === 1)
		{
			$this->setGreetMode($channel, $msg, $argv[0]);
		}
		else
		{
			$this->showHelp('greetmode');
		}
	}
	
	private function showGreetMode(Dog_Channel $channel, Dog_GreetMsg $msg)
	{
		$c = $channel->displayLongName();
		switch ($msg->getOptions()&Dog_GreetMsg::MODES)
		{
			case Dog_GreetMsg::MODE_CHAN: return $this->rply('set_to_c', array($c));
			case Dog_GreetMsg::MODE_NOTICE: return $this->rply('set_to_n', array($c));
			case Dog_GreetMsg::MODE_PRIVMSG: return $this->rply('set_to_p', array($c));
			default: Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
	}
	
	private function setGreetMode(Dog_Channel $channel, Dog_GreetMsg $msg, $mode)
	{
		switch ($mode)
		{
			case 'channel': case 'c': return $this->setGreetModeB($channel, $msg, 'c', Dog_GreetMsg::MODE_CHAN);
			case 'notice': case 'n': return $this->setGreetModeB($channel, $msg, 'n', Dog_GreetMsg::MODE_NOTICE);
			case 'privmsg': case 'p': return $this->setGreetModeB($channel, $msg, 'p', Dog_GreetMsg::MODE_PRIVMSG);
			default: return $this->showHelp('greetmode');
		}
	}
	
	private function setGreetModeB(Dog_Channel $channel, Dog_GreetMsg $msg, $char, $bit)
	{
		$msg->saveOption(Dog_GreetMsg::MODES, false);
		$msg->saveOption($bit);
		$this->rply('change_to_'.$char, array($channel->displayLongName()));
	}
	
	public function on_greet_again_Fc()
	{
		$channel = Dog::getChannel();
		$dropped = Dog_Greeting::dropChannel($channel->getID());
		$this->rply('again', array($dropped, $channel->displayLongName()));
	}
}
?>
