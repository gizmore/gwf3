<?php
/**
 * A helpdesk ticket.
 * @author gizmore
 */
final class GWF_HelpdeskTicket extends GDO
{
	const STAFF_READ = 0x01;
	const USER_READ = 0x02;
	const EMAIL_ME = 0x04;
	const ALLOW_FAQ = 0x08;
	const VISIBLE_FAQ = 0x10;
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'helpdesk_ticket'; }
	public function getOptionsName() { return 'hdt_options'; }
	public function getColumnDefines()
	{
		return array(
			'hdt_id' => array(GDO::AUTO_INCREMENT),
			'hdt_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'hdt_worker' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'hdt_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'hdt_title' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 63),
			'hdt_other' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL),
			'hdt_priority' => array(GDO::UINT, 0),
			'hdt_status' => array(GDO::ENUM, 'open', array('open', 'working', 'solved', 'unsolved')),
			'hdt_options' => array(GDO::UINT, 0),

			'worker' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'worker.user_id', 'hdt_worker')),
			'creator' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'creator.user_id', 'hdt_uid')),
		);
	}
	public function getID() { return $this->getVar('hdt_id'); }
	public function getCreatorID() { return $this->getVar('hdt_uid'); }
	public function getWorkerID() { return $this->getVar('hdt_worker'); }
	public function getPriority() { return $this->getVar('hdt_priority'); }
	public function getStatus() { return $this->getVar('hdt_status'); }
	public function isOpen() { return $this->getStatus() === 'open'; }
	public function isClosed() { return $this->getStatus() === 'solved'; }
	public function isFAQ() { return $this->isOptionEnabled(self::ALLOW_FAQ); }
	public function isInFAQ() { return $this->isOptionEnabled(self::VISIBLE_FAQ); }
	public function hasStaffRead() { return $this->isOptionEnabled(self::STAFF_READ); }
	public function hasUserRead() { return $this->isOptionEnabled(self::USER_READ); }
	
	public function hasPermission(GWF_User $user)
	{
		if ($user->getID() === $this->getVar('hdt_uid')) {
			return true;
		}
		if ($user->isStaff() || $user->isAdmin()) {
			return true;
		}
		return false; 
	}
	
	/**
	 * Get a ticket by id.
	 * @param int $ticketid
	 * @return GWF_HelpdeskTicket
	 */
	public static function getByID($ticketid) { return self::table(__CLASS__)->getBy('hdt_id', $ticketid); }
	
	/**
	 * Get the staff member that is assigned to work on this ticket.
	 * @return GWF_User
	 */
	public function getWorker() { return GWF_User::getByID($this->getVar('hdt_worker')); }
	
	/**
	 * Get the creator of this ticket.
	 * @return GWF_User
	 */
	public function getCreator() { return GWF_User::getByID($this->getVar('hdt_uid')); }
	
	###############
	### Display ###
	###############
	public function displayTitle(GWF_User $user)
	{
		$t = $this->getVar('hdt_title');
		if ($t === 'other') {
			return htmlspecialchars($this->getVar('hdt_other'));
		}
		
		$helpdesk = GWF_Module::getModule('Helpdesk');
		$titles = $helpdesk->langUser($user, 'titles');
		if (!isset($titles[$t])) {
			return 'MISSING: '.$t;
		}
		return $titles[$t];
	}
	
	public function displayStatus() { return GWF_Module::getModule('Helpdesk')->lang('status_'.$this->getStatus()); }
	
	public function displayShowLink($text)
	{
		$id = $this->getID();
		return GWF_HTML::anchor(GWF_WEB_ROOT.'index.php?mo=Helpdesk&me=Ticket&ticket='.$id, $text, 'Ticket #'.$id);
	}
}
?>