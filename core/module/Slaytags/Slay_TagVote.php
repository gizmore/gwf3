<?php
final class Slay_TagVote extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'slay_tagvote'; }
	public function getColumnDefines()
	{
		return array(
			'stv_uid' => array(GDO::UINT|GDO::PRIMARY_KEY), # user
			'stv_sid' => array(GDO::UINT|GDO::PRIMARY_KEY), # song
			'stv_tid' => array(GDO::UINT|GDO::PRIMARY_KEY), # tag
			'stv_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND), # when
		
			'tags' => array(GDO::JOIN, GDO::NULL, array('Slay_Tag', 'st_id', 'stv_tid')),
			'songs' => array(GDO::JOIN, GDO::NULL, array('Slay_Song', 'ss_id', 'stv_sid')),
		);
	}
	
	public static function getTags(Slay_Song $song)
	{
		$sid = $song->getID();
		return self::table(__CLASS__)->selectColumn('DISTINCT(st_name)', "stv_sid={$sid}", 'st_name ASC', array('tags'));
	}
	
	public static function hasVoted(Slay_Song $song, GWF_User $user)
	{
		$sid = $song->getID();
		$uid = $user->getID();
		return self::table(__CLASS__)->selectFirst('1', "stv_sid=$sid AND stv_uid=$uid") !== false;
	}
	
	public static function getVotes(Slay_Song $song, GWF_User $user)
	{
		$sid = $song->getID();
		$uid = $user->getID();
		return self::table(__CLASS__)->selectColumn('st_name', "stv_sid=$sid AND stv_uid=$uid", 'st_name ASC', array('tags'));
	}
	
	public static function clearVotes(Slay_Song $song, GWF_User $user)
	{
		$uid = $user->getID();
		$sid = $song->getID();
		return self::table(__CLASS__)->deleteWhere("stv_uid={$uid} AND stv_sid={$sid}");
	}
	
	public static function addVotes(Slay_Song $song, GWF_User $user, array $tags)
	{
		$uid = $user->getID();
		$sid = $song->getID();
		$date = GWF_Time::getDate(GWF_Date::LEN_SECOND);
		$table = self::table(__CLASS__);
		foreach ($tags as $tag)
		{
			if (false === ($tid = Slay_Tag::getIDByName($tag)))
			{
				return false;
			}
			if (false === $table->insertAssoc(array(
				'stv_uid' => $uid,
				'stv_sid' => $sid,
				'stv_tid' => $tid,
				'stv_date' => $date,
			), false))
			{
				return false;
			}
		}
		return true;
	}
	
	public static function countVotes($sid, $tid)
	{
		$sid = (int)$sid;
		$tid = (int)$tid;
		return self::table(__CLASS__)->countRows("stv_sid={$sid} AND stv_tid={$tid}");
	}
	
	public static function countTaggers(Slay_Song $song)
	{
		$sid = $song->getID();
		return self::table(__CLASS__)->selectVar('COUNT(DISTINCT(stv_uid))', "stv_sid={$sid}");
	}
}
?>