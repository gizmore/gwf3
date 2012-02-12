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
		GWF_ChatOnline::onRequest($this->module);
		
		GWF_Website::setPageTitle($this->module->lang('pt_chat'));
		GWF_Website::setMetaTags($this->module->lang('mt_chat'));
				
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Chat/gwf_chat.js?v=4');
		
		if (false !== (Common::getPost('post')))
		{
			return $this->onPost().$this->templatePage();
		}
		
		return $this->templatePage();
	}
	
	private function getForm()
	{
		$data = array();
		if (false === ($nick = $this->module->getNickname())) {
			$data['yournick'] = array(GWF_Form::STRING, '', $this->module->lang('th_yournick'));
		} else {
			$data['yournick'] = array(GWF_Form::SSTRING, $nick, $this->module->lang('th_yournick'));
		}
		$data['target'] = array(GWF_Form::STRING, '', $this->module->lang('th_target'));
		$data['message'] = array(GWF_Form::STRING, '', $this->module->lang('th_message'));
		$data['post'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_post'), '');
		return new GWF_Form($this, $data);
	}
	
	private function templatePage()
	{
		$form = $this->getForm();
		
		if (false === ($nick = $this->module->getNickname())) {
			$nick = '';
		}
		
		// Focus input by js
		$focus = GWF_Session::isLoggedIn() ? 'message' : 'yournick';
		GWF_Javascript::focusElementByName($focus);
		
		
		$tVars = array(
			'form' => $form->templateX(),
			'msgs' => $this->module->getChannelMessages(),
			'privmsgs' => $this->module->getPrivateMessages(),
			'online' => $this->module->getOnlineUsers(),
			'maxmsg_pub' => $this->module->getChanmsgPerPage(),
			'maxmsg_priv' => $this->module->getPrivmsgPerPage(),
			'nickname' => $nick,
			'onlinetime' => $this->module->getOnlineTime(),
			'peaktime' => $this->module->getMessagePeak(),
			'lagtime' => $this->module->cfgLagPing(),
			'href_history' => GWF_WEB_ROOT.'chat/history',
			'href_webchat' => GWF_WEB_ROOT.'chat',
			'href_ircchat' => GWF_WEB_ROOT.'irc_chat',
			'mibbit_url' => $this->module->cfgMibbitURL(),
			'mibbit' => $this->module->cfgMibbit(),
			'gwf_chat' => $this->module->cfgGWFChat(),
		);
		return $this->module->templatePHP('page.php', $tVars);
	}
	
	public function validate_yournick(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_yournick($this->module, $arg); }
	public function validate_target(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_target($this->module, $arg); }
	public function validate_message(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_message($this->module, $arg); }
	
	private function onPost()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
		$oldnick = $this->module->getNickname();
		$sender = $form->getVar('yournick', $oldnick);
		$target = $form->getVar('target');
		$message = $form->getVar('message');
		
		if ($oldnick === false) {
			$sender = $this->module->getGuestPrefixed($sender);
			$this->module->setGuestNick($sender);
		} else {
			$sender = $oldnick;
		}
		
		if (false === GWF_ChatMsg::newMessage($sender, $target, $message)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$_POST['message'] = '';
		
		return $this->module->message('msg_posted');
	}
}
?>