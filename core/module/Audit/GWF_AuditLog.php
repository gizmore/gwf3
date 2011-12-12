<?php
/**
 * This is one type of log. A complete log has 2 or 3 rows.
 * @author gizmore
 */
final class GWF_AuditLog extends GDO
{
	public static $TYPES = array('script','time','input');
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'audit_log'; }
	public function getColumnDefines()
	{
		return array(
			'al_id' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'al_eusername' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 63),
			'al_username' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 63),
			'al_type' => array(GDO::ENUM, GDO::NOT_NULL, self::$TYPES),
			'al_time_start' => array(GDO::UINT, GDO::NOT_NULL),
			'al_time_end' => array(GDO::UINT, GDO::NULL),
			'al_rand' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 16),
			'al_data' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NULL),
		);
	}
	
	public function getID() { return $this->getVar('al_id'); }
	public function isRoot() { return ($this->getVar('al_eusername') === 'root') || ($this->getVar('al_username') === 'root'); } 
	public function isScript() { return $this->getVar('al_type') === 'script'; }
	public function hrefReplay() { return GWF_WEB_ROOT.sprintf('warplay/%s_%s_%s_%s.html', $this->urlencode('al_eusername'), $this->urlencode('al_username'), $this->getID(), $this->urlencode('al_rand')); }
	public function hrefView() { return GWF_WEB_ROOT.sprintf('warscript/%s_%s_%s_%s.html', $this->urlencode('al_eusername'), $this->urlencode('al_username'), $this->getID(), $this->urlencode('al_rand')); }
	public function displayDate() { return GWF_Time::displayTimestamp($this->getVar('al_time_start')); }
	public function getFileName() { return self::getFilenameS($this->getID()); }
	public static function getFilenameS($id) { return GWF_WWW_PATH.'dbimg/sudosh/'.$id;}
	public function getFileData() { return file_get_contents($this->getFileName()); }
	public function isCompleted() { return $this->getVar('al_time_end') !== NULL; }
	// 	public function displayScriptMail() { return $this->getVar('al_data'); }
	public function getAjaxScript()
	{
		if ($this->isCompleted())
		{
			return json_encode($this->getVar('al_data'));
		}
		else
		{
			return json_encode($this->getFileData());
		}
	}
	
	public function getAjaxTimes()
	{
		if (false === ($log = $this->getTimesLog()))
		{
			return '';
		}
		return $log->getAjaxScript();
	}
	
	/**
	 * Get the times counterpart.
	 * @return GWF_AuditLog
	 */
	public function getTimesLog()
	{
		$time = $this->getVar('al_time_start');
		$rand = GDO::escape($this->getVar('al_rand'));
		return self::table(__CLASS__)->selectFirstObject('*', "al_time_start={$time} AND al_rand='{$rand}' AND al_type='time'");
	}
	
	/**
	 * Get a log by ID.
	 * @param int $id
	 * @return GWF_AuditLog
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
}
?>