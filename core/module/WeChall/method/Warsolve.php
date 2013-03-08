<?php
final class WeChall_Warsolve extends GWF_Method
{
	const TIMEOUT = 15;
	
	/**
	 * @var WC_Warbox
	 */
	private $box;
	
	/**
	 * @var WC_Site
	 */
	private $site;
	
	/**
	 * @var GWF_User
	 */
	private $user;
	
	/**
	 * @var array
	 */
	private $flags;
	
	public function execute()
	{
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_Warflags');
		$this->module->includeClass('sites/warbox/WCSite_WARBOX');
		
		if (false === ($this->box = WC_Warbox::getByID(Common::getGetString('boxid'))))
		{
			return $this->module->error('err_warbox');
		}
		
		if (false === ($this->site = $this->box->getSite()))
		{
			return $this->module->error('err_site');
		}
		
		if (false === ($this->user = GWF_Session::getUser()))
		{
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		if (false === ($this->flags = WC_Warflag::getForBoxAndUser($this->box, $this->user, 'wf_order ASC')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (count($this->flags) === 0)
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if (isset($_POST['password']))
		{
			return $this->onSolve();
		}
		
		return $this->templateOverview();
	}
	
	private function templateOverview()
	{
		$tVars = array(
			'flags' => $this->flags,
		);
		return $this->module->templatePHP('warsolve.php', $tVars);
	}
	
	private function onSolve()
	{
		$take = array();
		foreach (Common::getPostArray('password', array()) as $flagid => $pass)
		{
			if ($pass !== '')
			{
				$take[$flagid] = $pass;
			}
		}
		
		$back = '';
		
		if (count($take) === 1)
		{
			$back .= $this->onSolveB(key($take), $take[key($take)]);
		}
		elseif (count($take) > 1)
		{
			$back .= 'ONE AT A TIME!';
		}
		
		return $back.$this->templateOverview();
	}
	
	private function onSolveB($flagid, $password)
	{
		if (false === ($flag = WC_Warflag::getByID($flagid)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (!$flag->isWarflag())
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if ($this->box->getID() !== $flag->getVar('wf_wbid'))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false !== ($error = $this->checkBrute($flag)))
		{
			return $error;
		}
		
		$password = WC_Warflag::hashPassword($password);
		if ($password !== $flag->getVar('wf_flag_enc'))
		{
			return $this->onFailed($flag);
		}
		else
		{
			return $this->onSolved($flag);
		}
	}
	
	private function checkBrute(WC_Warflag $flag)
	{
		$timestamp = WC_Warflags::getLastAttemptTime($this->user);
		
		$wait = $timestamp + self::TIMEOUT - time();
		if ($wait <= 0)
		{
			return false;
		}
		return 'WAIT '.$wait;
	}
	
	private function onFailed(WC_Warflag $flag)
	{
		if (!WC_Warflags::insertFailure($flag, $this->user))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return 'WRONG!';
	}
	
	private function onMultiSolved(WC_Warflag $flag)
	{
		if (false !== ($err = $this->onSingleSolved($flag)))
		{
			return $err;
		}
		
		
		if (false === ($this_num = $flag->getLevelNum()))
		{
			return false;
		}
		foreach (WC_Warflag::getByWarbox($this->box) as $f)
		{
			$f instanceof WC_Warflag;
			if ($f->getLevelNum() < $this_num)
			{
				if (false !== ($err = $this->onSingleSolved($f)))
				{
					return $err;
				}
			}
		}
		
		return false;
	}
	
	private function onSingleSolved(WC_Warflag $flag)
	{
		if (!WC_Warflags::insertSuccess($flag, $this->user))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$flag->setLastSolver($this->user);
		
		return false;
	}
	
	private function onSolved(WC_Warflag $flag)
	{
		if ($this->box->isMultisolve())
		{
			if (false !== ($err = $this->onMultiSolved($flag)))
			{
				return $err;
			}
		}
		else
		{
			if (false !== ($err = $this->onSingleSolved($flag)))
			{
				return $err;
			}
		}
		
		if (!$this->box->recalcPlayersAndScore())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === ($this->flags = WC_Warflag::getForBoxAndUser($this->box, $this->user, 'wf_order ASC')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$this->module->includeClass('WC_RegAt');
		if ($this->site->isUserLinked($this->user->getID()))
		{
			$result = $this->site->onUpdateUser($this->user);
			return $result->display($this->site->displayName());
		}
		
		else
		{
			return '_YOU_ARE_NOT_LINKED_TO_THE_SITE,_BUT_WELL_DONE!';
		}
		
	}
	
}
