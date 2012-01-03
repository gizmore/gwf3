<?php
final class WeChall_API_User extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		$_GET['ajax'] = 1;
		GWF_Website::plaintext();
		
		if (false === (Common::getGet('no_session'))) {
			die('The mandatory parameter \'no_session\' is not set. Try \'&no_session=1\'.');
		}
		
		if (false === ($username = Common::getGet('username'))) {
			die('The mandatory parameter \'username\' is not set. Try \'&username=nickname\'.');
		}
		
		if (false === ($user = GWF_User::getByName($username))) {
			die(GWF_HTML::lang('ERR_UNKNOWN_USER'));			
		}
		
		die($this->showUser($module, $user, Common::getGet('apikey')));
	}
	
	private function showUser(Module_WeChall $module, GWF_User $user, $api_key)
	{
		if (false !== ($error = $module->isExcludedFromAPI($user, $api_key))) {
			return $error;
		}
		
		$private_mode = $module->isAPIKeyCorrect($user, $api_key);
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		if (false === ($regats = WC_RegAt::getRegats($user->getID(), 'regat_solved ASC'))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		require_once GWF_CORE_PATH.'module/Forum/GWF_ForumOptions.php';
		if (false === ($fopts = GWF_ForumOptions::getUserOptions($user, false))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$unknown = GWF_HTML::lang('unknown');
		
		if ('0' === ($countryid = $user->getVar('user_countryid'))) {
			$country = false;
			$cname = $unknown;
			$crank = $unknown;
		} else {
			$country = GWF_Country::getByID($countryid);
			$cname = $country->displayName();
			$crank = WC_RegAt::calcExactCountryRank($user);
		}
		
		$back = '';
		$back .= 'Username:'.$user->getVar('user_name').PHP_EOL;
		$back .= 'Country:'.$cname.PHP_EOL;
		$back .= 'Totalscore:'.$user->getVar('user_level').PHP_EOL;
		$back .= 'GlobalRank:'.WC_RegAt::calcExactRank($user).PHP_EOL;
		$back .= 'CountryRank:'.$crank.PHP_EOL;
		$back .= $this->contactData($module, $user);
		$back .= 'ForumPosts:'.$fopts->getVar('fopt_posts').PHP_EOL;
		$back .= 'ForumThanks:'.$fopts->getVar('fopt_thanks').PHP_EOL;
		$back .= 'ForumVoteUp:'.$fopts->getVar('fopt_upvotes').PHP_EOL;
		$back .= 'ForumVoteDown:'.$fopts->getVar('fopt_downvotes').PHP_EOL;
		$back .= $this->regatData($module, $user, $regats);
		if ($private_mode === true) {
			$back .= $this->privateData($module, $user);
		}
		return $back;
	}
	
	private function regatData(Module_WeChall $module, GWF_User $user, array $regats)
	{
		$back = '';
		foreach ($regats as $regat)
		{
			$regat instanceof WC_RegAt;
			$back .= sprintf('site[%s]:%.02f%%', $regat->getSite()->getVar('site_name'), $regat->getVar('regat_solved')*100).PHP_EOL;
		}
		return $back;
	}
	
	private function contactData(Module_WeChall $module, GWF_User $user)
	{
		require_once GWF_CORE_PATH.'module/Profile/GWF_Profile.php';
		if (false === ($p = GWF_Profile::getProfile($user->getID()))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if ($p->isGuestHidden() || $p->isHiddenLevel(0)) {
			return '';
		}
		$back = '';
		
		if ('' !== ($v = $p->getVar('prof_firstname'))) {
			$back .= 'FirstName:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_lastname'))) {
			$back .= 'LastName:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_street'))) {
			$back .= 'Street:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_city'))) {
			$back .= 'City:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_zip'))) {
			$back .= 'ZIPCode:'.$v.PHP_EOL;
		}
		
		
		if ($p->isContactHiddenLevel(0)) {
			return $back;
		}
		
		if ('' !== ($v = $user->displayEMail())) {
			$back .= 'EMail:'.$v.PHP_EOL;
		}
		
		if ('' !== ($v = $p->getVar('prof_tel'))) {
			$back .= 'Tel:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_mobile'))) {
			$back .= 'Mobile:'.$v.PHP_EOL;
		}
		
		if ('' !== ($v = $p->getVar('prof_icq'))) {
			$back .= 'ICQ:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_msn'))) {
			$back .= 'MSN:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_jabber'))) {
			$back .= 'Jabber:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_skype'))) {
			$back .= 'Skype:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_yahoo'))) {
			$back .= 'Yahoo!:'.$v.PHP_EOL;
		}
		if ('' !== ($v = $p->getVar('prof_aim'))) {
			$back .= 'AIM:'.$v.PHP_EOL;
		}
		
		return $back;
	}
	
	private function privateData(Module_WeChall $module, GWF_User $user)
	{
		$back = '';
		$ulc = WC_HTML::getUnreadLinksCount($user);
		$back .= 'NewLinks:'.$ulc.PHP_EOL;
		$utc = WC_HTML::getUnreadThreadCount($user);
		$back .= 'NewThreads:'.$utc.PHP_EOL;
		$upc = WC_HTML::getUnreadPMCount($user);
		$back .= 'NewPMs:'.$upc.PHP_EOL;
		return $back;
	}
	
}
?>