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
	
	public function getHTAccess()
	{
		return 
			'RewriteRule ^linked_sites$ index.php?mo=WeChall&me=LinkedSites'.PHP_EOL.
			'RewriteRule ^link_site/(\d+)/[^/]+/to/(\d+)/as/([^/]+)/([^/]+)$ index.php?mo=WeChall&me=LinkedSites&site=$1&userid=$2&onsitename=$3&link=$4'.PHP_EOL;
	}
	
	public function execute()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_Freeze.php';
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		
		if (false !== ($token = Common::getGet('link')))
		{
			return $this->onLinkSiteAfterMailPre($token, (int)Common::getGet('site', 0));
		}
		
		if (!(GWF_User::isLoggedIn()))
		{
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}

		# Hide and Show
		if (false !== ($array = Common::getPost('showname')))
		{
			return $this->onHide($array, 0).$this->templateSites();
		}
		if (false !== ($array = Common::getPost('hidename')))
		{
			return $this->onHide($array, 1).$this->templateSites();
		}

		# Link and UnLink
		if (false !== (Common::getPost('link')))
		{
			return $this->onLinkSite().$this->templateSites();
		}
		if (false !== ($array = Common::getPost('unlink')))
		{
			return $this->onUnLinkSite($array).$this->templateSites();
		}
		
		# Update
		if (false !== ($array = Common::getPost('update')))
		{
			return $this->onUpdate($array).$this->templateSites();
		}
		if (false !== (Common::getPost('update_all')))
		{
			return $this->onUpdateAll().$this->templateSites();
		}
		if (false !== ($siteid = Common::getGet('quick_update')))
		{
			return $this->onQuickUpdate($siteid);
		}
		
		return $this->templateSites();
	}

	################
	### Template ###
	################
	public function templateSites()
	{
		$whitelist = array('site_name', 'site_challcount', 'regat_score', 'site_score', 'regat_solved', 'regat_lastdate', 'regat_onsitename', 'regat_challsolved');
		
		$form_link = $this->getFormLink();
		$form_all = $this->getFormAll();
		
		$by = Common::getGet('by', 'site_name');
		$dir = Common::getGet('dir', 'ASC');
		$by = GDO::getWhitelistedByS($by, $whitelist, 'site_name');
		$dir = GDO::getWhitelistedDirS($dir, 'ASC');
		$orderby = "$by $dir";
		
		$tVars = array(
			'form_link' => $form_link === false ? '' : $form_link->templateX($this->module->lang('ft_link_site')),
			'action' => GWF_WEB_ROOT.'linked_sites',
			'linked' => $this->getLinkedSites(GWF_Session::getUserID(), $orderby),
			'form_update_all' => $form_all->templateX(),
			'can_link' => count($this->not_linked) > 0,
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=WeChall&me=LinkedSites&by=%BY%&dir=%DIR%',
		);
		return $this->module->templatePHP('linked_sites.php', $tVars);
	}
	
	private function getLinkedSites($userid, $orderby)
	{
		return GDO::table('WC_RegAt')->selectAll('*', 'regat_uid='.$userid, $orderby, array('site'));
	}

	public function getFormLink()
	{
		if (false === ($this->not_linked = WC_Site::getUnlinkedSites(GWF_Session::getUserID())))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		$user = GWF_Session::getUser();
		$data = array(
			'siteid' => array(GWF_Form::SELECT, $this->getSelectNotLinked($this->not_linked), $this->module->lang('th_site_name')),
			'onsitename' => array(GWF_Form::STRING, $user->getVar('user_name'), $this->module->lang('th_onsite_name')),
			'password_email' => array(GWF_Form::STRING, $user->getValidMail(), $this->module->lang('th_email')),
			'link' => array(GWF_Form::SUBMIT, $this->module->lang('btn_link')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getSelectNotLinked(array $sites, $name='siteid')
	{
		$data = array(array('0', WC_HTML::lang('th_sel_favsite')));
		foreach ($sites as $site)
		{
			$data[] = array($site->getID(), $site->getVar('site_name'));
		}
		return GWF_Select::display($name, $data, Common::getPostString($name, '0'));
	}

	public function getFormAll()
	{
		$data = array(
			'update_all' => array(GWF_Form::SUBMIT, $this->module->lang('btn_update_all_sites')),
		);
		return new GWF_Form($this, $data);
	}
	
	#################
	### Link Site ###
	#################
	public function validate_siteid(Module_WeChall $m, $arg) { return WC_Site::validateSiteID($arg); }
	public function validate_onsitename(Module_WeChall $m, $arg) { return false; }
	public function validate_password_email(Module_WeChall $m, $arg) { return GWF_Validator::validateEMail($m, 'password_email', $arg); }
	
	/**
	 * Link a site.
	 * First we check if username/email exists on that site.
	 * If so, we check if emails are the same.
	 * If not, we send some email, else we just link.
	 * @return unknown_type
	 */
	private function onLinkSite()
	{
		$form = $this->getFormLink();
		if (false !== ($errors = $form->validate($this->module)))
		{
			return $errors;
		}
		
		$user = GWF_Session::getUser();
		$onsitename = Common::getPostString('onsitename', '');
		$onsitemail = Common::getPostString('password_email', '');
		
		if (false === ($site = WC_Site::getByID_Class(Common::getPost('siteid'))))
		{
			return $this->module->error('err_site');
		}
		
		if (false !== WC_RegAt::getRegatRow(GWF_Session::getUserID(), $site->getID()))
		{
			return $this->module->error('err_already_linked', array($site->displayName()));
		}
		
		if ( (!$site->isUp()) )
		{
			return $this->module->error('err_site_down', array($site->displayName()));
		}
		
		if (WC_Freeze::isUserFrozenOnSite(GWF_Session::getUserID(), $site->getID()))
		{
			return $this->module->error('err_site_ban', array($site->displayName()));
		}
		
		if ($site->isNoV1())
		{
			if (!$site->isValidWarboxLink($user, $onsitename))
			{
				return $this->module->error('err_warbox_nick');
			}
		}
		
		
		if (false === ($site->isAccountValid($onsitename, $onsitemail)))
		{
			$key = $site->getVar('site_classname') === 'HTS' ? 'err_link_account_hts' : 'err_link_account';
			return $this->module->error($key, array($site->displayName()));
		}

		if (false !== ($regat = WC_RegAt::getByOnsitename($site->getID(), $onsitename))) {
			if (false === ($user = $regat->getUser()))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			else
			{
				return $this->module->error('err_onsitename_taken', array(htmlspecialchars($onsitename), $site->displayName(), $user->displayUsername()));
			}
		}
		
		if ($onsitemail !== $user->getValidMail() && (!$site->hasNoEmail()))
		{
			return $this->onLinkSiteMail($site, $user, $onsitename, $onsitemail);
		}
		else
		{
			return $this->onLinkSiteAfterMail($site, $user, $onsitename);
		}
	}
	
	private function onLinkSiteMail(WC_Site $site, GWF_User $user, $onsitename, $onsitemail)
	{
		$userid = $user->getID();
		$link = Common::getAbsoluteURL(sprintf('link_site/%d/%s/to/%d/as/%s/%s', $site->getID(), $site->urlencode('site_name'), $userid, urlencode($onsitename), $site->getLinkToken($userid, $onsitename)));
		$link = GWF_HTML::anchor($link, $link);
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($onsitemail);
		$mail->setSubject($this->module->lang('mail_link_subj', array($site->display('site_name'))));
		$mail->setBody($this->module->lang('mail_link_body', array($user->displayUsername(), $site->displayName(), $link)));
		$mail->setAllowGPG(false);
		return $mail->sendToUser($user) ? $this->module->message('msg_linkmail_sent') : GWF_HTML::err('ERR_MAIL_SENT');
	}

	private function onLinkSiteAfterMailPre($token, $siteid)
	{
		if (false === ($site = WC_Site::getByID($siteid)))
		{
			return $this->module->error('err_site');
		}
		
		if (false === ($user = GWF_User::getByID(Common::getGet('userid'))))
		{
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false !== WC_RegAt::getRegatRow($user->getID(), $site->getID()))
		{
			return $this->module->error('err_already_linked', array($site->displayName()));
		}
		
		if (false === ($onsitename = Common::getGet('onsitename')))
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if ($token !== $site->getLinkToken($user->getID(), $onsitename))
		{
			return $this->module->error('err_link_token');
		}
		
		return $this->onLinkSiteAfterMail($site, $user, $onsitename);
	}

	public function onLinkSiteAfterMail(WC_Site $site, GWF_User $user, $onsitename)
	{
		if (WC_Freeze::isUserFrozenOnSite($user->getID(), $site->getID()))
		{
			return $this->module->error('err_site_ban', array($site->displayName()));
		}
		
		if ($site->isUserLinked($user))
		{
			return $this->module->error('err_already_linked', array($site->displayName()));
		}
		
		$siteid = $site->getVar('site_id');
		$userid = $user->getVar('user_id');
		
		if (false !== WC_RegAt::getUserByOnsiteName($onsitename, $siteid)) {
			return $this->module->error('err_already_linked2', array(GWF_HTML::display($onsitename), $site->displayName()));
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
			'regat_lastdate' => GWF_Time::getDate(GWF_Date::LEN_DAY),
		));
		if (false === ($regat->insert()))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === ($site->increase('site_linkcount', 1)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$error = $site->onUpdateUser($user, true, true);
		
		if (false === ($regat2 = WC_RegAt::getRegatRow($userid, $siteid)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_FirstLink.php';
		if (false === WC_FirstLink::insertFirstLink($user, $site, $onsitename, $regat2->getOnsiteScore()))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $error->display($this->module->lang('btn_linked_sites')).$this->module->message('msg_site_linked', array($site->displayName()));
	}
	
	###################
	### Hide / Show ###
	###################
	private function onHide($array, $status)
	{
		if (!is_array($array))
		{
			return '';
		}
		
		foreach ($array as $siteid => $stub) { break; }
		
		if (false === ($site = WC_Site::getByID($siteid)))
		{
			return $this->module->error('err_site');
		}
		
		if (false === ($regat = WC_RegAt::getRegatRow(GWF_Session::getUserID(), $siteid)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $regat->saveOption(WC_RegAt::HIDE_SITENAME, $status > 0))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_hide_sitename_'.$status, array($site->displayName()));
	}
	
	##############
	### Unlink ###
	##############
	private function onUnLinkSite($array)
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS()))
		{
			return GWF_HTML::error('WeChall', $error);
		}
		if (!is_array($array))
		{
			return '';
		}
		
		// TODO: Replace with appropriate PHP function
		foreach ($array as $siteid => $stub)
		{
			break;
		}
		
		if (false === ($site = WC_Site::getByID($siteid)))
		{
			return $this->module->error('err_site');
		}
		
		$user = GWF_Session::getUser();
		$userid = GWF_Session::getUserID();
		$old_totalscore = $user->getVar('user_level');
		
		if (WC_Freeze::isUserFrozen($userid))
		{
			return $this->module->error('err_frozen');
		}
		
		if (false === ($regat = WC_RegAt::getRegatRow($userid, $site->getID())))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === WC_RegAt::unlink($userid, $site->getID()))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$site->increase('site_linkcount', -1);
		
		WC_RegAt::calcTotalscores();# (GWF_Session::getUser());
		
		$user = GWF_User::getByID($userid);
		$new_totalscore = $user->getVar('user_level');
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_HistoryUser2.php';
		WC_HistoryUser2::insertEntry($user, $site, 'unlink', 0, $regat->getOnsiteScore(), $new_totalscore-$old_totalscore);
		
		return $this->module->message('msg_site_unlinked', array($site->displayName()));
	}
	
	##############
	### Update ###
	##############
	private function onQuickUpdate($siteid)
	{
		if (false === ($site = WC_Site::getByID($siteid)))
		{
			return $this->module->error('err_site');
		}
		return $this->onUpdateB($site, GWF_Session::getUser());
	}
	
	private function onUpdate($array)
	{
		if (!is_array($array))
		{
			return '';
		}
		foreach ($array as $siteid => $stub) { break; }
		if (false === ($site = WC_Site::getByID($siteid)))
		{
			return $this->module->error('err_site');
		}
				
		return $this->onUpdateB($site, GWF_Session::getUser());
	}
	
	private function onUpdateB(WC_Site $site, GWF_User $user)
	{
		$back = $this->module->message('msg_updating', array($site->displayName()));
		
		$result = $site->onUpdateUser($user);
		
		return $back.$result->display('WeChall');
	}
	
	private function onUpdateAll()
	{
		$form = $this->getFormAll();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		set_time_limit(600);
		
		$user = GWF_Session::getUser();
		$regats = WC_RegAt::getRegats(GWF_Session::getUserID());
		
		$back = '';
		foreach ($regats as $regat)
		{
			$site = $regat->getSite();
			$back .= $this->onUpdateB($site, $user);
		}
		
		return $back;
	}
}
