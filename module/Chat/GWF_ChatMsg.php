<?php

final class GWF_ChatMsg extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'chatmsg'; }
	public function getOptionsName() { return 'chatmsg_options'; }
	public function getColumnDefines()
	{
		return array(
			'chatmsg_id' => array(GDO::AUTO_INCREMENT),
			'chatmsg_time' => array(GDO::UINT, true),

			'chatmsg_from' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, '', 63),
			'chatmsg_to' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, '', 63),

			'chatmsg_msg' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
#			'chatmsg_options' => array(GDO::UINT, 0),
		);
	}
	public function getID() { return (int) $this->getVar('chatmsg_id'); }
	public function displayFrom() { return GWF_HTML::display($this->getVar('chatmsg_from')); }
	public function displayTo() { return GWF_HTML::display($this->getVar('chatmsg_to')); }
	public function displayMessage()
	{
		$msg = $this->getVar('chatmsg_msg');
		return Module_Chat::isBBCodeAllowedS() ? GWF_Message::display($msg, true, true) : GWF_HTML::display($msg);
	}
	########################
	### Convinent AddRow ###
	########################
	public static function newMessage($sender, $target, $message)
	{
		$msg = new self(array(
			'chatmsg_time' => time(),
			'chatmsg_from' => $sender,
			'chatmsg_to' => $target,
			'chatmsg_msg' => $message,
		));
		if (false === ($msg->insert())) {
			return false;
		}
		return $msg;
	}
	
	#####################
	### Cleanup Table ###
	#####################
	/**
	 * Delete guest messages that have no valid sessid anymore
	 * @return unknown_type
	 */
	public static function cleanupTable()
	{
//		$msgs = new self(false);
//		return $msgs->deleteWhere("chatmsg_to LIKE 'G#%' AND chtmsg_time<$cut");
	}
	
	####################
	### Fake Message ###
	####################
	public static function fakeMessage($from, $to, $message)
	{
		return new self(array(
			'chatmsg_id' => 0,
			'chatmsg_time' => time(),
			'chatmsg_from' => $from,
			'chatmsg_to' => $to,
			'chatmsg_msg' => $message,
		));
	}
}

?>