<?php
final class Votes_VotePoll extends GWF_Method
{
//	public function getHTAccess()
//	{
//	}

	public function execute()
	{
		if (false === ($poll = GWF_VoteMulti::getByID(Common::getPost('vmid')))) {
			return $this->module->error('err_poll');
		}
		
		$user = GWF_Session::getUser();
		
		if (false !== ($error = $this->checkReversible($poll, $user))) {
			return $error;
		}
		
		if (false === $poll->mayVote($user)) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (!$poll->isEnabled()) {
			return $this->module->error('err_poll_off');
		}
		
		return $this->onVote($poll, $user);
	}
	
	private function checkReversible(GWF_VoteMulti $poll, $user)
	{
		if ($poll->isIrreversible() && $poll->hasVoted($user)) {
			return $this->module->error('err_irreversible');
		}
		return false;
	}
	
	private function onVote(GWF_VoteMulti $poll, $user)
	{
		$opts = Common::getPostArray('opt', array());
		$taken = array();
		$max = $poll->getNumChoices();
		foreach ($opts as $i => $stub)
		{
			$i = (int) $i;
			if ($i < 1 || $i > $max) {
				continue;
			}
			if (!in_array($i, $taken, true)) {
				$taken[] = $i;
			}
		}
		
		$count = count($taken);
//		if ($count === 0) {
//			return $this->module->error('err_no_options');
//		}
		
		if (!$poll->isMultipleChoice() && $count !== 1) {
			return $this->module->error('err_no_multi');
		}

		if (false === ($poll->onVote($user, $taken))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		return $this->module->message('msg_voted', array(htmlspecialchars(GWF_Session::getLastURL())));
	}
}
?>