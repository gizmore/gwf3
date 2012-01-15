<?php

final class Chat_Ajax extends GWF_Method
{
	private static $SESS_LAGGY_AJAX = 'GWF_AJAX_CHAT';

	public function execute()
	{
		if (false !== ($target = Common::getGet('postto'))) {
			$back = $this->onPost(Common::getGet('nickname'), $target, Common::getGet('message'));
		}
		if (false !== ($laggy = Common::getGet('browser'))) {
			$back = $this->onAjaxUpdate();
		}

		# Update Nickname
		GWF_ChatOnline::onRequest($this->_module);
		
		return $back;
	}
	
	private function onPost($nickname, $target, $message)
	{
		# Validate the crap!
		if (false !== ($error = GWF_ChatValidator::validate_yournick($this->_module, $nickname))) {
			return $error;
		}
		if (false !== ($error = GWF_ChatValidator::validate_target($this->_module, $target))) {
			$error;
		}
		if (false !== ($error = GWF_ChatValidator::validate_message($this->_module, $message))) {
			return $error;
		}
		
		# Post it!
		$oldnick = $this->_module->getNickname();
		$sender = Common::getPost('yournick', $oldnick);
		$target = trim($target);
		$message = str_replace("\n", '<br/>', Common::getPost('message'));

		if ($oldnick === false) {
			$sender = $this->_module->getGuestPrefixed($sender);
			$this->_module->setGuestNick($sender);
		} else {
			$sender = $oldnick;
		}
		
		if (false === GWF_ChatMsg::newMessage($sender, $target, $message)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return '1';
	}
	
	private function onAjaxUpdate()
	{
		GWF_ChatOnline::onRequest($this->_module);
		$times = $this->getAjaxTimes();
		$back = $this->_module->getAjaxUpdates($times);
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
