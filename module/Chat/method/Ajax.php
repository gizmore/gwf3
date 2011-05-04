<?php

final class Chat_Ajax extends GWF_Method
{
	private static $SESS_LAGGY_AJAX = 'GWF_AJAX_CHAT';

	public function execute(GWF_Module $module)
	{
		if (false !== ($target = Common::getGet('postto'))) {
			$back = $this->onPost($module, Common::getGet('nickname'), $target, Common::getGet('message'));
		}
		if (false !== ($laggy = Common::getGet('browser'))) {
			$back = $this->onAjaxUpdate($module);
		}

		# Update Nickname
		GWF_ChatOnline::onRequest($module);
		
		return $back;
	}
	
	private function onPost(Module_Chat $module, $nickname, $target, $message)
	{
		# Validate the crap!
		if (false !== ($error = GWF_ChatValidator::validate_yournick($module, $nickname))) {
			return $error;
		}
		if (false !== ($error = GWF_ChatValidator::validate_target($module, $target))) {
			$error;
		}
		if (false !== ($error = GWF_ChatValidator::validate_message($module, $message))) {
			return $error;
		}
		
		# Post it!
		$oldnick = $module->getNickname();
		$sender = Common::getPost('yournick', $oldnick);
		$target = trim($target);
		$message = str_replace("\n", '<br/>', Common::getPost('message'));

		if ($oldnick === false) {
			$sender = $module->getGuestPrefixed($sender);
			$module->setGuestNick($sender);
		} else {
			$sender = $oldnick;
		}
		
		if (false === GWF_ChatMsg::newMessage($sender, $target, $message)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return '1';
	}
	
	private function onAjaxUpdate(Module_Chat $module)
	{
		GWF_ChatOnline::onRequest($module);
		$times = $this->getAjaxTimes();
		$back = $module->getAjaxUpdates($times);
		self::saveAjaxTimes($times);
		return $back;
	}
	
	private function getAjaxTimes()
	{
		return GWF_Session::getOrDefault(self::$SESS_LAGGY_AJAX, array(time(),time(),time(),time()));
	}
	
	private function saveAjaxTimes(array $times)
	{
		GWF_Session::set(self::$SESS_LAGGY_AJAX, $times);
	}
}

?>