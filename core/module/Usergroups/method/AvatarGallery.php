<?php
/**
 * Show the paginated avatar gallery.
 * @author gizmore
 *
 */
final class Usergroups_AvatarGallery extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^avatar/gallery$ index.php?mo=Usergroups&me=AvatarGallery'.PHP_EOL.
			'RewriteRule ^avatar/gallery/show/(\d+)$ index.php?mo=Usergroups&me=AvatarGallery&show=$1'.PHP_EOL.
			'RewriteRule ^avatar/gallery/page-(\d+)$ index.php?mo=Usergroups&me=AvatarGallery&page=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($userid = Common::getGet('show'))) {
			return $this->onShowAvatar((int)$userid);
		}
		
		return $this->page();
	}
	
	private function onShowAvatar($userid)
	{
		if (false === ($user = GWF_User::getByID($userid))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false === GWF_AvatarGallery::onViewed($user)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		GWF_Website::redirect(GWF_WEB_ROOT.'profile/'.$user->urlencode('user_name'));
		
		return "Redirecting...";
	}
	
	private function page()
	{
		$db = gdo_db();
		$users = GWF_TABLE_PREFIX.'user';
		$ag = GWF_TABLE_PREFIX.'user_avatar_g';
		$has_av = GWF_User::HAS_AVATAR;
		$usert = GDO::table('GWF_User');
		
		$num_x = $this->_module->cfgAvatarsX();
		$num_y = $this->_module->cfgAvatarsY();
		$ipp = $num_x * $num_y;
		$nItems = $usert->countRows("user_options&$has_av>0");
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$limit = $usert->getLimit($ipp, $from);
		
		$query = "SELECT user_id,user_name,user_avatar_v,ag_hits,user_level FROM $users LEFT JOIN $ag ON ag_uid=user_id AND ag_version=user_avatar_v WHERE user_options&$has_av>0  ORDER BY ag_hits DESC, user_level DESC $limit";
		
		GWF_Website::setPageTitle($this->_module->lang('pt_avatars'));
		GWF_Website::setMetaDescr($this->_module->lang('md_avatars'));
		GWF_Website::setMetaTags($this->_module->lang('mt_avatars'));
		
		$tVars = array(
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'avatar/gallery/page-%PAGE%'),
			'avatars' => $db->queryAll($query),
			'num_x' => $num_x,
			'num_y' => $num_y,
		);
		return $this->_module->templatePHP('avatars.php', $tVars);
	}
}

?>