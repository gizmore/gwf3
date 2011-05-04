<?php
/**
 * GWF Chat Page
 * @author gizmore
 */
final class Chat_Page extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return $this->getHTAccessMethod();
	}
	
	public function execute(GWF_Module $module)
	{
		GWF_ChatOnline::onRequest($module);
		
		GWF_Website::setPageTitle($module->lang('pt_chat'));
		GWF_Website::setMetaTags($module->lang('mt_chat'));
				
		GWF_Website::addJavascript($module->getModuleFilePath('js/gwf_chat.js?v=3'));
//		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/gwf_core.js?v=2');
		
		if (false !== (Common::getPost('post'))) {
			return $this->onPost($module).$this->templatePage($module);
		}
		return $this->templatePage($module);
	}
	
	private function getForm(Module_Chat $module)
	{
		$data = array();
		if (false === ($nick = $module->getNickname())) {
			$data['yournick'] = array(GWF_Form::STRING, '', $module->lang('th_yournick'), 24);
		} else {
			$data['yournick'] = array(GWF_Form::SSTRING, $nick, $module->lang('th_yournick'), 24);
		}
		$data['target'] = array(GWF_Form::STRING, '', $module->lang('th_target'), 24);
		$data['message'] = array(GWF_Form::STRING, '', $module->lang('th_message'), 64);
		$data['post'] = array(GWF_Form::SUBMIT, $module->lang('btn_post'), '');
		return new GWF_Form($this, $data);
	}
	
	private function templatePage(Module_Chat $module)
	{
		$form = $this->getForm($module);
		
		if (false === ($nick = $module->getNickname())) {
			$nick = '';
		}
		
		// Focus input by js
		$focus = GWF_Session::isLoggedIn() ? 'message' : 'yournick';
		GWF_Javascript::focusElementByName($focus);
		
		
		$tVars = array(
			'form' => $form->templateX(),
			'msgs' => $module->getChannelMessages(),
			'privmsgs' => $module->getPrivateMessages(),
			'online' => $module->getOnlineUsers(),
			'maxmsg_pub' => $module->getChanmsgPerPage(),
			'maxmsg_priv' => $module->getPrivmsgPerPage(),
			'nickname' => $nick,
			'onlinetime' => $module->getOnlineTime(),
			'peaktime' => $module->getMessagePeak(),
			'lagtime' => $module->cfgLagPing(),
			'href_history' => GWF_WEB_ROOT.'chat/history',
			'href_webchat' => GWF_WEB_ROOT.'chat',
			'href_ircchat' => GWF_WEB_ROOT.'irc_chat',
			'mibbit_url' => $module->cfgMibbitURL(),
			'mibbit' => $module->cfgMibbit(),
			'gwf_chat' => $module->cfgGWFChat(),
		);
		return $module->templatePHP('page.php', $tVars);
	}
	
	public function validate_yournick(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_yournick($module, $arg); }
	public function validate_target(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_target($module, $arg); }
	public function validate_message(Module_Chat $module, $arg) { return GWF_ChatValidator::validate_message($module, $arg); }
	
	private function onPost(Module_Chat $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		$oldnick = $module->getNickname();
		$sender = $form->getVar('yournick', $oldnick);
		$target = $form->getVar('target');
		$message = $form->getVar('message');
		
		if ($oldnick === false) {
			$sender = $module->getGuestPrefixed($sender);
			$module->setGuestNick($sender);
		} else {
			$sender = $oldnick;
		}
		
		if (false === GWF_ChatMsg::newMessage($sender, $target, $message)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$_POST['message'] = '';
		
		return $module->message('msg_posted');
	}
}
?>