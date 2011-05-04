<?php

final class WeChall_SiteEdit extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^site/edit/(\d+)/? index.php?mo=WeChall&me=SiteEdit&siteid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		require_once 'module/WeChall/WC_SiteAdmin.php';
		
		if (false === ($site = WC_Site::getByID(Common::getGet('siteid')))) {
			return $module->error('err_site');
		}
		
		if (false === ($is_admin = GWF_User::isAdminS())) {
			if (false === ($site->isSiteAdmin(GWF_Session::getUser()))) {
				return GWF_HTML::err('ERR_NO_PERMISSION');
			}
		}
		
		if (false !== Common::getPost('add_sitemin')) {
			return $this->onAddSitemin($module, $site, $is_admin).$this->templateEdit($module, $site, $is_admin);
		}
		if (false !== Common::getPost('rem_sitemin')) {
			return $this->onRemSitemin($module, $site, $is_admin).$this->templateEdit($module, $site, $is_admin);
		}
		
		if (false !== Common::getPost('rem_logo')) {
			return $this->onRemLogo($module, $site, $is_admin).$this->templateEdit($module, $site, $is_admin);
		}
		if (false !== Common::getPost('set_logo')) {
			return $this->onSetLogo($module, $site, $is_admin).$this->templateEdit($module, $site, $is_admin);
		}
		
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit($module, $site, $is_admin).$this->templateEdit($module, $site, $is_admin);
		}
		return $this->templateEdit($module, $site, $is_admin);
	}
	
	public function templateEdit(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$form = $this->getForm($module, $site, $is_admin);
		$form_logo = $this->getFormLogo($module, $site, $is_admin);
		$form_sitemin = $this->getFormSiteAdmin($module, $site, $is_admin);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit_site', $site->displayName())),
			'href_update_all' => $module->hrefDDOS($site->getVar('site_id')),
			'href_update_one' => $module->getMethodURL('SiteUpdateUser', '&siteid='.$site->getVar('site_id')),
			'form_logo' => $form_logo->templateY($module->lang('ft_edit_site_logo', $site->displayName())),
			'form_site_admin' => $form_sitemin->templateX($module->lang('ft_edit_site_admin', $site->displayName())),
			'href_edit_descr' => $module->getMethodURL('SiteDescr', '&siteid='.$site->getVar('site_id')),
		);
		return $module->template('site_edit.php', array(), $tVars);
	}

	public function getForm(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$data = array();
		
		$data['site_name'] = array(GWF_Form::STRING, $site->getVar('site_name'), $module->lang('th_site_name'), 24);
		
		if ($is_admin) {
			$data['site_classname'] = array(GWF_Form::STRING, $site->getVar('site_classname'), $module->lang('th_site_classname'), 16);
			$data['site_basescore'] = array(GWF_Form::INT, $site->getVar('site_basescore'), $module->lang('th_site_basescore'));
			$data['site_usercount'] = array(GWF_Form::INT, $site->getVar('site_usercount'), $module->lang('th_site_usercount'));
			$data['site_challcount'] = array(GWF_Form::INT, $site->getVar('site_challcount'), $module->lang('th_site_challcount'));
			$data['site_powarg'] = array(GWF_Form::INT, $site->getVar('site_powarg'), $module->lang('th_site_powarg'));
			$data['site_spc'] = array(GWF_Form::INT, $site->getVar('site_spc'), $module->lang('th_site_spc'));
			$data['site_color'] = array(GWF_Form::STRING, $site->getVar('site_color'), $module->lang('th_site_color'));
		}
		
		$data['site_status'] = array(GWF_Form::SELECT, $this->getStatusSelect($module, $site), $module->lang('th_site_status'));
		
		$data['auto_update'] = array(GWF_Form::CHECKBOX, $site->hasAutoUpdate(), $module->lang('th_autoupdate'));
		$data['onsite_rank'] = array(GWF_Form::CHECKBOX, $site->hasOnSiteRank(), $module->lang('th_site_has_osr'));
		$data['default_hide'] = array(GWF_Form::CHECKBOX, $site->isDefaultHidden(), $module->lang('th_default_hide'));
		
		$data['div0'] = array(GWF_Form::DIVIDER);
		
		if ($is_admin) {
			$data['divi0'] = array(GWF_Form::HEADLINE, $module->lang('pi_site_tags', $site->displayTags(true)));
			$data['site_tags'] = array(GWF_Form::STRING, $site->getVar('site_tags'), $module->lang('th_site_tags'), 32);
		}
		
		$data['site_country'] = array(GWF_Form::SELECT, GWF_Country::getCountrySelectS('site_country', $site->getCountryID()), $module->lang('th_site_country2'));
		if ($is_admin) {
			$data['site_language'] = array(GWF_Form::SELECT, GWF_Language::getLanguageSelectS('site_language', $site->getLangID()), $module->lang('th_site_language2'));
		}
		if ($is_admin) {
			$data['site_joindate'] = array(GWF_Form::STRING, $site->getVar('site_joindate'), $module->lang('th_site_joindate'), GWF_Date::LEN_SECOND);
		}
		$data['site_launchdate'] = array(GWF_Form::DATE, $site->getVar('site_launchdate'), $module->lang('th_site_launchdate'), GWF_Date::LEN_DAY);
		
		if ($is_admin) {
			$data['site_authkey'] = array(GWF_Form::STRING, $site->getVar('site_authkey'), $module->lang('th_site_authkey'), 32);
		}
		
		$data['site_xauthkey'] = array(GWF_Form::STRING, $site->getVar('site_xauthkey'), $module->lang('th_site_xauthkey'), 32);

		$data['site_irc'] = array(GWF_Form::STRING, $site->getVar('site_irc'), $module->lang('th_site_irc'));
		
		$data['div2'] = array(GWF_Form::DIVIDER);
		$data['div3'] = array(GWF_Form::STEXT, $module->lang('pi_site_urls'));
		$data['site_url'] = array(GWF_Form::STRING, $site->getVar('site_url'), $module->lang('th_site_url'), 32);
		$data['site_url_mail'] = array(GWF_Form::STRING, $site->getVar('site_url_mail'), $module->lang('th_site_url_mail'), 32);
		$data['site_url_score'] = array(GWF_Form::STRING, $site->getVar('site_url_score'), $module->lang('th_site_url_score'), 32);
		$data['site_url_profile'] = array(GWF_Form::STRING, $site->getVar('site_url_profile'), $module->lang('th_site_url_profile'), 32);
		
//		$data['site_description'] = array(GWF_Form::MESSAGE, $site->getVar('site_description'), $module->lang('th_site_description'));
		

		$data['edit'] = array(GWF_Form::SUBMIT, $module->lang('btn_edit_site'));
		
		return new GWF_Form($this, $data);
	}
	
	private function getStatusSelect(Module_WeChall $module, WC_Site $site, $name='site_status')
	{
		$back = sprintf('<select name="%s">', $name);
		foreach (WC_Site::$STATES as $state)
		{
			$sel = GWF_HTML::selected($site->getStatus() === $state);
			$back .= sprintf('<option value="%s"%s>%s</option>', $state, $sel, $module->lang('site_state_'.$state));
		}
		return $back . '</select>';
	}

	/**
	 * Get the form to upload a logo.
	 * I chose a separate form because logo stuff can be separated from other settings.
	 * This prevents accidantal deletion of icons in case of pressing return (or else this button has to be last).
	 * @param Module_WeChall $module
	 * @param WC_Site $site
	 * @param unknown_type $is_admin
	 * @return unknown_type
	 */
	public function getFormLogo(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$data = array();
		$buttons = array();
		if ($site->hasLogo()) {
			$buttons['rem_logo'] = $module->lang('btn_rem_logo');
			$data['current_logo'] = array(GWF_Form::STEXT, $site->displayLogo(), $module->lang('th_site_logo'));
		}
		$buttons['set_logo'] = $module->lang('btn_set_logo');
		$data['new_logo'] = array(GWF_Form::FILE, '', $module->lang('th_site_new_logo'));
		$data['cmd'] = array(GWF_Form::SUBMITS, $buttons);
		return new GWF_Form($this, $data);
	}
	
	public function getFormSiteAdmin(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $module->lang('th_user_name')),
			'add_sitemin' => array(GWF_Form::SUBMIT, $module->lang('btn_add_sitemin')),
			'rem_sitemin' => array(GWF_Form::SUBMIT, $module->lang('btn_rem_sitemin')),
		);
		return new GWF_Form($this, $data);
	}
	
	####################
	### Logo Actions ###
	####################
	public function onRemLogo(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$site->saveOption(WC_Site::HAS_LOGO, false);
	}
	
	public function onSetLogo(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$form = $this->getFormLogo($module, $site, $is_admin);
		if (false !== ($errors = $form->validate($module))) {
			return $errors;
		}
		
		# Upload Icon
		if (false === ($file = $form->getVar('new_logo'))) {
			return $module->error('err_no_logo');
		}
		
//		if (!(GWF_Upload::isImageFile($file))) {
//			return $module->error('err_no_logo');
//		}

		if (false === GWF_Upload::resizeImage($file, 32, 32, 32, 32)) {
			return $module->error('err_no_logo');
		}
		
		$sid = $site->getID();
		$filename = 'dbimg/logo/'.$sid;
		if (false === ($file = GWF_Upload::moveTo($file, $filename))) {
			return $module->error('err_write_logo', $filename);
		}
		
		# Convert to GIF
		if (false === ($img = imagecreatefromstring(file_get_contents($filename)))) {
			return $module->error('err_no_logo');
		}
		$filenamegif = 'dbimg/logo_gif/'.$sid.'.gif';
		if (false === imagegif($img, $filenamegif)) {
			return $module->error('err_write_logo', $filenamegif);
		}
		imagedestroy($img);
		
		
		
		$site->increase('site_logo_v', 1);
		$site->saveOption(WC_Site::HAS_LOGO);
	}
	
	##################
	### Validators ###
	##################
	public function validate_site_name(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_name', $arg, 3, 32); }
	public function validate_site_classname(Module_WeChall $m, $arg) { return GWF_Form::validateClassname($m, 'site_classname', $arg, 2, 24); }
	public function validate_site_basescore(Module_WeChall $m, $arg) {  return GWF_Validator::validateInt($m, 'site_basescore', $arg, 0, 20000); }
	public function validate_site_usercount(Module_WeChall $m, $arg) {  return GWF_Validator::validateInt($m, 'site_usercount', $arg, 0); }
	public function validate_site_challcount(Module_WeChall $m, $arg) {  return GWF_Validator::validateInt($m, 'site_challcount', $arg, 0); }
	public function validate_site_country(Module_WeChall $m, $arg) { return GWF_Country::validate_countryid($arg, false); }
	public function validate_site_language(Module_WeChall $m, $arg) { return GWF_Language::validate_langid($arg, false); }
	public function validate_site_joindate(Module_WeChall $m, $arg) { return GWF_Form::validateDate($m, 'site_joindate', $arg, GWF_Date::LEN_SECOND, true); }
	public function validate_site_launchdate(Module_WeChall $m, $arg) { return GWF_Form::validateDate($m, 'site_launchdate', $arg, GWF_Date::LEN_DAY, true); }
	public function validate_site_authkey(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_authkey', $arg, 0, 32); }
	public function validate_site_xauthkey(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_xauthkey', $arg, 0, 32); }
	public function validate_site_irc(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_site_irc', $arg, 0, 255); }
	public function validate_site_url(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_url', $arg, 0, 255); }
	public function validate_site_url_mail(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_url_mail', $arg, 0, 255); }
	public function validate_site_url_score(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_url_score', $arg, 0, 255); }
	public function validate_site_url_profile(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_url_profile', $arg, 0, 255); }
	public function validate_site_description(Module_WeChall $m, $arg) { return GWF_Form::validateString($m, 'site_description', $arg, 0, 4096); }
	public function validate_site_status(Module_WeChall $m, $arg) { return (false === (in_array($arg, WC_Site::$STATES, true))) ? $m->lang('err_site_status') : false; }
	public function validate_site_tags(Module_WeChall $m, $arg) { return GWF_Form::validateTags($m, 'site_tags', $arg, 3, 32); }
	public function validate_username(Module_WeChall $m, $arg) { return (false === GWF_User::getByName($arg)) ? GWF_HTML::lang('ERR_UNKNOWN_USER') : false; }
	public function validate_site_spc(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'site_spc', $arg, 0, 100, true); }
	public function validate_site_powarg(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'site_powarg', $arg, 0, 10000, true); }
	public function validate_site_color(Module_WeChall $m, $arg) { return preg_match('/^[a-z0-9]{6}$/i', $arg) ? false : $m->lang('err_site_color'); }
	##############
	### OnEdit ###
	##############
	public function onEdit(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$form = $this->getForm($module, $site, $is_admin);
		if (false !== ($errors = $form->validate($module))) {
			return $errors;
		}
		
		$basescore_changed = $language_changed = $status_changed = $spc_changed = $powarg_changed = false;
		
		if ($is_admin)
		{
			$basescore_changed = $form->getVar('site_basescore') != $site->getBasescore();
			$language_changed = $form->getVar('site_language') !== $site->getLangID();
			$status_changed = $form->getVar('site_status') !== $site->getStatus();
			$spc_changed = $form->getVar('site_spc') !== $site->getVar('site_spc');
			$powarg_changed = $form->getVar('site_powarg') !== $site->getVar('site_powarg');
			
			$site->saveVars(array(
				'site_classname' => $form->getVar('site_classname'),
				'site_basescore' => $form->getVar('site_basescore'),
				'site_usercount' => $form->getVar('site_usercount'),
				'site_challcount' => $form->getVar('site_challcount'),
				'site_joindate' => $form->getVar('site_joindate'),
				'site_authkey' => $form->getVar('site_authkey'),
				'site_status' => $form->getVar('site_status'),
				'site_language' => $form->getVar('site_language'),
				'site_spc' => $form->getVar('site_spc'),
				'site_powarg' => $form->getVar('site_powarg'),
				'site_color' => $form->getVar('site_color'),
			));
		}
		$site->saveVars(array(
			'site_name' => $form->getVar('site_name'),
			'site_country' => $form->getVar('site_country'),
			'site_launchdate' => $form->getVar('site_launchdate'),
			'site_xauthkey' => $form->getVar('site_xauthkey'),
			'site_irc' => $form->getVar('site_irc'),
			'site_url' => $form->getVar('site_url'),
			'site_url_mail' => $form->getVar('site_url_mail'),
			'site_url_score' => $form->getVar('site_url_score'),
			'site_url_profile' => $form->getVar('site_url_profile'),
//			'site_description' => $form->getVar('site_description'),
		));
		
		$site->setVar('site_country', GWF_Country::getByID($form->getVar('site_country')));
		$site->setVar('site_language', GWF_Language::getByID($form->getVar('site_language')));
		
		# Update tags if Admin
		if ($is_admin)
		{
			$new_tags = $form->getVar('site_tags');
			if ($site->getTags() !== $new_tags) {
				echo GWF_HTML::message('WeChall', 'Fixing challenge site tags..');
				$site->saveVar('site_tags', str_replace(' ', '', $new_tags));
				require_once 'module/WeChall/WC_SiteCats.php';
				WC_SiteCats::fixCatBits();
			}
		}
		
		$site->saveOption(WC_Site::AUTO_UPDATE, isset($_POST['auto_update']));
		$site->saveOption(WC_Site::HIDE_BY_DEFAULT, isset($_POST['default_hide']));
		$site->saveOption(WC_Site::ONSITE_RANK, isset($_POST['onsite_rank']));
		
		# Recalculate in case of a change
//		if ($site->isScored())
//		{
			if ($basescore_changed || $language_changed || $status_changed || $powarg_changed || $spc_changed) {
				$site->recalcSite();
				WC_RegAt::calcTotalscores();
			}
//		}
		
		return $module->message('msg_site_edited', $site->displayName());
	}	

	##################
	### Site Admin ###
	##################
	public function onAddSitemin(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$form = $this->getFormSiteAdmin($module, $site, $is_admin);
		if (false !== ($errors = $form->validate($module))) {
			return $errors;
		}
		
		if (false === ($user = GWF_User::getByName($_POST['username']))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (true === WC_SiteAdmin::isSiteAdmin($user->getID(), $site->getID())) {
			return $module->error('err_sitemin_dup', $user->displayUsername(), $site->displayName());
		}
		
		if (false === WC_SiteAdmin::makeSiteAdmin($user->getID(), $site->getID())) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $module->message('msg_sitemin_add', $user->displayUsername(), $site->displayName());
		
	}

	public function onRemSitemin(Module_WeChall $module, WC_Site $site, $is_admin)
	{
		$form = $this->getFormSiteAdmin($module, $site, $is_admin);
		if (false !== ($errors = $form->validate($module))) {
			return $errors;
		}
		
		if (false === ($user = GWF_User::getByName($_POST['username']))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false === WC_SiteAdmin::isSiteAdmin($user->getID(), $site->getID())) {
			return $module->error('err_not_sitemin', $user->displayUsername(), $site->displayName());
		}
		
		if (false === WC_SiteAdmin::remSiteAdmin($user->getID(), $site->getID())) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $module->message('msg_sitemin_rem', $user->displayUsername(), $site->displayName());
		
	}
}

?>
