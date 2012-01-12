<?php
final class Usergroups_Search extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== ($term = Common::getRequest('term'))) {
			return $this->templateUsers($this->_module, trim($term));
		}
		return $this->templateUsers($this->_module);
	}
	
	private function getFormQuick()
	{
		$data = array(
			'term' => array(GWF_Form::STRING, '', $this->_module->lang('th_user_name')),
			'search' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_search')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateUsers(Module_Usergroups $module, $term='')
	{
		$ipp = $this->_module->cfgIPP();
		$form = $this->getFormQuick($this->_module);
		$usertable = GDO::table('GWF_User');
		$by = Common::getGet('by', '');
		$dir = Common::getGet('dir', '');
		$orderby = $usertable->getMultiOrderby($by, $dir);
		
		if ($term === '')
		{
			$users = array();
			$page = 1;
			$nPages = 0;
		}
		else
		{
			$eterm = GDO::escape($term);
			$deleted = GWF_User::DELETED;
			$conditions = "user_name LIKE '%$eterm%' AND user_options&$deleted=0";
			$nItems = $usertable->countRows($conditions);
			$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
			$page = Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);
			$from = GWF_PageMenu::getFrom($page, $ipp);
			$users = $usertable->selectObjects('*', $conditions, $orderby, $ipp, $from);
		}
		
		$href_pagemenu = GWF_WEB_ROOT.'index.php?mo=Usergroups&me=Search&term='.urlencode($term).'&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%';
		$tVars = array(
			'form' => $form->templateX(false, false),#$this->_module->lang('ft_search_quick')),
			'users' => $users,
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Usergroups&me=Search&term='.urlencode($term).'&by=%BY%&dir=%DIR%&page=1',
			'page_menu' => GWF_PageMenu::display($page, $nPages, $href_pagemenu),
			'href_adv' => $this->_module->getMethodURL('SearchAdv'),
		);
		return $this->_module->templatePHP('search.php', $tVars);
	}
}
?>