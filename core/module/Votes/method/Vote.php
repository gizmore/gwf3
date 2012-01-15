<?php

final class Votes_Vote extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^vote/([0-9]+)/with/(\-?[0-9]+)$ index.php?mo=Votes&me=Vote&vsid=$1&score=$2'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		return $this->onVote();
	}
	
	/**
	 * @var GWF_VoteScore
	 */
	private $votescore;
	private $score;
	
	private function sanitize()
	{
		if (false === ($this->votescore = GWF_VoteScore::getByID(Common::getGet('vsid')))) {
			return $this->_module->error('err_votescore');
		}
		
		if ($this->votescore->isIrreversible() && $this->votescore->hasVoted(GWF_Session::getUser())) {
			return $this->_module->error('err_irreversible');
		}
		
		if (false === ($this->score = Common::getGet('score'))) {
			return $this->_module->error('err_score');
		}
		
		if (!$this->votescore->isInRange($this->score)) {
			return $this->_module->error('err_score');
		}
		
		if ($this->votescore->isExpired()) {
			return $this->_module->error('err_expired');
		}
		
		if ($this->votescore->isDisabled()) {
			return $this->_module->error('err_disabled');
		}
		
		return false;
	}
	
	private function onVote()
	{
		if (false === ($user = GWF_Session::getUser())) {
			return $this->onGuestVote();
		}
		elseif ($user->isWebspider()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		else {
			return $this->onUserVote($user);
		}
	}

	private function onGuestVote()
	{
		if (!$this->votescore->isGuestVote()) {
			return $this->_module->error('err_no_guest');
		}
		
		$ip = GWF_IP6::getIP(GWF_IP_QUICK);
		if (false === ($vsr = GWF_VoteScoreRow::getByIP($this->votescore->getID(), $ip)))
		{
			if (false === $this->votescore->onGuestVote($this->score, $ip)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			return $this->onVoted(false);
		}
		else
		{
			if ($vsr->isUserVote()) {
				return $this->_module->message('err_vote_ip');
			}
			if (!$vsr->isGuestVoteExpired($this->_module->cfgGuestTimeout())) {
				$this->votescore->revertVote($vsr, $ip, 0);
			}
			if (false === $this->votescore->onGuestVote($this->score, $ip)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			
			return $this->onVoted(false);
		}
	}
	
	private function onVoted($user)
	{
		GWF_Hook::call(GWF_Hook::VOTED_SCORE, $user, array($this->votescore->getID(), $this->score));
		
		return isset($_GET['ajax']) ? $this->_module->message('msg_voted_ajax') : $this->_module->message('msg_voted', array(GWF_Session::getLastURL()));
	}
	
	private function onUserVote(GWF_User $user)
	{
		if (false !== ($err = $this->votescore->onUserVoteSafe($this->score, $user->getID()))) {
			return $err;
		}
		return $this->onVoted($user);
	}
	
	
}