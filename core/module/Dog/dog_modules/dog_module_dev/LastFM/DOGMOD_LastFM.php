<?php
final class DOGMOD_LastFM extends Dog_Module
{
	public function getOptions()
	{
// 		return array(
// 			'username' => 'u,r,s,""',
// 			'channels' => 'u,r,s,""',
				
// 		);
	}
	
	public function onInitTimers()
	{
// 		Dog_Timer::addTimer(array($this, 'lastfmtimer'), null, 10.0);
	}
	
	public function lastfmtimer()
	{
		$calldata = array($repo->getGDOData());
		$callback = array($this, 'after_pull');
		$callargs = array($repo->getID());
		$includes = array($this->getPath().'workers/Dog_LFMWorker.php');
		Dog::getWorker()->async_method('Dog_LFMWorker', 'update', $calldata, $callback, $callargs, $includes);
	}
	
	public function on_lastfm_Rb()
	{
		$argv = $this->argv();
		$cmd = array_shift($argv);
		
		switch($cmd)
		{
			case 'init':
				return $this->onInit($argv[0]);
			case 'add':
				return $this->onAdd();
			case 'remove':
				return $this->onRemove();
			default:
				return $this->showHelp('lastfm');
		}
		
	}

	public function onInit($username)
	{
		$user = Dog::getUser();
		if (!Dog_LFMAuth::isValidUsername($username))
		{
			return $this->error('err_username');
		}
		Dog_LFMAuth::init($user);
		Dog_LFMChans::clear($user);
		return $this->rply('msg_inited');
	}

	public function onAdd()
	{
		if (!($channel = Dog::getChannel()))
		{
			return $this->error('err_add_no_channel');
		}
		
		if (Dog_LFMChans::isLinked($user, $channel))
		{
			return $this->error('err_already_linked');
		}
		
		Dog_LFMChans::link($user, $channel);
		return $this->rply('msg_linked');
	}

	public function onRemove()
	{
		if (!($channel = Dog::getChannel()))
		{
			return $this->error('err_add_no_channel');
		}
		
	}
}

