<?php
/**
 * Voting overview.
 * @author gizmore
 */
final class Votes_Staff extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::STAFF; }
	public function execute(GWF_Module $module)
	{
		// Single
		if (false !== ($vsid = Common::getGet('editvs')))
		{
			// Validate
			if (false === ($vs = GWF_VoteScore::getByID($vsid))) {
				return $module->error('err_votescore');
			}

			// Edit
			if (false !== Common::getPost('editvs')) {
				return $this->onEdit($module, $vs);
			}
			
			// Single Template
			return $this->templateEdit($module, $vs);
		}
		
		// Table
		return $this->templateVotes($module);
	}
	
	private function templateVotes(Module_Votes $module)
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
		
		return $module->templatePHP('staff.php', $tVars);
	}
	
	private function formEdit(Module_Votes $module, GWF_VoteScore $vs)
	{
		$data = array();
		
		$data['editvs'] = array(GWF_Form::SUBMIT, $module->lang('btn_edit'));
		
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit(Module_Votes $module, GWF_VoteScore $vs)
	{
		$form = $this->formEdit($module, $vs);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit_vs')),
		);
		return $module->template('edit_vs.tpl', $tVars);
	}
}
?>
