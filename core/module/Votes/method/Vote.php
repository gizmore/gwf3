<?php

final class Votes_Vote extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^vote/([0-9]+)/with/(\-?[0-9]+)$ index.php?mo=Votes&me=Vote&vsid=$1&score=$2'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		return $this->onVote($module);
	}
	
	/**
	 * @var GWF_VoteScore
	 */
	private $votescore;
	private $score;
	
	private function sanitize(Module_Votes $module)
	{
		if (false === ($this->votescore = GWF_VoteScore::getByID(Common::getGet('vsid')))) {
			return $module->error('err_votescore');
		}
		
		if ($this->votescore->isIrreversible() && $this->votescore->hasVoted(GWF_Session::getUser())) {
			return $module->error('err_irreversible');
		}
		
		if (false === ($this->score = Common::getGet('score'))) {
			return $module->error('err_score');
		}
		
		if (!$this->votescore->isInRange($this->score)) {
			return $module->error('err_score');
		}
		
		if ($this->votescore->isExpired()) {
			return $module->error('err_expired');
		}
		
		if ($this->votescore->isDisabled()) {
			return $module->error('err_disabled');
		}
		
		return false;
	}
	
	private function onVote(Module_Votes $module)
	{
		if (false === ($user = GWF_Session::getUser())) {
			return $this->onGuestVote($module);
		}
		elseif ($user->isWebspider()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		else {
			return $this->onUserVote($module, $user);
		}
	}

	private function onGuestVote(Module_Votes $module)
	{
		if (!$this->votescore->isGuestVote()) {
			return $module->error('err_no_guest');
		}
		
		$ip = GWF_IP6::getIP(GWF_IP_QUICK);
		if (false === ($vsr = GWF_VoteScoreRow::getByIP($this->votescore->getID(), $ip)))
		{
			if (false === $this->votescore->onGuestVote($this->score, $ip)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			return $this->onVoted($module, false);
		}
		else
		{
			if ($vsr->isUserVote()) {
				return $module->message('err_vote_ip');
			}
			if (!$vsr->isGuestVoteExpired($module->cfgGuestTimeout())) {
				$this->votescore->revertVote($vsr, $ip, 0);
			}
			if (false === $this->votescore->onGuestVote($this->score, $ip)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			
			return $this->onVoted($module, false);
		}
	}
	
	private function onVoted(Module_Votes $module, $user)
	{
		GWF_Hook::call(GWF_Hook::VOTED_SCORE, $user, array($this->votescore->getID(), $this->score));
		
		return isset($_GET['ajax']) ? $module->message('msg_voted_ajax') : $module->message('msg_voted', array(GWF_Session::getLastURL()));
	}
	
	private function onUserVote(Module_Votes $module, GWF_User $user)
	{
		if (false !== ($err = $this->votescore->onUserVoteSafe($this->score, $user->getID()))) {
			return $err;
		}
		return $this->onVoted($module, $user);
	}
	
	
}