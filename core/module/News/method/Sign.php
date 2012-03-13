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
			return $this->onUnsign(Common::getGet('email', ''), $token);
		}
		
		if (!$this->module->isNewsletterForGuests() && !GWF_User::isLoggedIn()) {
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		if (false !== (Common::getPost('sign'))) {
			return $this->onSign();
		}
		
		return $this->templateSign(); 
	}
	
	private function getForm($row)
	{
		$user = GWF_User::getStaticOrGuest();
		if ($row === false)
		{
			$email = $user->getValidMail();
			$type = 0;
			$langid = GWF_Language::getCurrentID();
		}
		else
		{
			$email = $row->getEMail();
			$type = $row->getType();
			$langid = $row->getLangID();
		}
		
		$data = array(
			'email' => array(GWF_Form::STRING, $email, $this->module->lang('th_email')),
			'type' => array(GWF_Form::SELECT, GWF_Newsletter::getTypeSelectB($this->module, 'type', $type), $this->module->lang('th_type')),
			'langid' => array(GWF_Form::SELECT, GWF_LangSelect::single(GWF_Language::SUPPORTED, 'langid', $langid), $this->module->lang('th_langid')),
			'sign' => array(GWF_Form::SUBMIT, $this->module->lang('btn_sign'), ''),
		);
		
		return new GWF_Form(GDO::table('GWF_Newsletter'), $data);
	}
	
	private function templateSign()
	{
		$user = GWF_Session::getUser();
		$row = GWF_Newsletter::getRowForUser($user);
		$form = $this->getForm($row);
		$tVars = array(
			'info' => $this->getSignInfo(),
			'form' => $form->templateY($this->module->lang('ft_sign')),
			'subscribed' => $row !== false,
			'href_unsign' => $row !== false ? $row->getUnsignHREF() : false,
		);
		return $this->module->templatePHP('sign.php', $tVars);
	}
	
	private function getSignInfo()
	{
		if (false === ($user = GWF_Session::getUser())) {
			return $this->module->lang('sign_info_login');
		}
		$type = GWF_Newsletter::getEmailTypeForUser($user);
		switch ($type)
		{
			case 0: $key = 'sign_info_none'; break;
			case GWF_Newsletter::WANT_HTML: $key = 'sign_info_html'; break;
			case GWF_Newsletter::WANT_TEXT: $key = 'sign_info_text'; break;
			default: return GWF_HTML::lang('ERR_GENERAL', array( __FILE__, __LINE__)); 
		}
		return $this->module->lang($key);
	}
	
	private function onSign()
	{
		if (!$this->module->isNewsletterForGuests() && !GWF_Session::isLoggedIn())
		{
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		$user = GWF_Session::getUser();
		$row = GWF_Newsletter::getRowForUser($user);
		$form = $this->getForm($row);
		
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templateSign();
		}
		
		$email = $form->getVar('email');
		$type = (int) $form->getVar('type');
		$langid = $form->getVar('langid');
		
		$newsletter = new GWF_Newsletter(false);
		if (false === ($row = $newsletter->getRow($email)))
		{
			return $this->onNewSign($email, $type, $langid).$this->templateSign();
		}
		
		$back = '';
		if ($langid !== $row->getVar('nl_langid'))
		{
			$back .= $this->module->message('msg_changed_lang');
			$row->saveVar('nl_langid', $langid);
		}
		if ($row->getType() !== $type)
		{
			$back .= $this->module->message('msg_changed_type');
			$row->saveType($type);
		}
		return $back.$this->templateSign();
	}
	
	private function onNewSign($email, $type, $langid)
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
		return $this->module->message('msg_signed');
	}

	private function onUnsign($email, $token)
	{
		$nl = new GWF_Newsletter(false);
		if (false === ($nl = $nl->getRow($email))) {
			return $this->module->error('err_unsign');
		}
		
		if ($nl->getVar('nl_unsign') !== $token) {
			return $this->module->error('err_unsign');
		}
		
		$nl->delete();
		
		return $this->module->message('msg_unsigned');
	}
	
}

?>