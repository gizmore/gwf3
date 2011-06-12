<?php
/**
 * Your linked sites in the profile.
 * Add a site, hide onsitename
 * @author gizmore
 */
final class WeChall_LinkedSites extends GWF_Method
{
	private $not_linked = array();
	
	public function isLoginRequired() { return true; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 
			'RewriteRule ^linked_sites$ index.php?mo=WeChall&me=LinkedSites'.PHP_EOL.
			'RewriteRule ^link_site/(\d+)/[^/]+/to/(\d+)/as/([^/]+)/([^/]+)$ index.php?mo=WeChall&me=LinkedSites&site=$1&userid=$2&onsitename=$3&link=$4'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		require_once 'module/WeChall/WC_Freeze.php';
		require_once 'module/WeChall/WC_RegAt.php';
		
		if (false !== ($token = Common::getGet('link'))) {
			return $this->onLinkSiteAfterMailPre($module, $token, (int)Common::getGet('site', 0));
		}
		
		if (!(GWF_User::isLoggedIn())) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}

		# Hide and Show
		if (false !== ($array = Common::getPost('showname'))) {
			return $this->onHide($module, $array, 0).$this->templateSites($module);
		}
		if (false !== ($array = Common::getPost('hidename'))) {
			return $this->onHide($module, $array, 1).$this->templateSites($module);
		}

		# Link and UnLink
		if (false !== (Common::getPost('link'))) {
			return $this->onLinkSite($module).$this->templateSites($module);
		}
		if (false !== ($array = Common::getPost('unlink'))) {
			return $this->onUnLinkSite($module, $array).$this->templateSites($module);
		}
		
		# Update
		if (false !== ($array = Common::getPost('update'))) {
			return $this->onUpdate($module, $array).$this->templateSites($module);
		}
		if (false !== (Common::getPost('update_all'))) {
			return $this->onUpdateAll($module).$this->templateSites($module);
		}
		if (false !== ($siteid = Common::getGet('quick_update'))) {
			return $this->onQuickUpdate($module, $siteid);
		}
		
