<?php
final class Konzert_Termin extends GDO
{
	const ENABLED = 0x01;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'konz_termin'; }
	public function getOptionsName() { return 'kt_options'; }
	public function getColumnDefines()
	{
		return array(
			'kt_id' => array(GDO::AUTO_INCREMENT),
			'kt_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_DAY),
			'kt_time' => array(GDO::UINT, GDO::NOT_NULL),
			'kt_city' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'kt_prog' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'kt_tickets' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'kt_location' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'kt_options' => array(GDO::UINT, self::ENABLED),
		);
	}
	
	/**
	 * Get a termin by ID.
	 * @param int $ktid
	 * @return Konzert_Termin
	 */
	public static function getByID($ktid)
	{
		return self::table(__CLASS__)->getRow($ktid);
	}
	
	public function getID()
	{
		return $this->getVar('kt_id');
	}
	
	public function isEnabled()
	{
		return $this->isOptionEnabled(self::ENABLED);
	}
	
	public function hrefEdit()
	{
		return GWF_WEB_ROOT.'index.php?mo=Konzert&me=EditTermin&ktid='.$this->getID();
	}
	
	public function displayDate()
	{
		return GWF_Time::displayDate($this->getVar('kt_date'));
	}
	
	public function displayTime()
	{
		$time = sprintf('%04d', $this->getVar('kt_time'));
		return $time[0].$time[1].':'.$time[2].$time[3];
	}
	
	public function displayTickets()
	{
		$back = '';
		$prog = $this->getVar('kt_prog');
		if (stripos($prog, 'sternstunden') !== false)
		{
			$href = 'http://www.reservix.de/reservation/plan_reservation_back.php?eventID=212083&eventGrpID=57018&presellercheckID=3';
			$back .= GWF_Button::generic('Reservix', $href);
		}
		
		if ($back !== '')
		{
			$back .= '<br/>';
		}
		
		return $back . $this->getVar('kt_tickets');
	}
}
?>