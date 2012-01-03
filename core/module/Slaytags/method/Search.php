<?php
final class Slaytags_Search extends GWF_Method
{
	const IPP = 50;
	const BY = 'ss_id';
	const DIR = 'ASC';
	
	public function execute(GWF_Module $module)
	{
		require_once GWF_CORE_PATH.'module/Slaytags/Slay_TagSelect.php';

		if (isset($_GET['searchterm']))
		{
			return $this->onSearch($module);
		}
		
		return $this->templateSearch($module);
	}

	private function templateSearch(Module_Slaytags $module)
	{
		$form = $this->formSearch($module);
		$tVars = array(
			'form' => $form->templateX($module->lang('ft_search'), GWF_WEB_ROOT.'index.php'),
			'pagemenu' => '',
			'matches' => array(),
			'sort_url' => '',
			'is_admin' => GWF_User::isStaffS(),
			'headers' => array(),
			'singletag' => NULL,
			'no_match' => false,
		);
		return $module->template('search.tpl', $tVars);
	}
	
	private function formSearch(Module_Slaytags $module)
	{
		$data = array();
		$data['mo'] = array(GWF_Form::HIDDEN, 'Slaytags');
		$data['me'] = array(GWF_Form::HIDDEN, 'Search');
		$data['searchtag'] = array(GWF_Form::SELECT, Slay_TagSelect::singleSelect('searchtag'), $module->lang('th_searchtag'));
		$data['searchterm'] = array(GWF_Form::STRING, '', $module->lang('th_searchterm'));
		$data['search'] = array(GWF_Form::SUBMIT, $module->lang('btn_search'));
		$data['by'] = array(GWF_Form::HIDDEN, self::BY);
		$data['dir'] = array(GWF_Form::HIDDEN, self::DIR);
		$data['page'] = array(GWF_Form::HIDDEN, 1);
		return new GWF_Form($this, $data, 'get', 0);
	}
	
	public function validate_searchtag($m, $arg) { return Slay_TagSelect::validateTag($m, $arg, true, true, 'searchtag'); }
	public function validate_searchterm($m, $arg) { return GWF_Validator::validateString($m, 'searchterm', $arg, 0, 63, true); }
	public function validate_by($m, $arg) { return false; }
	public function validate_dir($m, $arg) { return false; }
	public function validate_page($m, $arg) { return false; }
		
	private function onSearch(Module_Slaytags $module)
	{
		$form = $this->formSearch($module);
		if (false !== ($error = $form->validate($module)))
		{
			return $error.$this->templateSearch($module);
		}
		
		$ipp = self::IPP;
		$term = $form->getVar('searchterm');
		$tagname = NULL;
		$table = GDO::table('Slay_Song');
		$whitelist = array('(ss_lyrics>0)', '(ss_options&1)', '(ss_sid_path!=NULL)');
		$joins = array('lyrics');
		if (false === ($where = GWF_QuickSearch::getQuickSearchConditions($table, array('ss_artist', 'ss_title', 'ss_composer'), $term)))
		{
			return GWF_HTML::err('ERR_SEARCH_TERM').$this->templateSearch($module);
		}
		$term2 = GDO::escape($term);
//		$term2 = str_replace(array('%', '_'), array('\\%', '\\_'), $term);
		$term3 = '1';
		if ('0' !== ($tag = $form->getVar('searchtag')))
		{
			$tagname = Slay_Tag::getNameByID($tag);
			$term3 = 'sst_count>0';
			$joins[] = 'searchtag';
		}
		$where = "(({$where}) OR (ssl_lyrics LIKE '%{$term2}%')) AND ($term3)";
		
		
		$nItems = $table->countRows($where, $joins);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);

		$by = Common::getGetString('by', self::BY);
		$dir = Common::getGetString('dir', self::DIR);
		$orderby = $table->getMultiOrderby($by, $dir, false, $whitelist);
		
		$matches = $table->selectAll('*', $where, $orderby, $joins, $ipp, $from, GDO::ARRAY_O);
		
		$headers = array(
			array(),
			array($module->lang('L'), '(ss_lyrics>0)'),
			array($module->lang('T'), 'ss_taggers'),
			array($module->lang('D'), '(ss_options&1)'),
//			array($module->lang('S'), '(ss_sid_path!=NULL)'),
			array($module->lang('th_artist'), 'ss_artist'),
			array($module->lang('th_title'), 'ss_title'),
			array($module->lang('th_duration'), 'ss_duration'),
		);
		if ($tag > 0)
		{
			$headers[] = array($module->lang(Slay_Tag::getNameByID($tag)), 'sst_count');
		}
		$headers[] = array($module->lang('th_tags'));
		
		$tVars = array(
			'form' => $form->templateX($module->lang('ft_search'), GWF_WEB_ROOT.'index.php'),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.sprintf('index.php?mo=Slaytags&me=Search&searchterm=%s&searchtag=%s&by=%s&dir=%s&page=%%PAGE%%', urlencode($term), $tag, urlencode($by), urlencode($dir))),
			'matches' => $matches,
			'sort_url' => GWF_WEB_ROOT.sprintf('index.php?mo=Slaytags&me=Search&searchterm=%s&searchtag=%s&by=%%BY%%&dir=%%DIR%%&page=1', urlencode($term), $tag),
			'is_admin' => GWF_User::isStaffS(),
			'headers' => $headers,
			'singletag' => $tagname,
			'no_match' => (count($matches)===0),
		);
		
		return $module->template('search.tpl', $tVars);
	}
	
}
?>