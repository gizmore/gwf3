<?php
final class Lamb_Players extends GDO
{
	###########
	### GDO ###
	###########
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_link'; }
	public function getClassName() { return __CLASS__; }
	public function getColumnDefines()
	{
		return array(
			'll_pid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('SR_Player', 'll_pid', 'sr4pl_id')),
			'll_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'll_lid' => array(GDO::OBJECT, GDO::NOT_NULL, array('Lamb_User', 'll_lid', 'lusr_id')),
		);
	}
	
	public static function ownsPlayer($gwf_uid, $sr_player_id)
	{
		$gwf_uid = (int)$gwf_uid;
		$sr_player_id = (int)$sr_player_id;
		return self::table(__CLASS__)->selectVar('1', "ll_uid={$gwf_uid} AND ll_pid={$sr_player_id}") !== false;
	}
	
	public static function isLinked($sr_player_id)
	{
		return self::table(__CLASS__)->getBy('ll_pid', $sr_player_id) !== false;
	}
	
	public static function link($sr_player_id, $gwf_uid, $lamb_uid)
	{
		return self::table(__CLASS__)->insertAssoc(array('ll_pid'=>$sr_player_id,'ll_uid'=>$gwf_uid,'ll_lid'=>$lamb_uid), true);
	}
}
?>