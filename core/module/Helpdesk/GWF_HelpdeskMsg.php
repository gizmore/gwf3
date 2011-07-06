<?php
/**
 * A helpdesk message that belongs to a ticket.
 * @author gizmore
 */
final class GWF_HelpdeskMsg extends GDO
{
	const READ = 0x01; # read by other
	const FAQ = 0x02;  # this is part of the faq answer
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'helpdesk_msg'; }
	public function getOptionsName() { return 'hdm_options'; }
	public function getColumnDefines()
	{
		return array(
			'hdm_id' => array(GDO::AUTO_INCREMENT),
			'hdm_tid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'hdm_uid' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('GWF_User', 'user_id', 'hdm_uid')),
			'hdm_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'hdm_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL),
			'hdm_options' => array(GDO::UINT, 0),
		);
	}
	
	public static function getByID($id) { return self::table(__CLASS__)->getBy('hdm_id', $id); }
	public function getID() { return $this->getVar('hdm_id'); }
	public function isFAQ() { return $this->isOptionEnabled(self::FAQ); }
	public function hrefFAQ($mode) { return GWF_WEB_ROOT.'index.php?mo=Helpdesk&me=Ticket&message='.$this->getID().'&ticket='.$this->getVar('hdm_tid').'&msgfaq='.$mode; }
	/**
	 * Get the author of this message.
	 * @return GWF_User
	 */
	public function getAuthor() { return $this->getVar('hdm_uid'); }
	public function displayDate() { return GWF_Time::displayDate($this->getVar('hdm_date')); }
	public function displayAuthor() { return $this->getAuthor()->displayProfileLink(); }
	public function displayMessage()
	{
		return GWF_Message::display($this->getVar('hdm_message'));
	}
}
?>