<?php
final class DOGMOD_Slaylert extends Dog_GWFModule
{
	private $pull_cycle_num = 0;
	private $pulling = false;
	
	public function onInitTimers()
	{
		Dog_Timer::addTimer(array($this, 'pullTimer'), null, 10.0);
	}
	
	public function pullTimer()
	{
		Dog_Log::debug('DOGMOD_CVS::pullTimer()');

		if ($this->pulling)
		{
		}
		elseif (false === ($repo = Dog_Repo::table('Dog_Repo')->selectFirstObject('*', "repo_id > $this->pull_cycle_num")))
		{
			$this->pull_cycle_num = 0;
		}
		else
		{
			$this->pull_cycle_num = $repo->getID();
			$this->doPull($repo);
		}
	}
	
	private function doPull(Dog_Repo $repo)
	{
		$calldata = array($repo->getGDOData());
		$callback = array($this, 'after_pull');
		$callargs = array($repo->getID());
		$includes = array($this->getPath().'workers/Dog_CVS_Git_Worker.php');
		if (!Dog::getWorker()->async_method('Dog_CVS_Git_Worker', 'pull', $calldata, $callback, $callargs, $includes))
		{
			return $this->error('err_worker');
		}
		$this->pulling = true;
	}
	
	public function after_pull($repo_id, array $data)
	{
// 		printf("DOGMOD_CVS::afterPull($repo_id): %s\n", print_r($data, true));
		
		$code = $data[0];
		$pullResult = $data[1];
		
		$this->pulling = false;
		if (!($repo = Dog_Repo::getByID($repo_id)))
		{
			Dog_Log::critical(GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__)));
			return;
		}
		
		if (!$repo->isNew($pullResult))
		{
			return;
		}
		
		if (!$repo->storePullResult($pullResult))
		{
			Dog_Log::critical(GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__)));
			return;
		}
		
		$this->announce_commit($repo);
	}

	private function commit_message(Dog_Repo $repo, $iso)
	{
		return $this->langISO($iso, 'msg_announce', array($repo->getName(), $repo->getCommitCount(), $repo->getCommiter(), $repo->getCommitComment(), $repo->getTracURL()));
	}
	
	private function announce_commit(Dog_Repo $repo)
	{
		printf("DOGMOD_CVS::announce_commit()\n");
		$subscribe_channels = Dog_RepoSubscribes::getSubscriptionsFor($repo);
		$subscribe_users = Dog_RepoUsers::getSubscriptionsFor($repo);
		foreach (Dog::getServers() as $server)
		{
			$server instanceof Dog_Server;
			if ($server->isConnected())
			{
				foreach ($server->getUsers() as $user)
				{
					$user instanceof Dog_User;
					if (in_array($user->getID(), $subscribe_users, true))
					{
						$user->sendPRIVMSG($this->commit_message($repo, $user->getLangISO()));
					}
					
				}
				foreach ($server->getChannels() as $chan)
				{
					if (in_array($chan->getID(), $subscribe_channels, true))
					{
						$chan->sendPRIVMSG($this->commit_message($repo, $chan->getLangISO()));
					}
				}
			}
		}
	
	}
	
	public function on_repo_find_Pb() { $this->onRepoSearchFunc('find'); }
	public function on_repo_findi_Pb() { $this->onRepoSearchFunc('findi'); }
	public function on_repo_findd_Pb() { $this->onRepoSearchFunc('findd'); }
	public function on_repo_finddi_Pb() { $this->onRepoSearchFunc('finddi'); }
	public function on_repo_search_Pb() { $this->onRepoSearchFunc('search'); }
