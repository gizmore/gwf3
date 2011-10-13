<?php
/**
 * One vote.
 * @author gizmore
 */
final class GWF_VoteScoreRow extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'vote_score_row'; }
	public function getColumnDefines()
	{
		return array(
			'vsr_vsid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'vsr_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'vsr_ip' => GWF_IP6::gdoDefine(GWF_IP_QUICK, 0),
			'vsr_time' => array(GDO::UINT, GDO::NOT_NULL),
			'vsr_score' => array(GDO::INT, GDO::NOT_NULL),
		
			# Join user table
			'users' => array(GDO::JOIN, GDO::NOT_NULL, array('GWF_User', 'vsr_uid', 'user_id')),
		);
	}
	
	public function getScore() { return $this->getVar('vsr_score'); }
	public function isUserVote() { return $this->getVar('vsr_uid') > 0; }
	#####################
	### Static Getter ###
	#####################
	/**
	 * @param int $vsid
	 * @param int $uid
	 * @return GWF_VoteScoreRow
	 */
	public static function getByUID($vsid, $uid)
	{
		$vsid = (int) $vsid;
		$uid = (int) $uid;
		return self::table(__CLASS__)->selectFirstObject('*', "vsr_vsid=$vsid AND vsr_uid=$uid");
	}

	/**
	 * @param int $vsid
	 * @param int $ip
	 * @return GWF_VoteScoreRow
	 */
	public static function getByIP($vsid, $ip)
	{
		$vsid = (int) $vsid;
		$ip = self::escape($ip);
		return self::table(__CLASS__)->selectFirstObject('*', "vsr_vsid=$vsid AND vsr_ip='$ip'");
	}
	
	####################
	### Guest Expire ###
	####################
	public function isGuestVoteExpired($time)
	{
		return $this->getVar('vsr_time') < (time() - $time);
	}
}

?>