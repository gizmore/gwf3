<?php

final class Chat_Ajax_OLD extends GWF_Method
{
	private static $SESS_AJAX_PUB = 'GWF_CHAT_AJAX1';
	private static $SESS_AJAX_PRIV = 'GWF_CHAT_AJAX2';
	
	public function execute()
	{
		if (false !== Common::getGet('stream')) {
			return $this->startStream($this->_module);
		}
		
		if (false !== (Common::getGet('newprivmsg'))) {
			return $this->onNewPrivmsg($this->_module);
		}
		if (false !== ($timestamp = Common::getGet('newpubmsg'))) {
			return $this->onNewPubmsg($this->_module, intval($timestamp/1000));
		}
		if (false !== ($target = Common::getGet('postto'))) {
			return $this->onPost($this->_module, Common::getGet('nickname'), $target, Common::getGet('message'));
		}
		if (false !== (Common::getGet('online'))) {
			return $this->onGetOnline($this->_module);
		}
	}
	
	private function onNewPrivmsg()
	{
		if (false === ($nick = $this->_module->getNickname())) {
			return;
		}
		
		$msgs = new GWF_ChatMsg(false);
		$nick = $msgs->escape($nick);
		if (false === ($cut = GWF_Session::getOrDefault(self::$SESS_AJAX_PRIV, time()))) {
			return;
		}
		$new = $msgs->select("(chatmsg_to='$nick' OR (chatmsg_from='$nick' AND chatmsg_to!='')) AND chatmsg_time>=$cut", 'chatmsg_time ASC');
		
		foreach ($new as $msg)
		{
			$this->echoMessage($msg);
		}

		GWF_Session::set(self::$SESS_AJAX_PRIV, time());
	}
	
	/**
	 * Send multiple messages, priv or chanel
	 * @param array $msgs 
	 * @param boolean $privmsg priv or channel. 
	 * @return void
	 */
	private function echoMessages(array $msgs, $privmsg)
	{
		foreach ($msgs as $msg)
		{
			$this->echoMessage($msg, $privmsg);
		}
	}

	
	/**
	 * @param $message message
	 * @param $privmsg boolean
	 * @return void
	 */
	private function echoMessage(GWF_ChatMsg $message, $privmsg)
	{
		echo $privmsg ? 'P' : 'C';
		echo $message->getVar('chatmsg_time');
		echo '::';
		echo $message->displayFrom();
		echo '::';
		echo $message->displayTo();
		echo '::';
		echo $message->displayMessage();
		echo PHP_EOL;
	}
	
	private function onNewPubmsg(Module_Chat $module, $timestamp)
	{
		if (false === ($cut = GWF_Session::getOrDefault(self::$SESS_AJAX_PUB, time()))) {
			return;
		}
		$msgs = new GWF_ChatMsg(false);
		$channel = '';
		$new = $msgs->select("chatmsg_to='$channel' AND chatmsg_time>$cut", 'chatmsg_time ASC');
		foreach ($new as $msg)
		{
			$this->echoMessage($msg);
		}
		
		GWF_Session::set(self::$SESS_AJAX_PUB, time());
	}
	
	private function onGetOnline()
	{
		GWF_Javascript::streamHeader();

		$last = time();
		while(true) // as long we have a connection
		{
			$sent_stuff = false;
			$joined = GWF_ChatOnline::getJoined($last);
			$kicked = GWF_ChatOnline::getKicked($last);
			foreach ($joined as $j)
			{
				echo sprintf('+%s'.PHP_EOL, $j->display('chaton_name'));
				$sent_stuff = true;
			}
			foreach ($kicked as $k)
			{
				echo sprintf('-%s'.PHP_EOL, $k->display('chaton_name'));
				$sent_stuff = true;
			}
			$last = time();
			
			if ($sent_stuff) {
				flush();
			}
			
			usleep(500000);
		}
	}
	
	
	private function streamMessageJoin($c, array $array)
	{
		foreach ($array as $online)
		{
			echo sprintf('%s%s'.PHP_EOL, $c, $online->display('chaton_name'));
		}
	}
	
	private function startStream()
	{
		#GWF_ChatOnline::setSessOnline();
		
		GWF_Javascript::streamHeader();
		
		$times = array(
			time(),
			time(),
			time(),
			time(),
		);

		
		$i = 0;
		while($i < 10)
		{
			echo '+Foo'.PHP_EOL;
			
			flush();
//			GWF_Javascript::flush();
			sleep(2);
			$i++;
			continue;
			$stuff_sent = false;
			
			# Get Kick Messages
			$kicked = GWF_ChatOnline::getKicked($times[0]);
			if (count($kicked) > 0)
			{
				$stuff_sent = true;
				$this->streamMessageJoin('-', $kicked);
				$times[0] = time();
			}
			
			# Get Join Messages
			$joined = GWF_ChatOnline::getJoined($times[1]);
			if (count($joined) > 0)
			{
				$stuff_sent = true;
				$this->streamMessageJoin('+', $joined);
				$times[1] = time();
			}
			
			# Get Public Channel Messages
			$msgs = new GWF_ChatMsg(false);
			$channel = '';
			$last = $times[2];
			$pubmsg = $msgs->select("chatmsg_to='$channel' AND chatmsg_time>$last", 'chatmsg_time ASC');
			if (count($pubmsg) > 0)
			{
				$stuff_sent = true;
				$this->echoMessages($pubmsg, false);
				$times[2] = time();
			}
			
			# Get Private Messages
			if (false !== ($nick = $this->_module->getNickname())) {
				$last = $times[3];
				$privmsg = $msgs->select("(chatmsg_to='$nick' OR (chatmsg_from='$nick' AND chatmsg_to!='')) AND chatmsg_time>$last", 'chatmsg_time ASC');
				if (count($privmsg) > 0)
				{
					$stuff_sent = true;
					$this->echoMessages($privmsg, true);
					$times[3] = time();
				}
			}
			
//			if (!$stuff_sent)
//			{
//				usleep(1000000);
				GWF_ChatOnline::setSessOnline($this->_module);
//			}
//			else
//			{
//			}
//			echo '+Foo'.PHP_EOL;

			echo '+Foo'.PHP_EOL;
//			flush();

			GWF_Javascript::flush();
//			flush();
			
			sleep(1);
		}
		
		GWF_ChatOnline::setSessOffline($this->_module);
		
		die();
	}
}

?>