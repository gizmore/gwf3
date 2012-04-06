<?php

final class WeChall_ChallVotes extends GWF_Method
{
	public function getHTAccess()
	{
		return 
			'RewriteRule ^challvotes/(\d+)/[^/]+$ index.php?mo=WeChall&me=ChallVotes&cid=$1'.PHP_EOL;
	}

	public function execute()
	{
		if (false === ($mod_votes = GWF_Module::loadModuleDB('Votes', true))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array('Votes'));
		}
		
		if (false === ($chall = WC_Challenge::getByID(Common::getGet('cid', 0)))) {
			return $this->module->error('err_chall');
		}
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
		
		if (false !== (Common::getPost('vote'))) {
			return $this->onVote($chall).$this->templateVotes($chall);
		}
		
		return $this->templateVotes($chall);
	}

	public function templateVotes(WC_Challenge $chall)
	{
		$user = GWF_User::getStaticOrGuest();
		$userid = $user->getID();
		
		$has_solved = WC_ChallSolved::hasSolved($userid, $chall->getID());

		Module_WeChall::includeForums();
		
		$form_vote = $this->getFormVote($chall, $has_solved, $userid);
		
		$tVars = array(
			'chall' => $chall,
			'has_solved' => $has_solved,
			'form_vote' => $form_vote->templateX($this->module->lang('ft_vote_chall', array($chall->display('chall_title')))),
		);
		return $this->module->templatePHP('chall_votes.php', $tVars);
	}
	
	private function getFormVote(WC_Challenge $chall, $has_solved, $userid)
	{
		$fun = $edu = $dif = 0;
		if ($has_solved)
		{
			if (false !== ($vsr = GWF_VoteScoreRow::getByUID($chall->getVar('chall_vote_dif'), $userid))) {
				$dif = $vsr->getScore();
			}
			if (false !== ($vsr = GWF_VoteScoreRow::getByUID($chall->getVar('chall_vote_edu'), $userid))) {
				$edu = $vsr->getScore();
			}
			if (false !== ($vsr = GWF_VoteScoreRow::getByUID($chall->getVar('chall_vote_fun'), $userid))) {
				$fun = $vsr->getScore();
			}
		}
		
		$data = array(
			'dif' => array(GWF_Form::INT, $dif, $this->module->lang('th_dif'), '', 2),
			'edu' => array(GWF_Form::INT, $edu, $this->module->lang('th_edu'), '', 2),
			'fun' => array(GWF_Form::INT, $fun, $this->module->lang('th_fun'), '', 2),
			'vote' => array(GWF_Form::SUBMIT, $this->module->lang('btn_vote')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_dif(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'dif', $arg, 0, 10, true); }
	public function validate_edu(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'edu', $arg, 0, 10, true); }
	public function validate_fun(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'fun', $arg, 0, 10, true); }
	public function onVote(WC_Challenge $chall)
	{
		if ('0' === ($userid = GWF_Session::getUserID())) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}

		if (!WC_ChallSolved::hasSolved($userid, $chall->getID())) {
			return $this->module->error('err_chall_vote');
		}
		
		$form = $this->getFormVote($chall, false, $userid);
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
		
		if (false !== ($vs = $chall->getVotesDif())) {
			$vs->onUserVoteSafe($_POST['dif'], $userid);
		}
		if (false !== ($vs = $chall->getVotesEdu())) {
			$vs->onUserVoteSafe($_POST['edu'], $userid);
		}
		if (false !== ($vs = $chall->getVotesFun())) {
			$vs->onUserVoteSafe($_POST['fun'], $userid);
		}
		
		if (false === WC_ChallSolved::setVoted($userid, $chall->getID(), true)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $chall->onRecalcVotes()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_chall_voted');
	}
	
}

?>