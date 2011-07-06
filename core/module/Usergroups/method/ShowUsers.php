<?php
final class Usergroups_ShowUsers extends GWF_Method
{
	public function isLoginRequired() { return false; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^users_in_group/(\d+)/[^/]+$ index.php?mo=Usergroups&me=ShowUsers&gid=$1'.PHP_EOL.
			'RewriteRule ^users_in_group/(\d+)/[^/]+/by/page-(\d+)$ index.php?mo=Usergroups&me=ShowUsers&gid=$1&page=$2'.PHP_EOL.
			'RewriteRule ^users_in_group/(\d+)/[^/]+/by/([^/]+)/([ADESC,]+)/page-(\d+)$ index.php?mo=Usergroups&me=ShowUsers&gid=$1&by=$2&dir=$3&page=$4'.PHP_EOL.
			'';
	}

	public function execute(GWF_Module $module)
	{
		if (false === ($group = GWF_Group::getByID(Common::getGet('gid')))) {
			return $module->error('err_unk_group');
		}
		
		if ($group->isOptionEnabled(GWF_Group::VISIBLE_MEMBERS))
		{
		}
		else switch ($group->getVisibleMode())
		{
			case GWF_Group::VISIBLE:
				break;
				
			case GWF_Group::COMUNITY:
				if (!GWF_Session::isLoggedIn()) {
					return GWF_HTML::err('ERR_NO_PERMISSION');
				}
				break;
				
			case GWF_Group::HIDDEN:
			case GWF_Group::SCRIPT:
				if (!GWF_User::isInGroupS($group->getVar('group_name')))
				{
					return $module->error('err_not_invited');
				}
				break;
				
			default:
				return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		return $this->templateUsers($module, $group);
	}
	
	private function templateUsers(Module_Usergroups $module, GWF_Group $group)
	{
		$users = GDO::table('GWF_User');
		
		$gid = $group->getVar('group_id');
		$gn = $group->urlencode('group_name');
		
		$by = Common::getGet('by', '');
		$dir = Common::getGet('dir', '');
		$orderby = $users->getMultiOrderby($by, $dir);
		
		$ipp = 50;
		$nItems = $group->getVar('group_memberc');
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$ug = GWF_TABLE_PREFIX.'usergroup';
		$hidden = GWF_UserGroup::HIDDEN;
		$conditions = "(SELECT 1 FROM $ug WHERE ug_userid=user_id AND ug_groupid=$gid AND ug_options&$hidden=0)";
		
		$tVars = array(
			'sort_url' => GWF_WEB_ROOT.'users_in_group/'.$gid.'/'.$gn.'/by/%BY%/%DIR%/page-1',
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.sprintf('users_in_group/%s/%s/by/%s/%s/page-%%PAGE%%', $gid, $gn, urlencode($by), urlencode($dir))),
			'users' => $users->selectObjects('*', $conditions, $orderby, $ipp, $from),
		);
		return $module->templatePHP('users.php', $tVars);
	}
	
}
?>