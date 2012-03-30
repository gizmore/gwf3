<?php
/**
 * Give an overview of all generated pages and how you can add new.
 * @author gizmore
 */
final class PageBuilder_Overview extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^pages/?$ index.php?mo=PageBuilder&me=Overview'.PHP_EOL;
	}
	
	public function execute()
	{
		$module = $this->module;
		$module instanceof Module_PageBuilder;
		
		$user = GWF_User::getStaticOrGuest();
		
		GWF_Website::setMetaTags($module->lang('mt_overview'));
		GWF_Website::setMetaDescr($module->lang('md_overview'));
		GWF_Website::setPageTitle($module->lang('overview_title'));
		
		$tVars = array(
			'add_perms' => $module->isAuthor($user),
			'add_guest' => $module->cfgLockedPosting(),
			'href_add' => GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Add',
			'href_search' => GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Search',
// 			'title' => $module->lang('title_overview'),
// 			'info' => $module->lang('info_overview'),
		);
		return $this->module->template('overview.tpl', $tVars);
	}
}
?>