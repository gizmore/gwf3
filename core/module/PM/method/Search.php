<?php
final class PM_Search extends GWF_Method
{
	# Quicksearch Fields
	private static $fields = array('pm_title', 'pm_message'); #, 'T_A.user_name', 'T_B.user_name');
	
	# Need Login
	public function isLoginRequired() { return true; }

	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=PM&me=Search',
						'page_title' => 'Pm Search',
						'page_meta_desc' => 'Search through your PMs',
				),
		);
	}

	public function execute()
	{
//		if (false !== ($errors = $this->sanitize())) {
//			return $errors;
//		}

		if (false !== ($term = Common::getRequest('term'))) {
			return $this->onQuickSearch($term);
		}
		
		if (false !== ($term = Common::getPost('search'))) {
			return $this->templateAdvSearch(true);
		}
		
		return $this->templateAdvSearch();
	}
	
//	public function sanitize()
//	{
//		return false;
//	}

	private function getFormQuick()
	{
		$data = array(
			'mo' => array(GWF_Form::HIDDEN, 'PM'),
			'me' => array(GWF_Form::HIDDEN, 'Search'),
			'term' => array(GWF_Form::STRING, Common::getRequest('term', ''), $this->module->lang('searchterm')),
			'qsearch' => array(GWF_Form::SUBMIT, $this->module->lang('btn_search')),
		);
		return new GWF_Form($this, $data, 'get', 0);
	}
	
	private function onQuickSearch($term)
	{
		$pms = GDO::table('GWF_PM');
		$by = Common::getGet('by', '');
		$dir = Common::getGet('dir', '');
		$orderby = $pms->getMultiOrderby($by, $dir);
		$ipp = $this->module->cfgPMPerPage();
		if (false === ($conditions = GWF_QuickSearch::getQuickSearchConditions($pms, self::$fields, $term)))
		{
			$conditions = '0';
		}
		$uid = GWF_Session::getUserID();
		$conditions = "($conditions) AND (pm_owner=$uid)";
		$nItems = $pms->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page')), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$result = $pms->selectObjects('*', $conditions, $orderby, $ipp, $from);# search(self::$fields, $term, $orderby, $ipp, $from);
		$href = GWF_WEB_ROOT.'index.php?mo=PM&amp;me=Search&amp;term='.urlencode($term).'&amp;page=%PAGE%&amp;by='.urlencode($by).'&amp;dir='.urlencode($dir);
		$tVars = array(
			'form_q' => $this->getFormQuick()->templateX($this->module->lang('ft_quicksearch'), false, GWF_WEB_ROOT.'index.php?mo=PM&me=Search'),
//			'form_a' => $this->getFormAdv()->templateY($this->module->lang('ft_advsearch')),
			'term' => $term,
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $href),
			'pms' => $result,
			'form_action' => htmlspecialchars(GWF_WEB_ROOT.'index.php?mo=PM&me=Search'),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=PM&amp;me=Search&amp;term='.urlencode($term).'&amp;by=%BY%&amp;dir=%DIR%',
		);
		return $this->module->templatePHP('search.php', $tVars);
	}
	
//	private function templateSearch(array $pms)
//	{
//		$tVars = array(
//			'form_q' => $this->getFormQuick()->templateX($this->module->lang('ft_quicksearch'), false),
//			'form_a' => $this->getFormAdv()->templateY($this->module->lang('ft_advsearch')),
//			'term' => $term,
//			'pagemenu' => GWF_PageMenu::display($page, $nPages, $href),
//			'pms' => $pms,
//			'form_action' => $this->getMethodHref(),
//		);
//		return $this->module->templatePHP('search.php', $tVars);
//	}

	private function getFormAdv()
	{
		$data = array(
			'from' => array(GWF_Form::STRING, '', $this->module->lang('from')),
			'to' => array(GWF_Form::STRING, '', $this->module->lang('to')),
			'pm_title' => array(GWF_Form::STRING, '', $this->module->lang('th_pm_title')),
			'pm_message' => array(GWF_Form::STRING, '', $this->module->lang('th_pm_message')),
			'search' => array(GWF_Form::SUBMIT, $this->module->lang('btn_search')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onAdvSearch()
	{
//		GDO::table('GWF_PM')->searchAdv(GWF_Session::getUser(), $_POST, $orderby, $ipp, GWF_PageMenu::getFrom(Common::get))
	}
	
	private function templateAdvSearch($onSearch=false)
	{
		$pms = GDO::table('GWF_PM');
		if ($onSearch)
		{
			$uid = GWF_Session::getUserID();
			$_POST['T_B.user_name'] = isset($_POST['from']) ? $_POST['from'] : '';
			$_POST['T_A.user_name'] = isset($_POST['to']) ? $_POST['to'] : '';
			$conditions = $pms->getAdvSearchConditions(GWF_Session::getUser(), $_POST);
			
			if ($conditions === '')
			{
				$result = array();
			}
			else
			{
				$conditions = "($conditions) AND (pm_to=$uid OR pm_from=$uid)";
				$result = $conditions === '' ? array() : $result = $pms->selectObjects('*', $conditions, 'pm_date DESC');
	
				$_POST['to'] = '';
				$_POST['from'] = '';
				$_POST['pm_title'] = '';
				$_POST['pm_message'] = '';
			}
		}
		else
		{
			$result = array();
		}
		$tVars = array(
			'form_q' => $this->getFormQuick()->templateX($this->module->lang('ft_quicksearch'), GWF_WEB_ROOT.'index.php?mo=PM&me=Search'),
			'form_a' => $this->getFormAdv()->templateY($this->module->lang('ft_advsearch')),
			'term' => '',
			'pagemenu' => '',
			'pms' => $result,
			'form_action' => GWF_WEB_ROOT.'index.php?mo=PM&me=Search',
			'sort_url' => '',
		);
		return $this->module->templatePHP('search.php', $tVars);
	}
}

?>
