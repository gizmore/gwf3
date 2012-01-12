<?php

final class News_Sign extends GWF_Method
{
	public function getHTAccess()
	{
		return 
			'RewriteRule ^newsletter/subscribe$ index.php?mo=News&me=Sign&sign=sign'.PHP_EOL.
//			'RewriteRule ^newsletter/unsubscribe_now$ index.php?mo=News&me=Sign&_unsign=now'.PHP_EOL.
			'RewriteRule ^newsletter/unsubscribe/([a-zA-Z0-9\._@\+\-]+)/([a-zA-Z0-9]+)$ index.php?mo=News&me=Sign&unsign=$2&email=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== ($token = Common::getGet('unsign'))) {
			return $this->onUnsign($this->_module, Common::getGet('email', ''), $token);
		}
		
		if (!$this->_module->isNewsletterForGuests() && !GWF_User::isLoggedIn()) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		if (false !== (Common::getPost('sign'))) {
			return $this->onSign($this->_module);
		}
		
		return $this->templateSign($this->_module); 
	}
	
	private function getForm()
	{
		if (false === ($user = GWF_Session::getUser())) {
			$email = Common::getPost('email', '');
		} else {
			$email = $user->getValidMail();
		}
		
		$data = array(
			'email' => array(GWF_Form::STRING, $email, $this->_module->lang('th_email')),
			'type' => array(GWF_Form::SELECT, GWF_Newsletter::getTypeSelect($this->_module, 'type'), $this->_module->lang('th_type')),
		);
		
//		if (!GWF_User::isLoggedIn()) {
//			GWF_Language::setShowSupported(true);
			$data['langid'] = array(GWF_Form::SELECT, GWF_LangSelect::single(GWF_Language::SUPPORTED, 'langid'), $this->_module->lang('th_langid'));
//		}

		$data['sign'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_sign'), '');
		return new GWF_Form(GDO::table('GWF_Newsletter'), $data);
	}
	
	private function templateSign()
	{
		$form = $this->getForm($this->_module);
		$user = GWF_Session::getUser();
		$row = GWF_Newsletter::getRowForUser($user);
		$tVars = array(
			'info' => $this->getSignInfo($this->_module),
			'form' => $form->templateY($this->_module->lang('ft_sign')),
			'subscribed' => $row !== false,
			'href_unsign' => $row !== false ? $row->getUnsignHREF() : false,
		);
		return $this->_module->templatePHP('sign.php', $tVars);
	}
	
	private function getSignInfo()
	{
		if (false === ($user = GWF_Session::getUser())) {
			return $this->_module->lang('sign_info_login');
		}
		$type = GWF_Newsletter::getEmailTypeForUser($user);
		switch ($type)
		{
			case 0: $key = 'sign_info_none'; break;
			case GWF_Newsletter::WANT_HTML: $key = 'sign_info_html'; break;
			case GWF_Newsletter::WANT_TEXT: $key = 'sign_info_text'; break;
			default: return GWF_HTML::lang('ERR_GENERAL', array( __FILE__, __LINE__)); 
		}
		return $this->_module->lang($key);
	}
	
	private function onSign()
	{
		if (!$this->_module->isNewsletterForGuests() && !GWF_Session::isLoggedIn()) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		$form = $this->getForm($this->_module);
		
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateSign($this->_module);
		}
		
		$email = $form->getVar('email');
		$type = (int) $form->getVar('type');
		$langid = (int) $form->getVar('langid');
		
		$newsletter = new GWF_Newsletter(false);
		if (false === ($row = $newsletter->getRow($email))) {
			return $this->onNewSign($this->_module, $email, $type, $langid).$this->templateSign($this->_module);
		}
		
		$back = '';
		if ($langid !== $row->getVar('nl_langid')) {
			$back .= $this->_module->message('msg_changed_lang');
			$row->saveVar('nl_langid', $langid);
		}
		if ($row->getType() !== $type) {
			$back .= $this->_module->message('msg_changed_type');
			$row->saveType($type);
		}
		return $back.$this->templateSign($this->_module);
	}
	
	private function onNewSign(Module_News $module, $email, $type, $langid)
	{
		$subscribe = new GWF_Newsletter(array(
			'nl_email' => $email,
			'nl_userid' => GWF_Session::getUserID(),
			'nl_options' => $type,
			'nl_unsign' => GWF_Random::randomKey(16),
			'nl_langid' => $langid,
			'nl_mailed_ids' => ':',
		));
		if (false === $subscribe->replace()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return $this->_module->message('msg_signed');
	}

	private function onUnsign(Module_News $module, $email, $token)
	{
		$nl = new GWF_Newsletter(false);
		if (false === ($nl = $nl->getRow($email))) {
			return $this->_module->error('err_unsign');
		}
		
		if ($nl->getVar('nl_unsign') !== $token) {
			return $this->_module->error('err_unsign');
		}
		
		$nl->delete();
		
		return $this->_module->message('msg_unsigned');
	}
	
}

?>