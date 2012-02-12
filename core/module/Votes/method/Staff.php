<?php
/**
 * Voting overview.
 * @author gizmore
 */
final class Votes_Staff extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::STAFF; }
	public function execute()
	{
		// Single
		if (false !== ($vsid = Common::getGet('editvs')))
		{
			// Validate
			if (false === ($vs = GWF_VoteScore::getByID($vsid))) {
				return $this->module->error('err_votescore');
			}

			// Edit
			if (false !== Common::getPost('editvs')) {
				return $this->onEdit($vs); # FIXME: {gizmore} missing method
			}
			
			// Single Template
			return $this->templateEdit($vs);
		}
		
		// Table
		return $this->templateVotes();
	}
	
	private function templateVotes()
	{
		$votes = GDO::table('GWF_VoteScore');
		$ipp = 50;
		$nItems = $votes->countRows();
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$by = Common::getGet('by', '');
		$dir = Common::getGet('dir', '');
		$orderby = $votes->getMultiOrderby($by, $dir);
		
		$tVars = array(
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.sprintf('index.php?mo=Votes&me=Staff&by=%s&dir=%s&page=%%PAGE%%', urlencode($by), urlencode($dir))),
			'votes' => $votes->selectObjects('*', '', $orderby, $ipp, $from),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Votes&me=Staff&by=%BY%&dir=%DIR%',
		);
		
		return $this->module->templatePHP('staff.php', $tVars);
	}
	
	private function formEdit(GWF_VoteScore $vs)
	{
		$data = array();
		
		$data['editvs'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_edit'));
		
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit(GWF_VoteScore $vs)
	{
		$form = $this->formEdit($vs);
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit_vs')),
		);
		return $this->module->template('edit_vs.tpl', $tVars);
	}
}
?>
