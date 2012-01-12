<?php
/**
 * Edit a challenge.
 * @author gizmore
 */
final class WeChall_ChallEdit extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^chall/edit/(\d+)/? index.php?mo=WeChall&me=ChallEdit&cid=$1'.PHP_EOL;
	}

	public function execute()
	{
		if (false === ($chall = WC_Challenge::getByID(Common::getGet('cid')))) {
			return $this->_module->error('err_chall');
		}
		
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit($this->_module, $chall).$this->templateEdit($this->_module, $chall);
		}
		if (false !== Common::getPost('reset')) {
			return $this->onReset($this->_module, $chall).$this->templateEdit($this->_module, $chall);
		}
		if (false !== (Common::getPost('delete'))) {
			return $this->onDelete($this->_module, $chall);
		}
		
		return $this->templateEdit($this->_module, $chall);
	}
	
	private function getForm(Module_WeChall $module, WC_Challenge $chall)
	{
		$buttons = array(
			'edit' => $this->_module->lang('btn_edit'),
			'reset' => $this->_module->lang('btn_reset'),
			'delete' => $this->_module->lang('btn_delete'),
		);
		$data = array(
			'score' => array(GWF_Form::INT, $chall->getVar('chall_score'), $this->_module->lang('th_chall_score')),
			'title' => array(GWF_Form::STRING, $chall->getVar('chall_title'), $this->_module->lang('th_chall_title')),
			'tags' => array(GWF_Form::STRING, $chall->getVar('chall_tags'), $this->_module->lang('th_chall_tags')),
			'url' => array(GWF_Form::STRING, $chall->getVar('chall_url'), $this->_module->lang('th_chall_url')),
			'solution' => array(GWF_Form::STRING, '', $this->_module->lang('th_chall_solution')),
			'creators' => array(GWF_Form::STRING, $chall->getVar('chall_creator_name'), $this->_module->lang('th_chall_creator_name')),
			'case_i' => array(GWF_Form::CHECKBOX, $chall->isCaseI(), $this->_module->lang('th_chall_case_i')),
			'cmd' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit(Module_WeChall $module, WC_Challenge $chall)
	{
		$form = $this->getForm($this->_module, $chall);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_edit_chall')),
		);
		return $this->_module->templatePHP('chall_edit.php', $tVars);
	}

	private function onEdit(Module_WeChall $module, WC_Challenge $chall)
	{
		$form = $this->getForm($this->_module, $chall);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}

		$msgs = '';
		$wc = WC_Site::getWeChall();
		
		# Solution
		$is_case_i = isset($_POST['case_i']);
		if ('' !== ($solution = Common::getPost('solution', '')))
		{
			if (false === $chall->saveVar('chall_solution', $chall->hashSolution($solution, $is_case_i))) {
				$msgs .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		# CASE_I
		$case_i = WC_Challenge::CHALL_CASE_I;
		if ($chall->isOptionEnabled($case_i) !== $is_case_i)
		{
			if (false === ($chall->saveOption($case_i, $is_case_i))) {
				$msgs .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		# Save score
		$new_score = $form->getVar('score');
		$old_score = $chall->getVar('chall_score');
		if ($new_score !== $old_score) {
			if (!WC_Challenge::isValidScore($new_score)) {
				$msgs .= $this->_module->error('err_chall_score', array($new_score, WC_Challenge::MIN_SCORE, WC_Challenge::MAX_SCORE));
			}
			
			if (false === ($chall->saveVar('chall_score', $new_score))) {
				$msgs .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}

			if (false === $wc->saveVar('site_maxscore', WC_Challenge::getMaxScore())) {
				$msgs .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}

			$wc->recalcSite();
		}
		
		
		# URL+Title (dangerous)
		if (false === $chall->saveVars(array(
			'chall_url' => $form->getVar('url'),
			'chall_title' => $form->getVar('title'),
			
		))) {
			$msgs .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# Creator:
		if (false === $chall->updateCreators($form->getVar('creators'))) {
			$msgs .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# Tags:
		if (false === $chall->saveVar('chall_tags', trim($form->getVar('tags'), ' ,'))) {
			$msgs .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		Module_WeChall::instance()->cacheChallTags();
		
		# Done
		return $msgs.$this->_module->message('msg_chall_edited');
	}

	private function onDelete(Module_WeChall $module, WC_Challenge $chall)
	{
		if (false === $chall->onDelete()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$wc = WC_Site::getWeChall();
		$wc->recalcSite();
		
		return $this->_module->message('msg_chall_deleted');
	}
	
	##################
	### Validators ###
	##################
	public function validate_score(Module_WeChall $m, $arg) { return $arg > 0 && $arg <= 10 ? false : $m->lang('err_chall_score'); }
	public function validate_title(Module_WeChall $m, $arg) { return strlen($arg) > 0 ? false : $m->lang('err_chall_title'); }
	public function validate_url(Module_WeChall $m, $arg) { return (strlen($arg) < 1) ? $m->lang('err_chall_url') : false; }
	public function validate_solution(Module_WeChall $m, $arg) { return false; }
	public function validate_tags(Module_WeChall $m, $arg)
	{
		$back = '';
		$tags = explode(',', $arg);
		foreach ($tags as $tag)
		{
			if ($tag === '') {
				continue;
			}
			if (1 !== preg_match('/^[a-zA-Z_0-9]+$/D', $tag)) {
				$back .= ', '.GWF_HTML::display($tag);
			}
		}
		return $back === '' ? false : $m->lang('err_chall_tags', array(substr($back, 2)));
	}
	
	public function validate_creators(Module_WeChall $m, $arg)
	{
		$creators = explode(',', $arg);
		$back = '';
		foreach ($creators as $c)
		{
			if ($c === '') {
				continue;
			}
			if (false === GWF_User::getByName($c)) {
				$back .= ', '.GWF_HTML::display($c);
			}
		}
		return $back === '' ? false : $m->lang('err_chall_creator', array(substr($back, 2)));
	}
	
	private function onReset(Module_WeChall $module, WC_Challenge $chall)
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
		
		# Remove solved
		$cid = $chall->getID();
		$solved = GDO::table('WC_ChallSolved');
		if (false === $solved->update("csolve_date='', csolve_options=0", "csolve_cid=$cid")) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		$affected = $solved->affectedRows();
		$back = GWF_HTML::message('WeChall', "Reset $affected players that have solved it.");
		
		# Remove from users from groups
		$gid = $chall->getGID();
		$usergroup = GDO::table('GWF_UserGroup');
		if (false === ($usergroup->deleteWhere("ug_groupid=$gid"))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		$affected = $usergroup->affectedRows();
		$back .= GWF_HTML::message('WeChall', "Removed $affected players from the challenge group.");

		# Reset votes
		Module_WeChall::includeVotes();
		if (false === $chall->getVotesDif()->resetVotesSameSettings()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		if (false === $chall->getVotesEdu()->resetVotesSameSettings()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		if (false === $chall->getVotesFun()->resetVotesSameSettings()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		if (false === $chall->onRecalcVotes()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# reset solve count and various vars
		if (false === $chall->saveVars(array(
			'chall_solvecount' => 0,
			'chall_views' => 0,
			'chall_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return $back;
	}
}
?>
