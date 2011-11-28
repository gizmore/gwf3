<?php

final class Module_PM extends GWF_Module
{
	# Unread PMCount buffered.
	private $unread = true;
	public function getUnreadPMCount() { if ($this->unread === true) { $this->unread = $this->countUnreadPM(GWF_Session::getUser()); } return $this->unread; }
	
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.04; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/pm'); }
	
	################
	### Includes ###
	################
	public function getClasses() { return array('GWF_PM', 'GWF_PMFolder', 'GWF_PMIgnore', 'GWF_PMOptions'); }
	
	###############
	### Install ###
	###############
	public function onInstall($dropTable)
	{
		require_once 'GWF_PMInstall.php';
		return GWF_PMInstall::install($this, $dropTable);
	}

	##############
	### Config ###
	##############
	public function cfgRE() { return $this->getModuleVar('pm_re', 'RE: '); }
	public function cfgIsPMLimited() { return $this->cfgPMLimit() >= 0; }
	public function cfgPMLimit() { return $this->getModuleVarInt('pm_limit', 6); }
	public function cfgLimitTimeout() { return $this->getModuleVarInt('pm_limit_timeout', 18*GWF_Time::ONE_HOUR); }
	public function cfgMaxFolders() { return $this->getModuleVarInt('pm_maxfolders', 50); }
	public function cfgAllowOwnFolders() { return $this->cfgMaxFolders() > 0; }
	public function cfgGuestPMs() { return $this->getModuleVarBool('pm_for_guests', '1'); }
	public function cfgGuestCaptcha() { return $this->getModuleVarBool('pm_captcha', '1'); }
	public function cfgEmailOnPM() { return $this->getModuleVarBool('pm_causes_mail', '1'); }
	public function cfgEmailSender() { return $this->getModuleVar('pm_mail_sender', GWF_BOT_EMAIL); }
	public function cfgBotUserID() { return $this->getModuleVar('pm_bot_uid', '0'); }
	public function cfgBotUser() { return GWF_User::getByID($this->cfgBotUserID()); }
	public function cfgOwnBot() { return $this->getModuleVarBool('pm_own_bot', '1'); }
	public function cfgPMPerPage() { return $this->getModuleVarInt('pm_per_page', 25); }
	public function cfgWelcomePM() { return $this->getModuleVarBool('pm_welcome', '1'); }
	public function cfgMaxSigLen() { return $this->getModuleVarInt('pm_sig_len', 255); }
	public function cfgMaxMsgLen() { return $this->getModuleVarInt('pm_msg_len', 2048); }
	public function cfgMaxTitleLen() { return $this->getModuleVarInt('pm_title_len', 64); }
	public function cfgMaxFolderNameLen() { return $this->getModuleVarInt('pm_fname_len', GWF_User::USERNAME_LENGTH+4); }
	public function cfgAllowDelete() { return $this->getModuleVarBool('pm_delete', '1'); }
	public function cfgLimitPerLevel() { return $this->getModuleVarInt('pm_limit_per_level', 1000000); }
	
	###############
	### Startup ###
	###############
	public function onAddHooks()
	{
		# Add Hooks
		GWF_Hook::add(GWF_Hook::ACTIVATE, array(__CLASS__, 'hookActivate'));
		GWF_Hook::add(GWF_Hook::DELETE_USER, array(__CLASS__, 'hookDeleteUser'));
	}
	
