<?php
final class WC_Warchall extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_warchall'; }
	public function getColumnDefines()
	{
		return array(
			'wc_id' => array(GDO::AUTO_INCREMENT),
			'wc_boxid' => array(GDO::UINT, GDO::NOT_NULL),
			'wc_level' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 63),
			'wc_score' => array(GDO::UMEDIUMINT, 1),

			'wc_solvers' => array(GDO::UINT, 0),
			'wc_created_at' => array(GDO::DATE, GDO::NOT_NULL, 14),
			'wc_last_solved_at' => array(GDO::DATE, GDO::NULL, 14),
			'wc_last_solved_by' => array(GDO::UINT, GDO::NULL),
				
			'box' => array(GDO::JOIN, GDO::NULL, array('WC_Warbox', 'wc_boxid', 'wb_id')),
			'solver' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'wc_last_solved_by', 'user_id')),
		);
	}
	
	public static function getLevels(WC_Warbox $box)
	{
		return self::table(__CLASS__)->selectAll('*', "wc_boxid={$box->getID()}", '', NULL, -1, -1, GDO::ARRAY_O);
	}
	
	public static function getLevel(WC_Warbox $box, $level)
	{
		$boxid = $box->getID();
		$elevel = self::escape($level);
		if (false !== ($chall = self::table(__CLASS__)->selectFirstObject('*', "wc_boxid={$boxid} AND wc_level='$elevel'", '', '', NULL)))
		{
			return $chall;
		}
		$chall = new self(array(
			'wc_id' => '0',
			'wc_boxid' => $boxid,
			'wc_level' => $level,
			'wc_score' => '1',
			'wc_solvers' => '0',
			'wc_created_at' => GWF_Time::getDate(),
			'wc_last_solved_at' => NULL,
			'wc_last_solved_by' => NULL,
		));
		if (!$chall->replace())
		{
			return false;
		}
		return $chall;
	}
	
	public function setLastSolver(GWF_User $user)
	{
		return $this->saveVars(array(
			'wc_solvers' => $this->getSolverCount(),
			'wc_last_solved_at' => GWF_Time::getDate(),
			'wc_last_solved_by' => $user->getID(),
		));
	}
	
	public function getSolverCount()
	{
		return WC_Warchalls::getSolverCount($this);
	}
	
	public static function getForBoxAndUser(WC_Warbox $box, GWF_User $user, $orderby='')
	{
		$where = "wc_boxid={$box->getID()}";
		$joins = array(
			array('WC_Warchalls', 'wc_id', 'wc_wcid', 'wc_uid', $user->getID()),
		);
		return self::table(__CLASS__)->selectAll('*', $where, $orderby, $joins, -1, -1, GDO::ARRAY_O);
	}
}
?>
