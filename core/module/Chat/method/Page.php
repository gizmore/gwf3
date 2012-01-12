<?php
/**
 * GWF Chat Page
 * @author gizmore
 */
final class Chat_Page extends GWF_Method
{
	public function getHTAccess()
	{
		return $this->getHTAccessMethod();
	}
	
	public function execute()
	{
		GWF_ChatOnline::onRequest($this->_module);
		
		GWF_Website::setPageTitle($this->_module->lang('pt_chat'));
		GWF_Website::setMetaTags($this->_module->lang('mt_chat'));
				
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Chat/gwf_chat.js?v=4');
		
		if (false !== (Common::getPost('post')))
		{
			return $this->onPost().$this->templatePage($this->_module);
		}
		
		return $this->templatePage();
	}
	
	private function getForm()
	{
		$data = array();
		if (false === ($nick = $this->_module->getNickname())) {
			$data['yournick'] = array(GWF_Form::STRING, '', $this->_module->lang('th_yournick'));
		} else {
			$data['yournick'] = array(GWF_Form::SSTRING, $nick, $this->_module->lang('th_yournick'));
		}
		$data['target'] = array(GWF_Form::STRING, '', $this->_module->lang('th_target'));
		$data['message'] = array(GWF_Form::STRING, '', $this->_module->lang('th_message'));
		$data['post'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_post'), '');
		return new GWF_Form($this, $data);
	}
	
	private function templatePage()
	{
		$form = $this->getForm();
		
		if (false === ($nick = $this->_module->getNickname())) {
			$nick = '';
		}
		
		// Focus input by js
		$focus = GWF_Session::isLoggedIn() ? 'message' : 'yournick';
		GWF_Javascript::focusElementByName($focus);
		
		
		$tVars = array(
			'form' => $form->templateX(),
			'msgs' => $this->_module->getChannelMessages(),
			'privmsgs' => $this->_module->getPrivateMessages(),
			'online' => $this->_module->getOnlineUsers(),
			'maxmsg_pub' => $this->_module->getChanmsgPerPage(),
			'maxmsg_priv' => $this->_module->getPrivmsgPerPage(),
			'nickname' => $nick,
			'onlinetime' => $this->_module->getOnlineTime(),
			'peaktime' => $this->_module->getMessagePeak(),
			'lagtime' => $this->_module->cfgLagPing(),
			'href_history' => GWF_WEB_ROOT.'chat/history',
			'href_webchat' => GWF_WEB_ROOT.'chat',
			'href_ircchat' => GWF_WEB_ROOT.'irc_chat',
			'mibbit_url' => $this->_module->cfgMibbitURL(),
			'mibbit' => $this->_module->cfgMibbit(),
			'gwf_chat' => $this->_module->cfgGWFChat(),
		);
		return $this->_module->templatePHP('page.php', $tVars);
	}
	
	public function validate_yournick(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_yournick($this->_module, $arg); }
	public function validate_target(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_target($this->_module, $arg); }
	public function validate_message(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_message($this->_module, $arg); }
	
	private function onPost()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}
		
		$oldnick = $this->_module->getNickname();
		$sender = $form->getVar('yournick', $oldnick);
		$target = $form->getVar('target');
		$message = $form->getVar('message');
		
		if ($oldnick === false) {
			$sender = $this->_module->getGuestPrefixed($sender);
			$this->_module->setGuestNick($sender);
		} else {
			$sender = $oldnick;
		}
		
		if (false === GWF_ChatMsg::newMessage($sender, $target, $message)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$_POST['message'] = '';
		
		return $this->_module->message('msg_posted');
	}
}
?>