		return $this->templateSites($module);
	}

	################
	### Template ###
	################
	public function templateSites(Module_WeChall $module)
	{
		$whitelist = array('site_name', 'site_challcount', 'regat_score', 'site_score', 'regat_solved', 'regat_lastdate', 'regat_onsitename');
		
		$form_link = $this->getFormLink($module);
		$form_all = $this->getFormAll($module);
		
		$by = Common::getGet('by', 'site_name');
		$dir = Common::getGet('dir', 'ASC');
		$by = GDO::getWhitelistedByS($by, $whitelist, 'site_name');
		$dir = GDO::getWhitelistedDirS($dir, 'ASC');
		$orderby = "$by $dir";
		
		$tVars = array(
			'form_link' => $form_link === false ? '' : $form_link->templateX($module->lang('ft_link_site')),
			'action' => GWF_WEB_ROOT.'linked_sites',
			'linked' => $this->getLinkedSites(GWF_Session::getUserID(), $orderby),
			'form_update_all' => $form_all->templateX(),
			'can_link' => count($this->not_linked) > 0,
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=WeChall&me=LinkedSites&by=%BY%&dir=%DIR%',
		);
		return $module->templatePHP('linked_sites.php', $tVars);
	}
	
	private function getLinkedSites($userid, $orderby)
	{
//		$userid = (int) $userid;
		return GDO::table('WC_RegAt')->selectAll('*', 'regat_uid='.$userid, $orderby, array('site'));
//		$db = gdo_db();
//		$regat = GWF_TABLE_PREFIX.'wc_regat';
//		$sites = GWF_TABLE_PREFIX.'wc_site';
//		$query = "SELECT * FROM $regat JOIN $sites ON regat_sid=site_id WHERE regat_uid=$userid ORDER BY $orderby";
//		return $db->queryAll($query, true);
	}

	public function getFormLink(Module_WeChall $module)
	{
		if (false === ($this->not_linked = WC_Site::getUnlinkedSites(GWF_Session::getUserID()))) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		$user = GWF_Session::getUser();
		$data = array(
			'siteid' => array(GWF_Form::SELECT, $this->getSelectNotLinked($this->not_linked), $module->lang('th_site_name')),
			'onsitename' => array(GWF_Form::STRING, $user->getVar('user_name'), $module->lang('th_onsite_name')),
			'email' => array(GWF_Form::STRING, $user->getValidMail(), $module->lang('th_email')),
			'link' => array(GWF_Form::SUBMIT, $module->lang('btn_link')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getSelectNotLinked(array $sites, $name='siteid')
	{
		$selsiteid = (int)Common::getPost($name, 0);
		$back = sprintf('<select name="%s">', $name);
		foreach ($sites as $site)
		{
			$siteid = $site->getID();
			$sel = GWF_HTML::selected($selsiteid === $siteid);
			$back .= sprintf('<option value="%s"%s>%s</option>', $siteid, $sel, $site->displayName());
		}
		$back .= '</select>';
		return $back;
	}

	public function getFormAll(Module_WeChall $module)
	{
		$data = array(
			'update_all' => array(GWF_Form::SUBMIT, $module->lang('btn_update_all_sites')),
		);
		return new GWF_Form($this, $data);
	}
	
	#################
	### Link Site ###
	#################
	public function validate_siteid(Module_WeChall $m, $arg) { return WC_Site::validateSiteID($arg); }
	public function validate_onsitename(Module_WeChall $m, $arg) { return false; }
	public function validate_email(Module_WeChall $m, $arg) { return GWF_Form::validateEMail($m, 'email', $arg); }
	
	/**
	 * Link a site.
	 * First we check if username/email exists on that site.
	 * If so, we check if emails are the same.
	 * If not, we send some email, else we just link.
	 * @param Module_WeChall $module
	 * @return unknown_type
	 */
	private function onLinkSite(Module_WeChall $module)
	{
		$form = $this->getFormLink($module);
		if (false !== ($errors = $form->validate($module))) {
			return $errors;
		}
		
		$onsitename = Common::getPost('onsitename');
		$onsitemail = Common::getPost('email');
		
		if (false === ($site = WC_Site::getByID_Class(Common::getPost('siteid')))) {
			return $module->error('err_site');
		}
		
		if (false !== WC_RegAt::getRegatRow(GWF_Session::getUserID(), $site->getID())) {
			return $module->error('err_already_linked', $site->displayName());
		}
		
		if (WC_Freeze::isUserFrozenOnSite(GWF_Session::getUserID(), $site->getID())) {
			return $module->error('err_site_ban', $site->displayName());
		}
		
		
		if (false === ($site->isAccountValid($onsitename, $onsitemail))) {
			$key = $site->getVar('site_classname') === 'HTS' ? 'err_link_account_hts' : 'err_link_account';
			return $module->error($key, $site->displayName());
		}

		if (false !== ($regat = WC_RegAt::getByOnsitename($site->getID(), $onsitename))) {
			if (false === ($user = $regat->getUser())) {
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			else {
				return $module->error('err_onsitename_taken', htmlspecialchars($onsitename), $site->displayName(), $user->displayUsername());
			}
		}
		
		$user = GWF_Session::getUser();
		
		if ($onsitemail !== $user->getValidMail()) {
			return $this->onLinkSiteMail($module, $site, $user, $onsitename, $onsitemail);
		} else {
			return $this->onLinkSiteAfterMail($module, $site, $user, $onsitename);
		}
	}
	
	private function onLinkSiteMail(Module_WeChall $module, WC_Site $site, GWF_User $user, $onsitename, $onsitemail)
	{
		$userid = $user->getID();
		$link = Common::getAbsoluteURL(sprintf('link_site/%d/%s/to/%d/as/%s/%s', $site->getID(), $site->urlencode('site_name'), $userid, urlencode($onsitename), $site->getLinkToken($userid, $onsitename)));
		$link = GWF_HTML::anchor($link, $link);
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($onsitemail);
		$mail->setSubject($module->lang('mail_link_subj', array($site->display('site_name'))));
		$mail->setBody($module->lang('mail_link_body', array($user->displayUsername(), $site->displayName(), $link)));
		return $mail->sendToUser($user) ? $module->message('msg_linkmail_sent') : GWF_HTML::err('ERR_MAIL_SENT');
	}

	private function onLinkSiteAfterMailPre(Module_WeChall $module, $token, $siteid)
	{
		if (false === ($site = WC_Site::getByID($siteid))) {
			return $module->error('err_site');
		}
		
		if (false === ($user = GWF_User::getByID(Common::getGet('userid')))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false !== WC_RegAt::getRegatRow($user->getID(), $site->getID())) {
			return $module->error('err_already_linked', $site->displayName());
		}
		
		if (false === ($onsitename = Common::getGet('onsitename'))) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if ($token !== $site->getLinkToken($user->getID(), $onsitename)) {
			return $module->error('err_link_token');
		}
		
		return $this->onLinkSiteAfterMail($module, $site, $user, $onsitename);
	}

	public function onLinkSiteAfterMail(Module_WeChall $module, WC_Site $site, GWF_User $user, $onsitename)
	{
		if (WC_Freeze::isUserFrozenOnSite($user->getID(), $site->getID())) {
			return $module->error('err_site_ban', $site->displayName());
		}
		
		if ($site->isUserLinked($user)) {
			return $module->error('err_already_linked', $site->displayName());
		}
		
		$siteid = $site->getVar('site_id');
		$userid = $user->getVar('user_id');
		
		if (false !== WC_RegAt::getUserByOnsiteName($onsitename, $siteid)) {
			return $module->error('err_already_linked2', GWF_HTML::display($onsitename), $site->displayName());
		}
		
		$options = 0;
		$options |= $site->isDefaultHidden() ? WC_RegAt::HIDE_SITENAME : 0;
		$regat = new WC_RegAt(array(
			'regat_uid' => $userid,
			'regat_sid' => $siteid,
			'regat_onsitename' => $onsitename,
			'regat_onsitescore' => 0,
			'regat_challcount' => $site->getVar('site_challcount'),
			'regat_options' => $options,
			'regat_langid' => $site->getLangID(),
			'regat_tagbits' => $site->getTagBits(),
			'regat_linkdate' => GWF_Time::getDate(GWF_Date::LEN_DAY),
		));
		if (false === ($regat->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === ($site->increase('site_linkcount', 1))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$error = $site->onUpdateUser($user, true, true);
		
		if (false === ($regat2 = WC_RegAt::getRegatRow($userid, $siteid))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		require_once 'module/WeChall/WC_FirstLink.php';
		if (false === WC_FirstLink::insertFirstLink($user, $site, $onsitename, $regat2->getOnsiteScore())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $error->display().$module->message('msg_site_linked', $site->displayName());
	}
	
	###################
	### Hide / Show ###
	###################
	private function onHide(Module_WeChall $module, $array, $status)
	{
		if (!is_array($array)) {
			return '';
		}
		
		foreach ($array as $siteid => $stub) { break; }
		
		if (false === ($site = WC_Site::getByID($siteid))) {
			return $module->error('err_site');
		}
		
		if (false === ($regat = WC_RegAt::getRegatRow(GWF_Session::getUserID(), $siteid))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $regat->saveOption(WC_RegAt::HIDE_SITENAME, $status > 0)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $module->message('msg_hide_sitename_'.$status, $site->displayName());
	}
	
	##############
	### Unlink ###
	##############
	private function onUnLinkSite(Module_WeChall $module, $array)
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS())) {
			return GWF_HTML::error('WeChall', $error);
		}
		if (!is_array($array)) { return ''; }
		foreach ($array as $siteid => $stub) { break; }
		
		if (false === ($site = WC_Site::getByID($siteid))) {
			return $module->error('err_site');
		}
		
		$user = GWF_Session::getUser();
		$userid = GWF_Session::getUserID();
		$old_totalscore = $user->getVar('user_level');
		
		if (WC_Freeze::isUserFrozen($userid)) {
			return $module->error('err_frozen');
		}
		
		if (false === ($regat = WC_RegAt::getRegatRow($userid, $site->getID()))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === WC_RegAt::unlink($userid, $site->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$site->increase('site_linkcount', -1);
		
		WC_RegAt::calcTotalscores();# (GWF_Session::getUser());
		
		$user = GWF_User::getByIDNoCache($userid);
		$new_totalscore = $user->getVar('user_level');
		
		require_once 'module/WeChall/WC_HistoryUser2.php';
		WC_HistoryUser2::insertEntry($user, $site, 'unlink', 0, $regat->getOnsiteScore(), $new_totalscore-$old_totalscore);
		
		return $module->message('msg_site_unlinked', $site->displayName());
	}
	
	##############
	### Update ###
	##############
	private function onQuickUpdate(Module_WeChall $module, $siteid)
	{
		if (false === ($site = WC_Site::getByID($siteid))) {
			return $module->error('err_site');
		}
		return $this->onUpdateB($module, $site, GWF_Session::getUser());
	}
	
	private function onUpdate(Module_WeChall $module, $array)
	{
		if (!is_array($array)) {
			return '';
		}
		foreach ($array as $siteid => $stub) { break; }
		if (false === ($site = WC_Site::getByID($siteid))) {
			return $module->error('err_site');
		}
				
		return $this->onUpdateB($module, $site, GWF_Session::getUser());
	}
	
	private function onUpdateB(Module_WeChall $module, WC_Site $site, GWF_User $user)
	{
		$back = $module->message('msg_updating', $site->displayName());
		
		$result = $site->onUpdateUser($user);
		
		return $back.$result->display('WeChall');
	}
	
	private function onUpdateAll(Module_WeChall $module)
	{
		$form = $this->getFormAll($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		set_time_limit(600);
		
		$user = GWF_Session::getUser();
		$regats = WC_RegAt::getRegats(GWF_Session::getUserID());
		
		$back = '';
		foreach ($regats as $regat)
		{
			$site = $regat->getSite();
			$back .= $this->onUpdateB($module, $site, $user);
		}
		
		return $back;
	}
}

?>