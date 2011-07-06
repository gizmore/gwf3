<?php

final class Category_Admin extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^category/admin/?$ index.php?mo=Category&me=Admin'.PHP_EOL;
//		return $this->getHTAccessMethod($module);
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->templateAdmin($module);
	}
	
	public function templateAdmin(Module_Category $module)
	{
		$tVars = array(
			'cats' => GWF_Category::getAllCategoriesCached(),
			'by' => 'catid',
			'dir' => 'asc',
			'sort_url' => '',
			'url_new' => GWF_WEB_ROOT.'category/add',
		);
		return $module->templatePHP('admin.php', $tVars);
	}
}

?>