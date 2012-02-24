<?php

/**
 * @author gizmore
 */
final class Admin_Groups extends GWF_Method
{
	private $by;
	private $dir;
	private $page;
	private $nPages;
	private $nGroups;
	
	##################
	### GWF_Method ###
	##################
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=Admin&me=Groups',
						'page_title' => 'Groups',
						'page_meta_desc' => 'Groups list',
				),
		);
	}
	
	public function execute()
	{
//		if (false !== ($error = $this->sanitize())) {
//			return $error;
//		}
//		
		return $this->module->templateNav().$this->templateGroups();
	}
	
	################
	### Sanitize ###
	################
//	private function sanitize()
//	{
//		return false;
//	}
	
	##############
	### Groups ###
	##############
	private function templateGroups()
	{
		$grps = GDO::table('GWF_Group');
		$by = Common::getGet('by', 'group_id');
		$dir = Common::getGet('dir', 'ASC');
		$orderby = $grps->getMultiOrderby($by, $dir);
		$page = intval(Common::getGet('page', 1));
		$ipp = $this->module->cfgUsersPerPage();
		$nItems = $grps->countRows();
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp($page, 1, $nPages);
		$pmhref= GWF_WEB_ROOT.sprintf('index.php?mo=Admin&me=Groups&by=%s&dir=%s&page=%%PAGE%%', urlencode($by), urlencode($dir));
		$tVars = array(
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $pmhref),
			'groups' => $grps->selectObjects('*', '', $orderby, $ipp, GWF_PageMenu::getFrom($page, $ipp)),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Admin&me=Groups&by=%BY%&dir=%DIR%&page=1',
			'href_add' => GWF_WEB_ROOT.'index.php?mo=Admin&me=GroupAdd',
//			'table' => GWF_Table::displayGDO($this->module, GDO::table('GWF_Group'), GWF_Session::getUser(), $this->getMethodHref()),
		);
		return $this->module->templatePHP('groups.php', $tVars);
	}
	
}

?>