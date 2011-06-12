<?php
final class Usergroups_ShowGroups extends GWF_Method
{
	public function isLoginRequired() { return false; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^my_groups$ index.php?mo=Usergroups&me=ShowGroups'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		GWF_Module::loadModuleDB('Forum',true);
		
		if (false !== ($array = Common::getPost('part'))) {
			return $this->onPart($module, $array).$this->templateGroups($module);
		}
		return $this->templateGroups($module);
	}
	
	private function templateGroups(Module_Usergroups $module)
	{
		$ipp = 20;
		$table = GDO::table('GWF_Group');
		$by = Common::getGet('by', '');
		$dir = Common::getGet('dir', '');
		$ug = GWF_TABLE_PREFIX.'usergroup';
		$userid = GWF_Session::getUserID();
		$visible = GWF_Group::VISIBLE_GROUP;
		$conditions = "group_founder > 0 AND ( (group_options&$visible) OR (SELECT 1 FROM $ug WHERE ug_userid=$userid AND ug_groupid=group_id) )";
		$orderby = $table->getMultiOrderby($by, $dir);
		$nItems = $table->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$href_pagemenu = GWF_WEB_ROOT.'index.php?mo=Usergroups&me=ShowGroups&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%';
		$tVars = array(
			'groups' => $table->selectObjects('*', $conditions, $orderby, $ipp, $from),
			'page_menu' => GWF_PageMenu::display($page, $nPages, $href_pagemenu),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Usergroups&me=ShowGroups&amp;by=%BY%&dir=%DIR%&page=1',
			'form_action' => GWF_WEB_ROOT.'index.php?mo=Usergroups&me=ShowGroups&by='.urlencode($by).'&dir='.urlencode($dir).'&page='.$page,
			'href_add_group' => $module->getMethodURL('Create'),
			'href_edit_group' => $module->getMethodURL('Edit'),
		);
		return $module->templatePHP('groups.php', $tVars);
	}

	private function onPart(Module_Usergroups $module, $array)
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS())) {
			return GWF_HTML::error('Part Group', $error);
		}
		
		foreach ($array as $gid => $stub) { break; }
		
		if (false === ($group = GWF_Group::getByID($gid))) {
			return $module->error('err_unk_group');
		}
		
		if ($group->getFounderID() === GWF_Session::getUserID()) {
			return $module->error('err_kick_leader');
		}
		
	}
	
}
?>