// 	public function on_repo_searchi_Pb() { $this->onRepoSearchFunc('searchi'); }
	private function onRepoSearchFunc($worker_method)
	{
		$argv = $this->argv();
		if (count($argv) !== 2)
		{
			return $this->showHelp('repo_'.$worker_method);
		}
		
		if (false === ($repo = $this->getRepoForRead()))
		{
			return;
		}
		
		$calldata = array($argv[1], $repo->getGDOData());
		$callback = null;
		$callargs = array();
		$includes = array($this->getPath().'workers/Dog_CVS_Git_Worker.php');
		
		if (!Dog::getWorker()->async_method('Dog_CVS_Git_Worker', $worker_method, $calldata, $callback, $callargs, $includes))
		{
			$this->rply('err_worker');
		}
	}
	
	private function getRepoForRead($argnum=0)
	{
		if (!($repo = Dog_Repo::getByName($this->argv($argnum))))
		{
			return $this->error('err_repo');
		}
		else if (!$repo->canRead(Dog::getUser()))
		{
			return $this->error('err_permission');
		}
		return $repo;
	}
	
	public function on_repo_purge_Pb()
	{
		if ( (!($repo = Dog_Repo::getByName($name))) ||
		     (!($repo->canWrite(Dog::getUser()))) )
		{
			return $this->error('err_repo');
		}
		
		if (!$repo->purge())
		{
			return Dog::err('ERR_WRITE_FILE', array($repo->getDir()));
		}
		
		if (!$repo->delete())
		{
			return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->rply('msg_purged');
	}

	public function on_repo_unsubscribe_Pb()
	{
		if ($this->argc() !== 1)
		{
			return $this->showHelp('repo_unsubscribe');
		}
		if (false === ($repo = $this->getRepoForRead()))
		{
			return;
		}
			
		if (!($chan = Dog::getChannel()))
		{
			if (!($ru = Dog_RepoUsers::getOrCreateForRepoAndUser($repo, Dog::getUser())))
			{
				return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			if (!$ru->isSubscribed())
			{
				return $this->error('err_not_subscribed');
			}			
			$ru->unsubscribe();
			return $this->rply('msg_unsubscribed_private');
		}
		else
		{
			if (!Dog_RepoSubscribes::isSubscribed($repo, $chan))
			{
				return $this->error('err_not_subscribed');
			}
			if (!Dog_RepoSubscribes::unsubscribe($repo, $chan))
			{
				return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			return $this->rply('msg_unsubscribed_channel');
		}
	}
	
	public function on_repo_subscribe_Pb()
	{
		if ($this->argc() !== 1)
		{
			return $this->showHelp('repo_subscribe');
		}
		if (false === ($repo = $this->getRepoForRead()))
		{
			return;
		}
		
		if (!($chan = Dog::getChannel()))
		{
			if (!($ru = Dog_RepoUsers::getOrCreateForRepoAndUser($repo, Dog::getUser())))
			{
				return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			if ($ru->isSubscribed())
			{
				return $this->error('err_already_subscribed');
			}			
			$ru->subscribe();
			return $this->rply('msg_subscribed_private');
		}
		else
		{
			if (Dog_RepoSubscribes::isSubscribed($repo, $chan))
			{
				return $this->error('err_already_subscribed');
			}
			if (!Dog_RepoSubscribes::subscribe($repo, $chan))
			{
				return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			return $this->rply('msg_subscribed_channel');
		}
		
	}

	public function on_repo_checkout_Pb()
	{
		GDO::table('Dog_Repo')->createTable(true);
		GDO::table('Dog_RepoSubscribes')->createTable(true);
		GDO::table('Dog_RepoUsers')->createTable(true);
		GWF_File::removeDir(Dog_Repo::baseDir(), false, true, true);
		
		$argv = $this->argv();
		$argc = count($argv);
		
		if ($argc !== 3)
		{
			return $this->showHelp('checkout');
		}
		
		$type = $argv[1];
		if (!Dog_Repo::isValidType($type))
		{
			return $this->rply('err_software');			
		}

		$url = @parse_url($argv[2]);
		if (!isset($url['scheme']))
		{
			return $this->rply('err_url', $url);
		}
		$url = $argv[2];
		if (!GWF_HTTP::pageExists($url))
		{
			return $this->rply('err_connect');
		}
		
		$name = $argv[0];
		if (!Dog_Repo::isValidName($name))
		{
			return $this->rply('err_repo_name');
		}
		if (Dog_Repo::exists($name))
		{
			return $this->rply('err_repo_taken');
		}
		
		if (!GWF_File::createDir(Dog_Repo::repoDir($name)))
		{
			return $this->rply('err_create_dir');
		}
		
		if (!($repo = Dog_Repo::create($url, $name, $type)))
		{
			return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		
		call_user_func(array($this, 'checkout_'.$type), $repo);
	}

	private function checkout_svn(Dog_Repo $repo)
	{
		$this->rply('err_func_is_stub');
	}
	
	private function checkout_git(Dog_Repo $repo)
	{
		$calldata = array($repo->getGDOData());
		$callback = array($this, 'after_checkout');
		$callargs = array($repo->getID());
		$includes = array($this->getPath().'workers/Dog_CVS_Git_Worker.php');
		if (!Dog::getWorker()->async_method('Dog_CVS_Git_Worker', 'checkout', $calldata, $callback, $callargs, $includes))
		{
			$this->rply('err_worker');
		}
		else
		{
			$this->rply('msg_checking_out', array($repo->getType(), $repo->getURL(), $repo->getName()));
		}
	}
	
	public function after_checkout($repo_id)
	{
		if (!($repo = Dog_Repo::getByID($repo_id)))
		{
			return $this->rply('err_repo');
		}
		
		$repo->saveOption(Dog_Repo::CHECKED_OUT);
		$repo->updated();
		$this->rply('msg_checked_out');
	}
}
