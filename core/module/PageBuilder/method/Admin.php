<?php
/**
 * Admin table
 * @author gizmore
 */
final class PageBuilder_Admin extends GWF_Method
{
	public function getUserGroups() { return array('admin'); }

	const NUM_MODES = 4;
	# 4 modes
	const SHOW_PUBLISHED = 1;
	const SHOW_DISABLED = 2;
	const SHOW_LOCKED = 3;
	const SHOW_REVS = 4;
	
	public function getPageMenuLinks()
	{
		return array(
			array(
				'page_url' => 'index.php?mo=PageBuilder&me=Admin',
				'page_title' => 'PageBuilder Admin Page',
				'page_meta_desc' => 'Admin page for the Pagebuilder module',
			),
		);
	}
	
	public function execute()
	{
		return $this->templateAdmin();
	}
	
	private function templateAdmin()
	{
		$ipp = 50;
		$pages = GDO::table('GWF_Page');
		
		$by = Common::getGetString('by', 'page_id');
		$dir = Common::getGetString('dir', 'ASC');
		$orderby = $pages->getMultiOrderby($by, $dir);
		
		$mode = $this->getMode();
		$where = $this->getWhere($mode);
		
		$nItems = $pages->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$href_base = GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Admin&mode=';
		
		$tVars = array(
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Admin&mode='.$mode.'&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%'),
			'pages' => $pages->selectAll('*', $where, $orderby, NULL, $ipp, $from, GDO::ARRAY_O),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Admin&mode='.$mode.'&by=%BY%&dir=%DIR%',
			'href_add' => $this->module->getMethodURL('Add'),
			'href_published' => $href_base.self::SHOW_PUBLISHED,
			'href_revisions' => $href_base.self::SHOW_REVS,
			'href_disableds' => $href_base.self::SHOW_DISABLED,
			'href_locked' => $href_base.self::SHOW_LOCKED,
		);
		
		return $this->module->template('admin.tpl', $tVars);
	}
	
	private function getMode()
	{
		return Common::clamp(Common::getGetInt('mode', 1), 1, self::NUM_MODES);
	}

	private function getWhere($mode)
	{
		switch ($mode)
		{
			case self::SHOW_PUBLISHED:
				return 'page_options&'.(GWF_Page::ENABLED|GWF_Page::LOCKED).'='.GWF_Page::ENABLED;
			case self::SHOW_DISABLED:
				return 'page_options&'.(GWF_Page::ENABLED|GWF_Page::LOCKED).'=0';
			case self::SHOW_LOCKED:
				return 'page_options&'.(GWF_Page::LOCKED);
			case self::SHOW_REVS:
				return '';
		}
		return '';
	}
}
?>