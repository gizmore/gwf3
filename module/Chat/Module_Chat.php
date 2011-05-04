<?php
/**
 * Crappy chat module
 * @author gizmore
 * @since 2.0
 */
final class Module_Chat extends GWF_Module
{
	public static $SESS_NICKNAME = 'GWF_CHAT_NICK';
	public static $GUEST_PREFIX = 'G#';
	public function getVersion() { return 1.03; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/chat'); }
//	public function onAddMenu()
//	{
//		if ($this->cfgMenu())
//		{
//			$href = GWF_WEB_ROOT.'chat';
//			$sel = $this->isSelected();
//			if ($this->cfgSubMenu())
//			{
//				GWF_TopMenu::addSubMenu('contact', 'chat', $href, '', $sel);
//			}
//			else
//			{
//				GWF_TopMenu::addMenu('chat', $href, '', $sel);
//			}
//		}
//	}
	
	public function getClasses() { return array('GWF_ChatValidator','GWF_ChatMsg','GWF_ChatOnline'); }
	
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'private' => array('YES', 'bool'),
			'guest_public' => array('YES', 'bool'),
			'guest_private' => array('YES', 'bool'),
			'bbcode' => array('YES', 'bool'),
			'msg_len' => array('512', 'int', '16', '2048'),
			'online_time' => array('20 seconds', 'time', '5', GWF_Time::ONE_DAY*2),
			'message_peak' => array('1 minute', 'time', '5', GWF_Time::ONE_DAY*2),
			'chat_lag_ping' => array('2', 'time', '1', '25'),
			'chanmsg_per_page' => array(5, 'int', '1', '255'),
			'privmsg_per_page' => array(5, 'int', '1', '255'),
			'histmsg_per_page' => array(50, 'int', '1', '255'),
			'chat_menu' => array('YES', 'bool'),
			'chat_submenu' => array('YES', 'bool'),
			'mibbit' => array('YES', 'bool'),
			'mibbit_ssl' => array('YES', 'bool'),
			'mibbit_server' => array('irc.idlemonkeys.net', 'text', 6, 128),
			'mibbit_channel' => array('#wechall', 'text', 1, 64),
			'mibbit_port' => array('7000', 'int', '1', '65535'),
			'gwf_chat' => array('NO', 'bool'),
		));
}
	public function isPrivateAllowed() { return $this->getModuleVar('private', '1') === '1'; }
	public function isPublicAllowedGuests() { return $this->getModuleVar('guest_public', '1') === '1'; }
	public function isPrivateAllowedGuests() { return $this->getModuleVar('guest_private', '1') === '1'; }
	public function isBBCodeAllowed() { return $this->getModuleVar('bbcode', '1') === '1'; }
	public static function isBBCodeAllowedS() { return GWF_Module::getModule('Chat')->isBBCodeAllowed(); }
	public function getMaxMessageLength() { return (int)$this->getModuleVar('msg_len', 512); }
	public function getOnlineTime() { return (int)$this->getModuleVar('online_time', 20); }
	public function getMessagePeak() { return (int)$this->getModuleVar('message_peak', 60); }
	public function getChanmsgPerPage() { return (int)$this->getModuleVar('chanmsg_per_page', 5); }
	public function getPrivmsgPerPage() { return (int)$this->getModuleVar('privmsg_per_page', 5); }
	public function getHistmsgPerPage() { return (int)$this->getModuleVar('histmsg_per_page', 50); }
	public function cfgLagPing() { return (int)$this->getModuleVar('chat_lag_ping', 2); }
	public function cfgMibbit() { return $this->getModuleVar('mibbit', '1') === '1'; }
	public function cfgMibbitPort() { return $this->getModuleVar('mibbit_port', '6667'); }
	public function cfgMibbitServer() { return $this->getModuleVar('mibbit_server', 'irc.idlemonkeys.net'); }
	public function cfgMibbitChannel() { return $this->getModuleVar('mibbit_channel', '#wechall'); }
	public function cfgMibbitSSL() { return $this->getModuleVar('mibbit_ssl', '1') === '1'; }
	
	#https://embed.mibbit.com/?server=storm.psych0tik.net%3A%2B6697&channel=%23hbh&forcePrompt=true
	public function cfgMibbitURL()
	{
		return self::getMibbitURL2($this->cfgMibbitServer(), $this->cfgMibbitPort(), $this->cfgMibbitChannel(), $this->cfgMibbitSSL());
	}
	
	public static function getMibbitURL($url)
	{
		if (1 !== preg_match('/^(ircs?):\/\/([^\\/:#]+):?(\\d+)?\/?(#.+)?$/', $url, $matches)) {
			return false;
		}
		$ssl = $matches[1] === 'ircs';
		$port = isset($matches[3]) ? $matches[3] : '';
		$channel = isset($matches[4]) ? $matches[4] : '#help';
		$port = self::filterPort($port, $ssl);
		return self::getMibbitURL2($matches[2], $port, $channel, $ssl);
	}
	
	private static function filterPort($port, $is_ssl)
	{
		if ($port === '') {
			return $is_ssl ? 7000 : 6667;
		}
		else {
			return intval($port);
		}
	}
	
	public static function getMibbitURL2($server, $port, $channel, $ssl)
	{
		return sprintf('http%s://embed.mibbit.com/?server=%s%%3A%s%d&channel=%s&noServerNotices=true&noServerMotd=true&forcePrompt=true',
			($ssl ? 's' : ''),
			$server,
			($ssl ? '%2B' : ''),
			$port,
			urlencode($channel)
		);
	}
	
	public function cfgGWFChat() { return $this->getModuleVar('gwf_chat', true); }
	public function cfgIRCURL()
	{
		$is_ssl = $this->cfgMibbitSSL();
		return sprintf('irc%s://%s:%d%s',
			($is_ssl ? 's' : ''),
			$this->cfgMibbitServer(),
			$this->cfgMibbitPort(),
			$this->cfgMibbitChannel()
		);
	}
	#############
	### Stuff ###
	#############
	/**
	 * Get the users nickname. Guests can choose their nick once per session.
	 * Returns false if no nick has been set yet.
	 * @return string or false
	 */
	public function getNickname()
	{
		if (false !== ($user = GWF_Session::getUser())) {
			return $user->getVar('user_name');
		}
		return GWF_Session::getOrDefault(self::$SESS_NICKNAME, false);
	}
	
	public function setGuestNick($nick)
	{
		GWF_Session::set(self::$SESS_NICKNAME, $nick);
	}
	
	public function getGuestPrefixed($nick)
	{
		return sprintf('%s%s', self::$GUEST_PREFIX, $nick);
	}
	
	/**
	 * Check if user is a guest. If so check if he may post into public channels.
	 * @return boolean
	 */
	public function checkGuestPublic()
	{
		if (false !== ($user = GWF_Session::getUser())) {
			return true;
		}
		return $this->isPublicAllowedGuests();
	}

	/**
	 * Check if user is a guest. If so check if he may post private messages.
	 * @return boolean
	 */
	public function checkGuestPrivate()
	{
		if (false !== ($user = GWF_Session::getUser())) {
			return true;
		}
		return $this->isPrivateAllowedGuests();
	}

	##################
	### On Startup ###
	##################