	public function onRequest()
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/PM/gwf_pm.js');
		$back = parent::onRequest();
		return $back;
	}
	
	private function countUnreadPM(GWF_User $user)
	{
		require_once 'GWF_PM.php';
		$pms = GDO::table('GWF_PM');
		$uid = $user->getVar('user_id');
		$read = GWF_PM::READ;
		return $pms->countRows("pm_to=$uid AND (pm_options&$read=0)");
	}
	
	#############
	### Hooks ###
	#############
	public function hookDeleteUser(GWF_User $user, array $args)
	{
		require_once 'GWF_PM.php';
		GWF_PM::hookDeleteUser($user);
	}
	
	public function hookActivate(GWF_User $user, array $args)
	{
		require_once 'GWF_PM.php';
		
		return $this->sendWelcomePM($user);
	}
	
	private function sendWelcomePM(GWF_User $user)
	{
		$this->onLoadLanguage();
		$title = $this->lang('wpm_title');
		$message = $this->lang('wpm_message', array($user->displayUsername()));
		if (0 > $this->deliver($this->cfgBotUserID(), $user->getID(), $title, $message)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return true;
	}
	
	public function deliver($from, $to, $title, $message, $parent1=0, $parent2=0)
	{
		require_once 'GWF_PM.php';
		
		$pm1 = GWF_PM::fakePM($from, $to, $title, $message, $from, GWF_PM::OUTBOX, $parent1);
		$pm1->setOption(GWF_PM::READ, true);
		if (false === ($pm1->insert())) {
			return -1;
		}
		$pm2 = GWF_PM::fakePM($from, $to, $title, $message, $to, GWF_PM::INBOX, $parent2, $pm1->getID());
		$pm2->setOption(GWF_PM::OTHER_READ, true);
		if (false === ($pm2->insert())) {
			return -2;
		}
		if (false === $pm1->saveVar('pm_otherid', $pm2->getID())) {
			return -3;
		}
		if (false === GWF_Counter::increaseCount('gwf3_pms_sent', 1)) {
			return -4;
		}
		if (!$this->cfgEmailOnPM()) {
			return 0;
		}
		require_once 'GWF_EMailOnPM.php';
		return GWF_EMailOnPM::deliver($this, $pm2);
	}
	
	############
	### HREF ###
	############
	public function getOptionsHREF()
	{
		return GWF_WEB_ROOT.'pm/options';
	}
	
	public function getSearchHREF()
	{
		return $this->getMethodURL('Search');
	}
	
	public function getOverviewHREF()
	{
		return GWF_WEB_ROOT.'pm';
	}
	
	##################
	### Validators ###
	##################
	public function validate_title($arg)
	{
		$_POST['title'] = $arg = trim($arg);
		$max = $this->cfgMaxTitleLen();
		if ($arg === '') {
			return $this->lang('err_no_title');
		} elseif (Common::strlen($arg) > $max) {
			return $this->lang('err_title_len', $max);
		} else {
			return false;
		}
	}

	public function validate_message($arg)
	{
		$_POST['message'] = $arg = trim($arg);
		$max = $this->cfgMaxMsgLen();
		if ($arg === '') {
			return $this->lang('err_no_msg');
		} elseif (Common::strlen($arg) > $max) {
			return $this->lang('err_msg_len', $max);
		} else {
			return false;
		}
	}
	
	public function validate_limits()
	{
		if (GWF_User::isAdminS() || GWF_User::isStaffS()) {
			return false;
		}
		if (!$this->cfgIsPMLimited()) {
			return false;
		}
		$user = GWF_Session::getUser();
		$uid = GWF_Session::getUserID();
		$within = $this->cfgLimitTimeout();
		$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$within);
		$count = GDO::table('GWF_PM')->countRows("pm_from=$uid AND pm_date>'$cut'");
		$max = $this->calcPMLimit($user);
		if ($count >= $max) {
			return $this->lang('err_limit', array($max, GWF_Time::humanDuration($within)));
		}
		return false;
	}
	
	private function calcPMLimit($user)
	{
		$limit = $this->cfgPMLimit();
		if ($user !== false)
		{
			$lpl = $this->cfgLimitPerLevel();
			if ($lpl > 0) {
				$limit += intval($user->getVar('user_level')/$lpl);
			}
		}
		return $limit;
	}

	public function validate_ignore(GWF_User $recipient)
	{
		if (false === ($user = GWF_Session::getUser())) {
			return false;
		}
		
		if (false !== ($message = GWF_PMIgnore::isIgnored($recipient->getID(), $user->getID()))) {
			return $this->lang('err_ignored', array($recipient->display('user_name'), htmlspecialchars($message)));
		}
		
		return false;
	}

	public function validate_pmo_auto_folder($arg)
	{
		$_POST['validate_pmo_auto_folder'] = $arg = (int) $arg;
		if ($arg < 0) {
			return $this->lang('err_pmoaf');
		}
		return false;
	}
	
	public function validate_pmo_signature($arg)
	{
		$_POST['pmo_signature'] = $arg = trim($arg);
		$max = $this->cfgMaxSigLen();
		if (Common::strlen($arg) > $max) {
			return $this->lang('err_sig_len', $max);
		} else {
			return false;
		}
	}
	
	public function validate_foldername($arg)
	{
		$_POST['foldername'] = $arg = trim($arg);
		if (false !== GWF_PMFolder::getByName($arg)) {
			return $this->lang('err_folder_exists');
		}
		$len = Common::strlen($arg);
		$max = $this->cfgMaxFolderNameLen();
		if ($len < 1 || $len > $max) {
			return $this->lang('err_folder_len', $max);
		}
		return false;
	}
}

?>