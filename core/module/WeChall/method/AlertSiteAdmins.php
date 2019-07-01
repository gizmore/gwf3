<?php
/**
 * Send an email to all site admins.
 * @author gizmore
 */
final class WeChall_AlertSiteAdmins extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^alert_site_admins/? index.php?mo=WeChall&me=AlertSiteAdmins'.PHP_EOL;
	}
	
	public function getForm()
	{
		$data = array();
		$siteData = array(array('all', $this->module->lang('all')));
		foreach (WC_Site::getSites() as $site)
		{
			$siteData[] = array($site->getID(), $site->getSiteName());
		}
			
		$select = GWF_Select::multi('sites', $siteData, Common::getRequestArray('sites', array()));
		$data['sites'] = array(GWF_Form::SELECT_A, $select, $this->module->lang('th_site'));
		$data['title'] = array(GWF_Form::STRING, Common::getRequestString('title'), $this->module->lang('th_title'));
		$data['message'] = array(GWF_Form::MESSAGE_NOBB, Common::getRequestString('message'), $this->module->lang('th_message'));
		$data['alert'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_alert_site_admins'));
		return new GWF_Form($this, $data);
	}
	
	public function validate_sites(Module_WeChall $m, $arg) { if (!$arg) return $m->lang('err_site'); return false; }
	public function validate_title(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, 3, 32); }
	public function validate_message(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'message', $arg, 3, 32768); }
	
	public function templateAlert()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_alert_site_admins', array())),
		);
		return $this->module->templatePHP('alert_site_admins.php', $tVars);
	}
	
	public function execute()
	{
		$this->module->includeClass('WC_SiteAdmin');
		if (!WC_SiteAdmin::isSiteAdmin(GWF_User::getStaticOrGuest()->getID()))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== (Common::getPost('alert')))
		{
			return $this->onAlert().$this->templateAlert();
		}
		return $this->templateAlert();
	}
	
	public function onAlert()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->module)))
		{
			return $errors;
		}
		
		$this->module->includeClass('WC_SiteAdmin');
		
		$sites = array_keys(Common::getRequestArray('sites'));
		$all = in_array("all", $sites);
		$title = Common::getRequestString('title');
		$message = Common::getRequestString('message');
		
		$users = array();
		
		foreach (WC_Site::getSites() as $site)
		{
			if ($all || in_array($site->getID(), $sites))
			{
				foreach (WC_SiteAdmin::getSiteAdmins($site->getID()) as $siteAdmin)
				{
					$user = new GWF_User($siteAdmin->getGDOData());
					$users[$user->getID()] = $user;
				}
			}
		}
		foreach (GWF_User::getAllInGroup('admin') as $user)
		{
			$user = new GWF_User($user);
			$users[$user->getID()] = $user;
		}
		foreach (GWF_User::getAllInGroup('staff') as $user)
		{
			$user = new GWF_User($user);
			$users[$user->getID()] = $user;
		}
		
		$count = 0;
		foreach ($users as $user)
		{
			if ($user->hasValidMail())
			{
				$count++;
				$this->onAlertMail($user, $title, $message);
			}
		}
		
		return $this->module->message('msg_alert_mails_sent', array($count));
	}
	
	public function onAlertMail(GWF_User $user, $title, $message)
	{
		$sender = GWF_User::getStaticOrGuest();
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setSubject($this->module->langUser($user, 'mail_subj_alert_sitemins'));
		$args = array(
			$user->displayUsername(),
			$sender->displayUsername(),
			$title,
			$message,
		);
		$mail->setBody($this->module->langUser($user, 'mail_body_alert_sitemins', $args));
		$mail->sendToUser($user);
	}
	
}
