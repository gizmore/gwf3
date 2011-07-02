<?php
/**
 * Send PM?
 * @author gizmore
 * @version 1.0
 */
final class PM_Send extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^pm/create$ index.php?mo=PM&me=Send'.PHP_EOL.
			'RewriteRule ^pm/reply/to/(\d+)/ index.php?mo=PM&me=Send&reply=$1'.PHP_EOL.
			'RewriteRule ^pm/quote/reply/to/(\d+)/ index.php?mo=PM&me=Send&quote=$1'.PHP_EOL.
			'RewriteRule ^pm/send/to/([^/]+)$ index.php?mo=PM&me=Send&to=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== (Common::getPost('create'))) {
			return $this->create($module);
		}
		
		# IE Oo
		if (false !== (Common::getPost('username'))) {
			return $this->create($module);
		}
		
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		

		if (false !== (Common::getPost('preview'))) {
			return $this->preview($module);
		}
		if (false !== (Common::getPost('send'))) {
			return $this->send($module);
		}
		
		if (false !== ($pmid = Common::getGet('reply'))) {
			return $this->reply($module, $pmid, false);
		}
		if (false !== ($pmid = Common::getGet('quote'))) {
			return $this->reply($module, $pmid, true);
		}
		
		if (false !== ($username = Common::getGet('to'))) {
			return $this->create2($module, $username);
		}
		
		return GWF_HTML::err('ERR_PARAMETER', array( __FILE__, __LINE__, 'me'));
	}
	
	/**
	 * @var GWF_User
	 */
	private $user;
	private function sanitize(Module_PM $module)
	{
		if (!GWF_User::isLoggedIn() && !$module->cfgGuestPMs()) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		$this->user = GWF_User::getStaticOrGuest();
		
		if (false !== ($error = $module->validate_limits())) {
			return GWF_HTML::error('PM', $error);
		}
		
		
		if ($this->user->isBot()) {
			return $module->error('err_bot');
		}
		
		if (false !== ($uname = Common::getGet('to'))) {
			if ( (false === ($this->rec = GWF_User::getByName($uname))) || ($this->rec->isDeleted())) {
				return GWF_HTML::err('ERR_UNKNOWN_USER');
			}
			else if ( 
				(!GWF_PMOptions::getPMOptions($this->rec)->isOptionEnabled(GWF_PMOptions::ALLOW_GUEST_PM)) 
				&& (!GWF_User::isLoggedIn())
				) {
				return $module->error('err_user_no_ppm');
			}
		}
		
		if ($this->rec === false)
		{
			$pmid = max(Common::getGetInt('reply'), Common::getGetInt('quote'));
			if (false !== ($error = $this->sanitizePM($module, $pmid))) {
				return $error;
			}
		}
		
		return false;
	}

	/**
	 * @var GWF_PM
	 */
	private $pm = false;
	private function sanitizePM(Module_PM $module, $pmid)
	{
		if (false === ($this->pm = GWF_PM::getByID($pmid))) {
			return $module->error('err_pm');
		}
		if (!$this->pm->canRead($this->user)) {
			return $module->error('err_perm_read');
		}
		
		$this->rec = $this->pm->getSender();
		if ($this->rec->getID() === GWF_Session::getUserID()) {
			$this->rec = $this->pm->getReceiver();
		}
		
		return false;
	}
	
	/**
	 * @var GWF_User
	 */
	private $rec = false;
	private function create(Module_PM $module)
	{
		if ( (false === ($this->rec = GWF_User::getByName(Common::getPost('username')))) && (false === ($this->rec = GWF_User::getByName(Common::getPost('username_sel')))) ) {
			return GWF_HTML::err('ERR_UNKNOWN_USER').$module->requestMethodB('Overview');
		}
		GWF_Website::redirect(GWF_WEB_ROOT.'pm/send/to/'.$this->rec->urlencode('user_name'));
		die();
	}
	private function create2(Module_PM $module)
	{
		if (false === ($this->rec = GWF_User::getByName(Common::getGet('to')))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER').$module->requestMethodB('Overview');
		}
		return $this->templateSend($module);
	}

	
	private function reply(Module_PM $module, $pmid)
	{
		if (false !== ($error = $this->sanitizePM($module, $pmid))) {
			return $error;
		}
		return $this->templateSend($module);
	}
	
	private function getForm(Module_PM $module)
	{
		$data = array(
			'title' => array(GWF_Form::STRING, $this->getFormTitle($module), $module->lang('th_pm_title')),
			'message' => array(GWF_Form::MESSAGE, $this->getFormMessage($module), $module->lang('th_pm_message')),
			'ignore' => array(GWF_Form::VALIDATOR),
			'limits' => array(GWF_Form::VALIDATOR)
		);
		if (!GWF_User::isLoggedIn() && $module->cfgGuestCaptcha()) {
			$data['captcha'] = array(GWF_Form::CAPTCHA);
		}
		$data['cmds'] = array(GWF_Form::SUBMITS, array('preview'=>$module->lang('btn_preview'),'send'=>$module->lang('btn_send')));
		return new GWF_Form($this, $data);
	}
	
	private function getFormTitle(Module_PM $module)
	{
		if ($this->pm === false)
		{
			return '';
		}
		else
		{
			$re = $module->cfgRE();
			$old = $this->pm->getVar('pm_title');
			return (Common::startsWith($old, $re)) ? $old : $re.$old;
		}
	}
	
	private function getFormMessage(Module_PM $module)
	{
		if ($this->pm === false)
		{
			return '';
		}
		elseif (Common::getGet('quote') !== false)
		{
			return sprintf("[quote from=%s date=%s]\n%s\n[/quote]",
				$this->pm->getSender()->display('user_name'),
				$this->pm->getVar('pm_date'),
				$this->pm->getVar('pm_message'));
		}
		else
		{
			return '';
//			return $this->pm->display('pm_message');
		}
	}
	
	private function getSEOTitle(Module_PM $module)
	{ 
		if ($this->pm === false)
		{
			return $module->lang('ft_create', array( $this->rec->display('user_name')));
		}
		else
		{
			return $module->lang('ft_reply', array( $this->rec->display('user_name')));
			
		}
	}
	
	private function templateSend(Module_PM $module, $preview='')
	{
		$form = $this->getForm($module);
		if ($this->pm !== false) {
			$this->pm->markRead(GWF_Session::getUser());
		}
		
		if ($this->pm === false) {
			GWF_Javascript::focusElementByName('title');
		}
		else {
			GWF_Javascript::focusElementByName('message');
		}
		
		$tVars = array(
			'reply_to' => $this->pm === false ? '' : $this->templatePM($module, $this->pm),
			'form' => $form->templateY($this->getSEOTitle($module)),
			'preview' => $preview,
		);
		return $module->templatePHP('send.php', $tVars);
	}
	
	private function templatePM(Module_PM $module, GWF_PM $pm)
	{
		$tVars = array(
			'pm' => $pm,
			'actions' => false,
			'title' => $pm->display('pm_title'),
			'unread' => array(),
			'translated' => '',
		);
		return $module->templatePHP('show.php', $tVars);
	}
	
	private function preview(Module_PM $module)
	{
		$form = $this->getForm($module);
		$errors = $form->validate($module);
		
		$preview = $this->createNewPM($form);
		$tVars = array(
			'pm' => $preview,
			'actions' => false,
			'title' => $preview->display('pm_title').' ('.$module->lang('ft_preview').')',
			'unread' => array(),#GWF_PM::getUnreadPMs($module, GWF_Session::getUserID()),
			'translated' => '',
		);
		$preview_t = $module->templatePHP('show.php', $tVars);
		return $errors.$this->templateSend($module, $preview_t);
	}
	
	public function getReceiver()
	{
		return $this->rec;# === false ? $this->pm->getSender() : $this->rec->getID();
	}

	private function createNewPM(GWF_Form $form)
	{
		return GWF_PM::fakePM($this->user->getID(), $this->getReceiver()->getID(), $form->getVar('title'), $form->getVar('message'));
	}
	
	private function send(Module_PM $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateSend($module);
		}
		
		# Get reply to field
		if (false !== ($otherid = Common::getGetInt('reply', false))) {
		}
		elseif (false !== ($otherid = Common::getGetInt('quote', false))) {
		}
		$parent1 = $parent2 = 0;
		if ($otherid !== false) {
			if (false !== ($otherpm = GWF_PM::getByID($otherid))) {
				$parent1 = $otherpm->getID();
				if (false !== ($p2 = $otherpm->getOtherPM())) {
					$parent2 = $p2;
				}
			}
		}
		$result = $module->deliver($this->user->getID(), $this->getReceiver()->getID(), $form->getVar('title'), $form->getVar('message'), $parent1, $parent2);
		
		$mail = '';
		switch ($result)
		{
			case '1':
				return $module->message('msg_mail_sent', array($this->getReceiver()->display('user_name')));
			case '0':
				break;
			case '-4':
				return GWF_HTML::err('ERR_MAIL_SENT');
			default:
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__.' - Code: '.$result));
		}
		
		return $mail.$module->message('msg_sent');
	}
	
	##################
	### Validators ###
	##################
	public function validate_limits(Module_PM $module, $arg) { return $module->validate_limits($arg); }
	public function validate_ignore(Module_PM $module, $arg) { return $module->validate_ignore($this->rec); }
	public function validate_title(Module_PM $module, $arg) { return $module->validate_title($arg); }
	public function validate_message(Module_PM $module, $arg) { return $module->validate_message($arg); }
}

?>