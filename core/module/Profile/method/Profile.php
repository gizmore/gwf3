<?php
final class Profile_Profile extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^profile/([^/]+)/?$ index.php?mo=Profile&me=Profile&username=$1'.PHP_EOL;
	}

	public function execute()
	{
		if (false === ($user = GWF_User::getByName(Common::getGet('username')))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if ($user->isDeleted()) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		$uname = $user->displayUsername();
		GWF_Website::setPageTitle($this->module->lang('pt_profile', array($uname, $uname)));
		GWF_Website::setMetaTags($this->module->lang('mt_profile', array($uname, $uname)));
		GWF_Website::setMetaDescr($this->module->lang('md_profile', array($uname, $uname)));

		return $this->profile($user);
	}

    public function getOGImage()
    {
        if ($user = GWF_User::getByName(Common::getGet('username')))
        {
            if ($user->hasAvatar())
            {
                return Common::getProtocol() . "://" . GWF_DOMAIN . $user->getAvatarURL();
            }
        }
        return parent::getOGImage();
    }

    private function profile(GWF_User $user)
	{
		if (false === ($profile = GWF_Profile::getProfile($user->getID()))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		$watcher = GWF_User::getStaticOrGuest();
		if ($profile->isRobotHidden() && $watcher->isWebspider()) {
			return $this->module->error('err_no_spiders');
		}
		
		if (false === ($prof_view = GWF_Session::getOrDefault('prof_view', false))) {
			$prof_view = array();
		}
		
		$uid = $user->getID();
		if (!in_array($uid, $prof_view, true)) {
			$prof_view[] = $uid;
			if (false === $profile->increase('prof_views', 1)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		
		$prof_view = array_slice($prof_view, 0, 50); # max 50 items to prevent session overflow.
		
		GWF_Session::set('prof_view', $prof_view);
		
		$tVars = array(
			'user' => $user,
			'profile' => $profile,
			'jquery' => Common::getGet('ajax') !== false,
		);
		return $this->module->templatePHP('profile.php', $tVars);
	}
}

?>