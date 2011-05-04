<?php
final class Lamb_Note extends GDO
{
	const READ = 0x01;
	const FROM_DELETED = 0x04;
	const TO_DELETED = 0x08;
	
	const LIMIT_AMT = 4;     # 4 within
	const LIMIT_TIME = 1;#7200; # 2 hours
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_note'; }
	public function getOptionsName() { return 'lnote_options'; }
	public function getColumnDefines()
	{
		return array(
			'lnote_id' => array(GDO::AUTO_INCREMENT),
			'lnote_from' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lnote_to' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lnote_time' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lnote_msg' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'lnote_options' => array(GDO::UINT|GDO::INDEX, 0),
		);
	}
	
	public function getID() { return $this->getVar('lnote_id'); }
	
	public static function isWithinLimits($from)
	{
		$from = (int)$from;
		$cut = time()-self::LIMIT_TIME;
		$count = self::table(__CLASS__)->countRows("lnote_from=$from AND lnote_time>$cut");
		return $count < self::LIMIT_AMT;
	}
	
	public static function insertNote($from, $to, $message)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'lnote_from' => $from->getID(),
			'lnote_to' => $to->getID(),
			'lnote_time' => time(),
			'lnote_msg' => $message,
			'lnote_options' => 0,
		));
	}
	
	public static function countUnread($to)
	{
		$to = (int)$to;
		return self::table(__CLASS__)->countRows("lnote_to=$to AND lnote_options&1=0");
	}
	
	public static function popNote($to)
	{
		if (false === ($msg = self::table(__CLASS__)->selectFirstObject('*', "lnote_to=$to AND lnote_options&1=0", 'lnote_time ASC'))) {
			return false;
		}
		if (false === $msg->saveOption(self::READ)) {
			return false;
		}
		return $msg;
	}
	
	private function getUsername($id)
	{
		if (false === ($user = Lamb_User::getByID($id))) {
			return "(Unknown:$id)";
		}
		return $user->getName();
	}
	
	public function displayNote(Lamb_Server $server, $viewerid)
	{
		$time = $this->getVar('lnote_time');
		$ago = GWF_Time::humanDurationEN(time()-$time);
		$date = GWF_Time::displayTimestamp($time);
		$from = $this->getVar('lnote_from');
		$to = $this->getVar('lnote_from');
		if ($from == $viewerid) {
			$fromto = 'to';
			$otherid = $to;
		} else {
			$fromto = 'from';
			$otherid = $from;
		}
		$othername = $this->getUsername($otherid);
		$b = chr(2);
		return sprintf($b.'Note %s %s (%s - %s) ago:'.$b.' %s ('.$b.'ID: %s'.$b.')', $fromto, $othername, $date, $ago, $this->getVar('lnote_msg'), $this->getID());
	}
}
?>