<?php
final class PageBuilder_Admin extends GWF_Method
{
	public function getUserGroups() { return array('admin'); }
	
	public function execute(GWF_Module $module)
	{

		return $this->templateAdmin($module);
	}
	
	private function templateAdmin(Module_PageBuilder $module)
	{
		$ipp = 50;
		$pages = GDO::table('GWF_Page');
		
		$by = Common::getGetString('by', 'page_id');
		$dir = Common::getGetString('dir', 'ASC');
		$orderby = $pages->getMultiOrderby($by, $dir);
		
		$where = "";
		
		$nItems = $pages->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$tVars = array(
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Admin&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%'),
			'pages' => $pages->selectAll('*', $where, $orderby, NULL, $ipp, $from, GDO::ARRAY_O),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Admin&by=%BY%&dir=%DIR%',
			'href_add' => $module->getMethodURL('Add'),
			'href_published' => '',
			'href_revisions' => '',
			'href_disableds' => '',
		);
		
		return $module->template('admin.tpl', $tVars);
	}
}
?>