<?php
final class WC_Warflags extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_warflags'; }
	public function getColumnDefines()
	{
		return array(
			'wf_wfid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'wf_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			
			'wf_solved_at' => array(GDO::DATE, GDO::NULL, 14),
			'wf_attempts' => array(GDO::UMEDIUMINT, 1),
			'wf_last_attempt' => array(GDO::UINT|GDO::INDEX, GDO::NULL),

			# Join
			'flag' => array(GDO::JOIN, GDO::NULL, array('WC_Warflag', 'wf_wfid', 'wf_id')),
			'flagbox' => array(GDO::JOIN, GDO::NULL, array('WC_Warbox', 'wf_wbid', 'wb_id')),
			'flagsite' => array(GDO::JOIN, GDO::NULL, array('WC_Site', 'wb_sid', 'site_id')),
			'solvers' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'user_id', 'wf_uid')),
		);
	}
	
	public static function getSolvecount(WC_Warflag $flag)
	{
		return self::table(__CLASS__)->countRows("wf_wfid={$flag->getID()} AND wf_solved_at IS NOT NULL");
	}
	
	public static function getPlayercount(WC_Warbox $box)
	{
		return self::table(__CLASS__)->selectVar('COUNT(DISTINCT(wf_uid))', "wf_wbid={$box->getID()} AND wf_solved_at IS NOT NULL", '', array('flag', 'flagbox'));
	}
	
	public static function getPlayercountForSite(WC_Site $site)
	{
		return self::table(__CLASS__)->selectVar('COUNT(DISTINCT(wf_uid))', "wb_sid={$site->getID()} AND wf_solved_at IS NOT NULL", '', array('flag', 'flagbox', 'flagsite'));
	}
	
	public static function getByFlagUser(WC_Warflag $flag, GWF_User $user)
	{
		return self::table(__CLASS__)->selectFirstObject('*', "wf_wfid={$flag->getID()} AND wf_uid={$user->getID()}");
	}
	
	public static function hasSolved(WC_Warflag $flag, GWF_User $user)
	{
		return self::table(__CLASS__)->selectVar('1', "wf_wfid={$flag->getID()} AND wf_uid={$user->getID()} AND wf_solved_at IS NOT NULL") !== false;
	}
	
	public static function getLastAttemptTime(GWF_User $user)
	{
		return self::table(__CLASS__)->selectVar('MAX(wf_last_attempt)', 'wf_uid='.$user->getID());
	}

	public static function insertFailure(WC_Warflag $flag, GWF_User $user)
	{
		if (false !== ($entry = self::getByFlagUser($flag, $user)))
		{
			return $entry->saveVars(array(
				'wf_attempts' => $entry->getVar('wf_attempts') + 1,
				'wf_last_attempt' => time(),
			));
		}
		return self::table(__CLASS__)->insertAssoc(array(
			'wf_wfid' => $flag->getID(),
			'wf_uid' => $user->getID(),
			'wf_solved_at' => NULL,
			'wf_attempts' => '1',
			'wf_last_attempt' => time(),
		));
	}
	
	public static function insertSuccess(WC_Warflag $flag, GWF_User $user)
	{
		if (false !== ($entry = self::getByFlagUser($flag, $user)))
		{
			return $entry->saveVars(array(
				'wf_attempts' => $entry->getVar('wf_attempts') + 1,
				'wf_last_attempt' => NULL,
				'wf_solved_at' => GWF_Time::getDate(),
			));
		}
		return self::table(__CLASS__)->insertAssoc(array(
			'wf_wfid' => $flag->getID(),
			'wf_uid' => $user->getID(),
			'wf_solved_at' => GWF_Time::getDate(),
			'wf_attempts' => '1',
			'wf_last_attempt' => NULL,
		));
	}
}
