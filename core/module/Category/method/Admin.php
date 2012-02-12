<?php

final class Category_Admin extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^category/admin/?$ index.php?mo=Category&me=Admin'.PHP_EOL;
//		return $this->getHTAccessMethod();
	}
	
	public function execute()
	{
		return $this->templateAdmin();
	}
	
	public function templateAdmin()
	{
		$tVars = array(
			'cats' => GWF_Category::getAllCategoriesCached(),
			'by' => 'catid',
			'dir' => 'asc',
			'sort_url' => '',
			'url_new' => GWF_WEB_ROOT.'category/add',
		);
		return $this->module->templatePHP('admin.php', $tVars);
	}
}

?>