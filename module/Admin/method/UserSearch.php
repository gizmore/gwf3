<?php

final class Admin_UserSearch extends GWF_Method
{
	const DEFAULT_BY = 'user_regdate';
	const DEFAULT_DIR = 'DESC';
	
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute(GWF_Module $module)
	{
		$nav = $module->templateNav();
		
		if (false !== Common::getPost('search') || false !== Common::getGet('term')) {
			return $nav.$this->onSearch($module);
		}
		return $nav.$this->templateSearch($module);
	}
	
	public function getForm(Module_Admin $module)
	{
		$data = array(
			'term' => array(GWF_Form::STRING, Common::getRequest('term', ''), GWF_HTML::lang('term'), 40),
			'search' => array(GWF_Form::SUBMIT, GWF_HTML::lang('search'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateSearch(Module_Admin $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'searched' => false,
			'form' => $form->templateX($module->lang('ft_search'), false),
			'hits' => 0,
			'users' => array(),
			'term' => Common::getRequest('term', ''),
			'pagemenu' => '',
			'by' => '',
			'dir' => '',
			'sort_url' => '',
		);
		return $module->templatePHP('user_search.php', $tVars);
	}
	
	public function validate_term(Module_Admin $module, $arg)
	{
		$arg = trim(Common::getRequest('term', ''));
		$_REQUEST['term'] = $arg;
		$len = strlen($arg);
		if ($len < GWF_QuickSearch::MIN_LEN || $len > GWF_QuickSearch::MAX_LEN) {
			return GWF_QuickSearch::errorSearchLength();
		}
		return false;
	}
	
	public function onSearch(Module_Admin $module)
	{
		$form = $this->getForm($module);
//		if (false !== ($error = $form->validate($module))) {
//			return $error.$this->templateSearch($module);
//		}
		
		$users = GDO::table('GWF_User');
		
		$term = Common::getRequest('term');
		
		if (false !== ($error = $this->validate_term($module, $term))) {
			return $error;
		}
		
		$fields = array('user_name', 'user_email');
		
		$by = Common::getGet('by', self::DEFAULT_BY);
		$dir = Common::getGet('dir', self::DEFAULT_DIR);
		$orderby = $users->getMultiOrderby($by, $dir);
		
		$conditions = GWF_QuickSearch::getQuickSearchConditions($users, $fields, $term);
		
		$hits = $users->countRows($conditions);
		
		$ipp = $module->cfgUsersPerPage();
		$nPages = GWF_PageMenu::getPagecount($ipp, $hits);
		$page = Common::clamp((int)Common::getGet('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);

		$tVars = array(
			'searched' => true,
			'form' => $form->templateX($module->lang('ft_search')),
			'hits' => $hits,
			'users' => $users->selectObjects('*', $conditions, $orderby, $ipp, $from),
			'term' => $term,
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Admin&me=UserSearch&term='.urlencode($term).'&by='.urlencode($by).'&dir='.urlencode($dir).'&page=1'),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Admin&me=UserSearch&term='.urlencode($term).'&by=%BY%&dir=%DIR%&page=1',
		);
		return $module->templatePHP('user_search.php', $tVars);
		
	}
}

?>