//	public function onStartup()
//	{
//		$append = '';
//		GWF_TopMenu::addMenu('chat', '/chat', $append, $this->isMethodSelected('Page'));
//	}
	
	###############################
	### Execute a chat function ###
	###############################
//	public function onRequest()
//	{
//		return parent::onRequest().GWF_ChatOnline::onRequest($this);
//	}
	
	####################
	### Get Messages ###
	####################
	public function getChannelMessages($channel='')
	{
		$cut = time() - $this->getOnlineTime();
		$min = $this->getChanmsgPerPage();
		$msgs = new GWF_ChatMsg(false);
		$channel = $msgs->escape($channel);
		$backA = $msgs->select("chatmsg_to='$channel' AND chatmsg_time>$cut", 'chatmsg_time DESC'); #, 'chatmsg_time', 'DESC', $this->getChanmsgPerPage());
		$countA = count($backA);
		if ($countA < $min) {
			$backB = $msgs->select("chatmsg_to='$channel'", 'chatmsg_time DESC', $min-$countA, $countA);
		} else {
			$backB = array();
		}
		return array_reverse(array_merge($backA, $backB));
	}
	public function getPrivateMessages()
	{
		if (false === ($nick = $this->getNickname())) {
			return array();
		}
		
		$cut = time() - $this->getOnlineTime();
		$min = $this->getPrivmsgPerPage();
		$msgs = new GWF_ChatMsg(false);
		$nick = $msgs->escape($nick);
		$backA = $msgs->select("(((chatmsg_to='$nick') OR (chatmsg_from='$nick' AND chatmsg_to!='')) AND chatmsg_time>=$cut)", 'chatmsg_time DESC');
		$countA = count($backA);
		if ($countA < $min) {
			$backB = $msgs->select("(chatmsg_to='$nick' OR (chatmsg_from='$nick' AND chatmsg_to!=''))", 'chatmsg_time DESC', $min-$countA, $countA);
		} else {
			$backB = array();
		}
		return array_reverse(array_merge($backA, $backB));
	}
	public function getOnlineUsers()
	{
		return GWF_ChatOnline::getOnlineUsers();
	}
	
	##########################
	### Guest name taken ? ###
	##########################
	public function isNameTaken($guestname)
	{
		$chaton = new GWF_ChatMsg(false);
		$name = $chaton->escape($guestname);
		return $chaton->selectFirst("chatmsg_from='$name'") !== false;
	}
	
	#######################
	### Validate Target ###
	#######################
	public function targetExists($target)
	{
		if ($target === '') {
			return true;
		}
		if (Common::startsWith($target, self::$GUEST_PREFIX)) {
			return $this->isNameTaken($target);
		}
		return GWF_User::getByName($target) !== false;
	}
	
	public function targetValid($target)
	{
		if ($target === $this->getNickname()) {
			return false;
		}
		return true;
	}
	
	###############
	### History ###
	###############
	/**
	 * Filter a channel through whitelist.
	 * This checks if a history exists for a user and a src.
	 * @param $channel string wanted channel
	 * @return string 
	 */
	public function getWhitelistedChannel($channel)
	{
		if ($channel === '') {
			return ''; # Public is allways allowed
		}
		if (false === ($nick = $this->getNickname())) {
			return ''; # No Nick => only public
		}

		$msgs = new GWF_ChatMsg(false);
		$enick = $msgs->escape($nick);
		$echannel = $msgs->escape($channel);
		if (false === ($msgs->selectFirst("(chatmsg_to='$enick' AND chatmsg_from='$echannel') OR (chatmsg_from='$enick' AND chatmsg_to='$echannel')"))) {
			return ''; # Does not exist
		}
		return $channel; # All fine!
	}

	private function getHistoryCondition($channel)
	{
		if ($channel === '') {
			$condition = "chatmsg_to=''";
		} else {
			if (false === ($nick = $this->getNickname())) {
				return 0;
			}
			$msgs = gdo_db();
			$channel = $msgs->escape($channel);
			$enick = $msgs->escape($nick);
			$condition = "(chatmsg_from='$channel' AND chatmsg_to='$enick') OR (chatmsg_to='$channel' AND chatmsg_from='$enick')";
		}
		return $condition;
	}
	
	/**
	 * Count available messages for the history.
	 * @param $channel
	 * @return unknown_type
	 */
	public function countHistoryMessages($channel)
	{
		$msgs = new GWF_ChatMsg(false);
		$condition = $this->getHistoryCondition($channel);
		return $msgs->countRows($condition);
	}
	
	public function getFriends()
	{
		if (false === ($nick = $this->getNickname())) {
			return array();
		}
		$msgs = new GWF_ChatMsg(false);
		$enick = $msgs->escape($nick);
		$to = $msgs->selectColumn('chatmsg_to', "(chatmsg_from='$enick' AND chatmsg_to!='')");
		$from = $msgs->selectColumn('chatmsg_from', "chatmsg_to='$enick'");
		$all = $to + $from;
		return $all;
	}
	
	public function getHistoryMessages($channel, $page)
	{
		$msgs = new GWF_ChatMsg(false);
//		$channel = $msgs->escape($channel);
		$ipp = $this->getHistmsgPerPage();
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$conditions = $this->getHistoryCondition($channel);
		return $msgs->select($conditions, 'chatmsg_time ASC', $ipp, $from);
	}
	
	#####################
	### AJAX Protocol ###
	#####################
	public function getAjaxUpdates(array &$times)
	{
		$msgtable = GDO::table('GWF_ChatMsg');
		
		$page = '';
		$now = time();
			
		# Get Kick Messages
		$kicked = GWF_ChatOnline::getKicked($times[0]);
		if (count($kicked) > 0)
		{
			$page .= $this->getJoinMessages('-', $kicked);
			$times[0] = $now;
		}

		# Get Join Messages
		$joined = GWF_ChatOnline::getJoined($times[1]);
		if (count($joined) > 0)
		{
			$page .= $this->getJoinMessages('+', $joined);
			$times[1] = $now;
		}
		
		# Get Public Channel Messages
		$last = $times[2];
		$pubmsg = $msgtable->select("chatmsg_to='' AND chatmsg_time>$last", 'chatmsg_time', 'ASC');
		if (count($pubmsg) > 0)
		{
			$page .= $this->getMessages($pubmsg, false);
			$times[2] = $now;
		}
		
		# Get Private Messages
		if (false !== ($nick = $this->getNickname()))
		{
			$last = $times[3];
			$nick = $msgtable->escape($nick);
			$privmsg = $msgtable->select("(chatmsg_to='$nick' OR (chatmsg_from='$nick' AND chatmsg_to!='')) AND chatmsg_time>$last", 'chatmsg_time ASC');
			if (count($privmsg) > 0)
			{
				$page .= $this->getMessages($privmsg, true);
				$times[3] = $now;
			}
		}
		
		return $page;
	}	

	private function getJoinMessages($cmd, array $chatonline)
	{
		$back = '';
		foreach ($chatonline as $online)
		{
			$back .= sprintf("%s%s\n", $cmd, $online->display('chaton_name'));
		}
		return $back;
	}
	
	private function getMessages(array $msgs, $privmsg)
	{
		$back = '';
		$cmd = $privmsg === true ? 'P' : 'C';
		foreach ($msgs as $msg)
		{
//			$msg instanceof GWF_ChatMsg;
			$message = $msg->displayMessage();
			$back .= sprintf("%s%s:%s:%s:%d:%s\n", $cmd, $msg->getVar('chatmsg_time'), $msg->displayFrom(), $msg->displayTo(), strlen($message), $message);
		}
		return $back;
	}
	
	#############
	### Boxed ###
	#############
	public function templateBoxed()
	{
		$this->onInclude();
		$form = $this->getFormBoxed();
		$tVars = array(
			'form' => $form->templateY('', $this->getMethodURL('Page')),
			'msgs' => $this->getChannelMessages(''),
		);
		return $this->templatePHP('boxed.php', $tVars);
	}
	
	private function getFormBoxed()
	{
		$data = array();
		if (false === ($nick = $this->getNickname())) {
			$data['yournick'] = array(GWF_Form::STRING, '', $this->lang('th_yournick'), 24);
		} else {
			$data['yournick'] = array(GWF_Form::SSTRING, $nick, $this->lang('th_yournick'), 24);
		}
		$data['target'] = array(GWF_Form::HIDDEN, '', '');
		$data['message'] = array(GWF_Form::STRING, '', $this->lang('th_message'), 24);
		$data['post'] = array(GWF_Form::SUBMIT, $this->lang('btn_post'), '');
		return new GWF_Form($this->getMethod('Page'), $data);
	}
}

?>
